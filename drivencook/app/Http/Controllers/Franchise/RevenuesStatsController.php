<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Traits\UserTools;
use App\Charts\FranchiseeStatsChart;
use DateTime;

class RevenuesStatsController extends Controller
{
    use UserTools;

    public function view_revenues_stats() {
        $franchisee = $this->get_connected_user();
        $current_obligation = $this->get_current_obligation();
        $current_month_sales = $this->get_franchise_current_month_sale_revenues($franchisee['id']);
        $invoicing_period = $this->get_invoicing_period($current_obligation, "d/m/Y");
        $history = $this->get_franchisee_history($franchisee['id']);
        $sales_chart = $this->generate_chart($franchisee['id'], 1);
        $turnover_chart = $this->generate_chart($franchisee['id'], 50, 'turnover');

        return view('franchise.revenues_stats')->with('revenues', $current_month_sales)
                                                    ->with('history', $history)
                                                    ->with('franchisee', $franchisee)
                                                    ->with('invoicing_period', $invoicing_period)
                                                    ->with('sales_chart', $sales_chart)
                                                    ->with('turnover_chart', $turnover_chart)
                                                    ->with('current_obligation', $current_obligation);
    }

    public function generate_chart($franchisee_id, $stepSize, $type = 'sales'){
        // Getting count of franchisee's daily sales
        $sales_by_day = Sale::where('user_franchised', $franchisee_id)
                        ->orderBy('date', 'ASC')
                        ->get()->groupBy('date')->toArray();

        // Filling the date and sales arrays
        $date_labels = [];
        $nb_sales = [];
        $nb_revenue = [];
        $daily_total = 0;

        foreach ($sales_by_day as $date => $daily_sales) {
            array_push($date_labels, DateTime::createFromFormat("Y-m-d", $date)->format('d/m/Y'));
            array_push($nb_sales, count($daily_sales));
            foreach ($daily_sales as $sale) {
                $daily_total = $this->get_sale_total($sale['id']);
            }
            array_push($nb_revenue, $daily_total);
        }

        // Creating the chart
        $chart = new FranchiseeStatsChart;
        $chart->labels($date_labels);
        if ($type == 'sales') {
            $chart->dataset(trans('franchisee.sales_count'), 'line', $nb_sales)->color('#6408c7')->fill(false);
        } else {
            $chart->dataset(trans('franchisee.turnover'), 'line', $nb_revenue)->color('#00d1ce')->fill(false);
        }
        $chart->options([
            'tooltip' => ['show' => true],
            'scales' => [
                'yAxes'=> [
                    [
                        'ticks'=> ['beginAtZero'=> true, 'stepSize'=>$stepSize],
                        'position'=> 'left',
                        'id'=> 'sales_axis'
                    ],
                    /*[
                        'ticks'=> ['beginAtZero'=> true, 'stepSize'=>10],
                        'position'=> 'right',
                        'id'=> 'revenues_axis'
                    ],*/
                ]
            ]
        ]);

        return $chart;
    }

}

