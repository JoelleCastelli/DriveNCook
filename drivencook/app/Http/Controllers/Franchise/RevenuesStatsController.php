<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Traits\UserTools;
use App\Charts\FranchiseeStatsChart;
use DateTime;
use Illuminate\Support\Facades\DB;

class RevenuesStatsController extends Controller
{
    use UserTools;

    public function view_revenues_stats() {
        $franchisee = $this->get_connected_user();
        $current_obligation = $this->get_current_obligation();
        $current_month_sales = $this->get_franchise_current_month_sale_revenues($franchisee['id']);
        $invoicing_period = $this->get_invoicing_period($current_obligation, "d/m/Y");
        $history = $this->get_franchisee_history($franchisee['id']);
        $chart = $this->generate_chart($franchisee['id']);

        return view('franchise.revenues_stats')->with('revenues', $current_month_sales)
                                                    ->with('history', $history)
                                                    ->with('franchisee', $franchisee)
                                                    ->with('invoicing_period', $invoicing_period)
                                                    ->with('chart', $chart)
                                                    ->with('current_obligation', $current_obligation);
    }

    public function generate_chart($franchisee_id){
        // Getting count of franchisee's daily sales
        $sales_by_day = Sale::where('user_franchised', $franchisee_id)
                       ->select('date', DB::raw('count(*) as sales'))
                       ->groupBy('date')
                       ->get()->toArray();

        // Filling the date and sales arrays
        $data = [];
        $labels = [];
        foreach ($sales_by_day as $daily_sale) {
            array_push($data, $daily_sale['sales']);
            array_push($labels, DateTime::createFromFormat("Y-m-d", $daily_sale['date'])->format('d/m/Y'));
        }

        // Creating the chart
        $chart = new FranchiseeStatsChart;
        $chart->labels($labels);
        $chart->dataset(trans('franchisee.sales_count'), 'line', $data);
        $chart->options([
            'tooltip' => [
                'show' => true
            ]
        ]);

        return $chart;
    }

}

