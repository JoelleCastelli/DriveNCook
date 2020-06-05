<?php


namespace App\Traits;


use App\Charts\FranchiseeStatsChart;
use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Models\Pseudo;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use App\Models\SoldDish;
use App\Models\Truck;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait UserTools
{
    use EnumValue;

    public function get_franchisee_by_id($id)
    {
        $user = User::with('pseudo')->where('id', $id)->first();
        if (!empty($user))
            return $user->toArray();
        return null;
    }

    public function update_user_password($id, $new_password)
    {
        User::find($id)->update([
            'password' => hash('sha256', $new_password)
        ]);
    }

    public function delete_user($id)
    {
        User::find($id)->delete();
    }

    public function get_connected_user()
    {
        if (auth()->guest()) {
            return null;
        }
        return auth()->user()->toArray();
    }

    public function does_have_assigned_truck($user_id): bool
    {
        $truck = Truck::with('location')
            ->where('user_id', $user_id)
            ->count();
        return $truck == 1;
    }

    public function get_current_obligation()
    {
        return FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
    }

    public function get_available_pseudo_list()
    {
        $unavailable_pseudos = User::whereNotNull('pseudo_id')->get(['pseudo_id'])->toArray();
        $pseudos = Pseudo::whereNotIn('id', $unavailable_pseudos)->get()->toArray();

        return $pseudos;
    }

    public function get_franchisee_activity_period($franchisee_id) {
        $franchisee = $this->get_franchisee_by_id($franchisee_id);
        $franchisee_activity_period = [];
        $begin = DateTime::createFromFormat("Y-m-d H:i:s", $franchisee['created_at']);
        $end = new DateTime( 'now' );
        $daterange = new DatePeriod($begin, new DateInterval('P1M'), $end);
        foreach($daterange as $date){
            $franchisee_activity_period[$date->format("Y")][] = $date->format("m");
        }
        return $franchisee_activity_period;
    }

    public function is_franchisee_valided($franchisee_id): ?bool
    {
        $franchise = User::whereKey($franchisee_id)->first();
        if ($franchise == null) {
            return null;
        }
        $franchise = $franchise->toArray();

        return $franchise['role'] == "Franchisé"
            && !empty($franchise['driving_licence'])
            && !empty($franchise['social_security'])
            && !empty($franchise['telephone'])
            && !empty($franchise['pseudo_id']);
    }

    // INVOICES
    public function create_invoice_reference($prefix, $franchisee_id, $invoice_id)
    {
        $reference_start = $prefix . '-' . $franchisee_id . '-';
        $column_type = DB::select(DB::raw("SHOW COLUMNS FROM invoice WHERE Field = 'reference'"))[0]->Type;
        $column_length = substr(ltrim($column_type, 'varchar('), 0, -1);
        $pad_length = $column_length - strlen($reference_start);
        $reference = $reference_start . str_pad($invoice_id, $pad_length, "0", STR_PAD_LEFT);
        Invoice::where('id', $invoice_id)->update(['reference' => $reference]);
        return $reference;
    }

    public function generate_first_invoice($franchisee_id)
    {
        $current_obligation = $this->get_current_obligation();
        $invoice = ['amount' => $current_obligation['entrance_fee'],
            'date_emitted' => date("Y-m-d"),
            'monthly_fee' => 0,
            'initial_fee' => 1,
            'user_id' => $franchisee_id];
        $invoice = Invoice::create($invoice);
        $reference = $this->create_invoice_reference('IF', $franchisee_id, $invoice['id']);
        $this->save_franchisee_invoice_pdf($invoice['id'], $reference);
    }

    public function franchisee_invoice_pdf($id)
    {
        $purchase_order = [];
        $invoice = Invoice::with('user')->where('id', $id)->first()->toArray();
        $pseudo = Pseudo::where('id', $invoice['user']['pseudo_id'])->first();
        if (!empty($pseudo))
            $pseudo->toArray();
        if ($invoice['purchase_order_id']) {
            $purchase_order = PurchaseOrder::with('purchased_dishes')
                ->where('id', $invoice['purchase_order_id'])
                ->first()->toArray();
        }

        return $pdf = PDF::loadView('franchisee_invoice', ['invoice' => $invoice,
            'pseudo' => $pseudo,
            'purchase_order' => $purchase_order]);
    }

    public function stream_franchisee_invoice_pdf($id)
    {
        $pdf = $this->franchisee_invoice_pdf($id);
        return $pdf->stream();
    }

    public function save_franchisee_invoice_pdf($id, $reference)
    {
        $pdf = $this->franchisee_invoice_pdf($id);
        if (strpos($reference, 'IF') !== FALSE) {
            $path = resource_path('invoices/franchisee_initial_fee/');
        } elseif (strpos($reference, 'MF') !== FALSE) {
            $path = resource_path('invoices/franchisee_monthly_fee/');
        } else if (strpos($reference, 'RS') !== FALSE) {
            $path = resource_path('invoices/franchisee_restock/');
        }

        return $pdf->save($path . '/' . $reference . '.pdf');
    }

    public function get_invoicing_period($current_obligation, $date_format)
    {

        // First day of billing period : next payment date - 1 month
        // Last day of billing period : next payment date - 1 day
        $next_payment_date = DateTime::createFromFormat("d/m/Y", $this->get_next_payment_date($this->get_current_obligation()));
        $period_end_date = $next_payment_date->setTime(23, 59, 59);
        $period_start_date = clone $period_end_date;
        $period_start_date->modify('-1 month');
        $period_end_date->modify('-1 day');
        $period_end_date = $period_end_date->format($date_format);
        $period_start_date = $period_start_date->format($date_format);

        return [
            'period_start_date' => $period_start_date,
            'period_end_date' => $period_end_date
        ];

    }

    // STATS AND REVENUES
    public function get_next_payment_date($franchiseObligation)
    {
        $currentDay = new DateTime();
        $currentDay->setDate(date('Y'), date('m'), date('d'));

        if ($currentDay->format('d') < $franchiseObligation['billing_day']) {
            return $currentDay
                ->setDate(date('Y'), date('m'), $franchiseObligation['billing_day'])
                ->format('d/m/Y');
        }
        return $currentDay
            ->setDate(date('Y'), date('m'), $franchiseObligation['billing_day'])
            ->modify('+1 month')
            ->format('d/m/Y');
    }

    public function get_franchise_current_month_sale_revenues($franchise_id)
    {
        $franchise_obligation = $this->get_current_obligation();
        $invoicing_period = $this->get_invoicing_period($franchise_obligation, "Y/m/d");
        $sales = $this->get_franchisee_sales($franchise_id, $invoicing_period['period_start_date'], $invoicing_period['period_end_date']);
        $sales_total = 0;
        if ($sales) {
            foreach ($sales as $sale) {
                foreach ($sale['sold_dishes'] as $sold_dish) {
                    $sales_total += $sold_dish['quantity'] * $sold_dish['unit_price'];
                }
            }
        }

        $next_invoice = $sales_total * $franchise_obligation['revenue_percentage'] / 100;

        return array(
            "sales_total" => $sales_total,
            "sales_count" => count($sales),
            "next_invoice" => $next_invoice
        );
    }

    public function get_franchisee_history($franchisee_id)
    {

        // Definition of min and max dates
        $user = $this->get_franchisee_by_id($franchisee_id);
        $creation_date = DateTime::createFromFormat("Y-m-d H:i:s", $user['created_at'])->format('Y-m-d');
        $today = date("Y-m-d");

        // Total of invoices
        $invoices = Invoice::where('user_id', $franchisee_id)->get()->toArray();
        $total_invoices = 0;
        foreach ($invoices as $invoice) {
            if (substr($invoice['reference'], 0, 3) != "IF-") // removing initial fee from total
                $total_invoices += $invoice['amount'];
        }

        // Total of cashed money and number of sales
        $sales = $this->get_franchisee_sales($franchisee_id, $creation_date, $today);

        // If no sale, return invoices but 0 sales & total
        if (empty($sales)) {
            return ["sales_total" => 0,
                "sales_count" => 0,
                "creation_date" => $creation_date,
                "total_invoices" => $total_invoices
            ];
        }

        $sales_total = 0;
        foreach ($sales as $sale) {
            foreach ($sale['sold_dishes'] as $sold_dish) {
                $sales_total += $sold_dish['quantity'] * $sold_dish['unit_price'];
            }
        }

        return ["sales_total" => $sales_total,
            "sales_count" => count($sales),
            "creation_date" => $creation_date,
            "total_invoices" => $total_invoices
        ];
    }

    public function franchisee_sales_history_pdf(Request $request)
    {
        $parameters = $request->except(['_token']);

        if (count($parameters) == 3 && !empty($parameters["id"]) && $parameters["start_date"] != NULL && $parameters["start_date"] != NULL) {
            $franchisee_id = $parameters["id"];
            $start_date = $parameters["start_date"];
            $end_date = $parameters["end_date"];

            if ($start_date > $end_date) {
                flash(trans('franchisee.history_start_date_cannot_be_higher_than_end'))->error();
                return redirect()->back();
            }

            $franchisee = $this->get_franchisee_by_id($franchisee_id);
            $sales = $this->get_franchisee_sales($franchisee_id, $start_date, $end_date);

            if (empty($sales)) {
                flash(trans('franchisee.no_sales'))->error();
                return redirect()->back();
            }

            $pdf = PDF::loadView('corporate.franchisee.franchisee_history',
                ["franchisee" => $franchisee,
                    "sales" => $sales,
                    "start_date" => $start_date,
                    "end_date" => $end_date]
            );
            return $pdf->stream();
        } else {
            flash(trans('franchisee.select_history_dates'))->error();
            return redirect()->back();
        }

    }

    public function get_franchisee_sales($franchisee_id, $start_date, $end_date)
    {
        return Sale::whereBetween('date', [$start_date, $end_date])
            ->where('user_franchised', $franchisee_id)
            ->with('sold_dishes')
            ->get()->toArray();
    }

    public function get_sale_total($sale_id)
    {
        $sold_dishes = SoldDish::where('sale_id', $sale_id)->get();
        $sale_total = 0;

        if ($sold_dishes) {
            $sold_dishes->toArray();
            foreach ($sold_dishes as $sold_dish) {
                $sale_total += $sold_dish['unit_price'] * $sold_dish['quantity'];
            }
        }

        return $sale_total;
    }

    // Return only the dates with sales
    public function get_sales_turnover_by_day($franchisee_id) {
        $sales_by_day = Sale::where('user_franchised', $franchisee_id)
                            ->orderBy('date', 'ASC')
                            ->get()->groupBy('date')->toArray();
        $sales_turnover_by_day = [];

        foreach ($sales_by_day as $date => $daily_sales) {
            $day = DateTime::createFromFormat("Y-m-d", $date)->format('d/m/Y');
            $sales_turnover_by_day[$day]['nb_sales'] = count($daily_sales);
            $daily_total = 0;
            foreach ($daily_sales as $sale) {
                $daily_total += $this->get_sale_total($sale['id']);
            }
            $sales_turnover_by_day[$day]['revenues'] = $daily_total;
        }

        return $sales_turnover_by_day;
    }

    // Return the daily sales and turnover on the month - If nothing on a date: fill with 0
    public function get_monthly_sales_turnover_by_day($franchisee_id, $month, $year) {

        $sales_turnover_by_day = $this->get_sales_turnover_by_day($franchisee_id);

        // One array for date labels + one array per dataset
        $monthly_data['dates'] = [];
        $monthly_data['sales'] = [];
        $monthly_data['turnover'] = [];

        // Default dates: current month of current year
        $month = $month == null ? date('m') : $month;
        $year = $year == null ? date('Y') : $year;

        // Array with every day of the month
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for($i = 1; $i <= $days_in_month; $i++) {
            $prefix = $i < 10 ? '0' : '';
            $date = $prefix.$i.'/'.$month.'/'.$year;
            $monthly_data['dates'][] = $date;
        }

        // If date matches sales day: add data in $dates and $sales
        foreach ($monthly_data['dates'] as $date) {
            $is_matching = false;
            foreach (array_keys($sales_turnover_by_day) as $sale_date) {
                if ($sale_date == $date) {
                    $monthly_data['sales'][] = $sales_turnover_by_day[$date]['nb_sales'];
                    $monthly_data['turnover'][] = $sales_turnover_by_day[$date]['revenues'];
                    $is_matching = true;
                    break;
                }
            }
            if ($is_matching == false) {
                $monthly_data['sales'][] = 0;
                $monthly_data['turnover'][] = 0;
            }
        }

        return $monthly_data;
    }

    public function get_monthly_sales_by_payment_methods($franchisee_id, $month, $year) {
        // Default dates: current month of current year
        $month = $month == null ? date('m') : $month;
        $year = $year == null ? date('Y') : $year;

        $sales = [];
        $payment_methods = $this->get_enum_column_values('sale', 'payment_method');
        foreach ($payment_methods as $payment_method) {
            $sales['methods'][] = trans("franchisee.$payment_method");
            $sales['nb_sales'][] = Sale::where('user_franchised', $franchisee_id)
                                            ->where('payment_method', $payment_method)
                                            ->whereYear('date', $year)
                                            ->whereMonth('date', $month)
                                            ->get()->count();
        }

        return $sales;
    }

    public function get_monthly_sales_by_origin($franchisee_id, $month, $year){
        // Default dates: current month of current year
        $month = $month == null ? date('m') : $month;
        $year = $year == null ? date('Y') : $year;

        $sales['origins'] = ['1', '0'];
        foreach ($sales['origins'] as $origin) {
            $sales['nb_sales'][] = Sale::where('user_franchised', $franchisee_id)
                ->where('online_order', $origin)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get()->count();
        }
        $sales['origins'] = [trans("franchisee.online"), trans("franchisee.offline")];

        return $sales;
    }

    public function generate_chart($franchisee_id, $type){
        // Get current month data
        $monthly_sales_turnover_by_day = $this->get_monthly_sales_turnover_by_day($franchisee_id, null, null);
        $sales_by_payment_methods = $this->get_monthly_sales_by_payment_methods($franchisee_id, null, null);
        $sales_by_origin = $this->get_monthly_sales_by_origin($franchisee_id, null, null);

        $chart = new FranchiseeStatsChart;

        if ($type == 'sales') {
            $chart->labels($monthly_sales_turnover_by_day['dates']);
            $chart->dataset(trans('franchisee.sales_count'), 'line', $monthly_sales_turnover_by_day['sales'])
                ->color('#6408c7')
                ->fill(false);
        } else if ($type == 'turnover') {
            $chart->labels($monthly_sales_turnover_by_day['dates']);
            $chart->dataset(trans('franchisee.turnover'), 'line', $monthly_sales_turnover_by_day['turnover'])
                ->color('#00d1ce')
                ->fill(false);
        } else if ($type == 'payment_methods') {
            $chart->labels($sales_by_payment_methods['methods']);
            $chart->displayAxes(false);
            $chart->dataset(trans('franchisee.payment_methods_breakdown'), 'pie', $sales_by_payment_methods['nb_sales'])
                ->backgroundColor(['#6408c7', '#00d1ce']);
        } else if ($type == 'origin') {
            $chart->labels($sales_by_origin['origins']);
            $chart->displayAxes(false);
            $chart->dataset(trans('franchisee.payment_methods_breakdown'), 'pie', $sales_by_origin['nb_sales'])
                ->backgroundColor(['#6408c7', '#00d1ce']);
        }

        if ($type == 'sales' || $type == 'turnover') {
            $stepSize = $type == 'sales' ? 1 : 50;
            $chart->options([
                'tooltip' => ['show' => true],
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => ['beginAtZero' => true, 'stepSize' => $stepSize],
                            'position' => 'left',
                        ],
                    ],
                ]
            ]);
        }

        return $chart;
    }

}