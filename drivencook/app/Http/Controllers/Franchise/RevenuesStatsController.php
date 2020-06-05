<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Traits\UserTools;
use App\Charts\FranchiseeStatsChart;

class RevenuesStatsController extends Controller
{
    use UserTools;

    public function view_revenues_stats() {
        $franchisee = $this->get_connected_user();
        $current_obligation = $this->get_current_obligation();
        $current_month_sales = $this->get_franchise_current_month_sale_revenues($franchisee['id']);
        $invoicing_period = $this->get_invoicing_period($current_obligation, "d/m/Y");
        $history = $this->get_franchisee_history($franchisee['id']);
        $sales_chart = $this->generate_chart($franchisee['id'], 1, 'sales');
        $turnover_chart = $this->generate_chart($franchisee['id'], 50, 'turnover');

        return view('franchise.revenues_stats')->with('revenues', $current_month_sales)
            ->with('franchisee', $franchisee)
            ->with('history', $history)
            ->with('invoicing_period', $invoicing_period)
            ->with('sales_chart', $sales_chart)
            ->with('turnover_chart', $turnover_chart)
            ->with('current_obligation', $current_obligation);
    }

    public function generate_chart($franchisee_id, $stepSize, $type){
        $monthly_sales_turnover_by_day = $this->get_monthly_sales_turnover_by_day($franchisee_id, null, null);
        $chart = new FranchiseeStatsChart;
        $chart->labels($monthly_sales_turnover_by_day['dates']);
        if ($type == 'sales') {
            $chart->dataset(trans('franchisee.sales_count'), 'line', $monthly_sales_turnover_by_day['sales'])->color('#6408c7')->fill(false);
        } else {
            $chart->dataset(trans('franchisee.turnover'), 'line', $monthly_sales_turnover_by_day['turnover'])->color('#00d1ce')->fill(false);
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
                ]
            ]
        ]);

        return $chart;
    }
}

