<?php


namespace App\Traits;


use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Models\Pseudo;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use App\Models\Truck;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Illuminate\Support\Facades\DB;

trait UserTools
{
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

    public function get_current_obligation(){
        return FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
    }

    // INVOICES
    public function create_invoice_reference($prefix, $franchisee_id, $invoice_id){
        $reference_start = $prefix.'-'.$franchisee_id.'-';
        $column_type = DB::select(DB::raw("SHOW COLUMNS FROM invoice WHERE Field = 'reference'"))[0]->Type;
        $column_length = substr(ltrim($column_type, 'varchar('), 0, -1);
        $pad_length = $column_length - strlen($reference_start);
        $reference = $reference_start.str_pad($invoice_id, $pad_length, "0", STR_PAD_LEFT);
        Invoice::where('id', $invoice_id)->update(['reference' => $reference]);
        return $reference;
    }

    public function generate_first_invoice($franchisee_id){
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

    public function franchisee_invoice_pdf($id) {
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

    public function stream_franchisee_invoice_pdf($id) {
        $pdf = $this->franchisee_invoice_pdf($id);
        return $pdf->stream();
    }

    public function save_franchisee_invoice_pdf($id, $reference) {
        $pdf = $this->franchisee_invoice_pdf($id);
        if (strpos($reference, 'IF') !== FALSE) {
            $path = resource_path('invoices/franchisee_initial_fee/');
        } elseif (strpos($reference, 'MF') !== FALSE) {
            $path = resource_path('invoices/franchisee_monthly_fee/');
        } else if (strpos($reference, 'RS') !== FALSE) {
            $path = resource_path('invoices/franchisee_restock/');
        }

        return $pdf->save($path . '/' . $reference.'.pdf');
    }

    // STATS AND REVENUES
    public function getNextPaymentDate($franchiseObligation)
    {
        $currentDay = new DateTime();
        $currentDay->setDate(date('Y'), date('m'), date('d'));

        if ($currentDay->format('d') <= $franchiseObligation['billing_day']) {
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
        $franchise_obligation = FranchiseObligation::all()->sortByDesc('id')->first()->toArray();

        $date_max = DateTime::createFromFormat("d/m/Y", $this->getNextPaymentDate($franchise_obligation));
        $date_max = $date_max->setTime(23, 59, 59);
        $date_min = clone $date_max;
        $date_min->modify('-1 month');
        $date_max->modify('-1 day');
        $date_max = $date_max->format("Y/m/d");
        $date_min = $date_min->format("Y/m/d");

        $sales = Sale::whereBetween('date', [$date_min, $date_max])
            ->where('user_franchised', $franchise_id)
            ->with('sold_dishes')
            ->get()->toArray();
        $sales_total = 0;
        foreach ($sales as $sale) {
            foreach ($sale['sold_dishes'] as $sold_dish) {
                $sales_total += $sold_dish['quantity'] * $sold_dish['unit_price'];
            }
        }

        $next_invoice = $sales_total * $franchise_obligation['revenue_percentage'] / 100;

        return array(
            "sales_total" => $sales_total,
            "sales_count" => count($sales),
            "next_invoice" => $next_invoice
        );
    }

    public function get_franchisee_history($franchisee_id) {

        // Definition of min and max dates
        $user = $this->get_franchisee_by_id($franchisee_id);
        $creation_date = DateTime::createFromFormat("Y-m-d H:i:s", $user['created_at'])->format('Y-m-d');
        $today = date("Y-m-d");

        // Total of invoices
        $invoices = Invoice::where('user_id', $franchisee_id)->get()->toArray();
        $total_invoices = 0;
        foreach ($invoices as $invoice) {
            if(substr($invoice['reference'], 0, 3) != "IF-") // removing initial fee from total
                $total_invoices += $invoice['amount'];
        }

        // Total of cashed money and number of sales
        $sales = Sale::whereBetween('date', [$creation_date, $today])
            ->where('user_franchised', $franchisee_id)
            ->with('sold_dishes')
            ->get();

        // If no sale, return invoices but 0 sales & total
        if($sales) {
            $sales->toArray();
        } else {
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

}