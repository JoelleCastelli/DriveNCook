<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Traits\UserTools;
use App\Charts\FranchiseeStatsChart;
use DateInterval;
use DatePeriod;
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

        $franchisee_activity_years = [];
        $begin = DateTime::createFromFormat("Y-m-d H:i:s", $franchisee['created_at']);
        $end = new DateTime( 'now' );
        $daterange = new DatePeriod($begin, new DateInterval('P1Y'), $end);
        foreach($daterange as $date){
            $franchisee_activity_years[] = $date->format("Y");
        }

        return view('franchise.revenues_stats')->with('revenues', $current_month_sales)
                                                    ->with('franchisee', $franchisee)
                                                    ->with('history', $history)
                                                    ->with('franchisee_activity_years', $franchisee_activity_years)
                                                    ->with('invoicing_period', $invoicing_period)
                                                    ->with('sales_chart', $sales_chart)
                                                    ->with('turnover_chart', $turnover_chart)
                                                    ->with('current_obligation', $current_obligation);
    }

    public function generate_chart($franchisee_id, $stepSize, $type = 'sales'){
        $data = $this->get_sales_turnover_by_day($franchisee_id);

        $chart = new FranchiseeStatsChart;
        $chart->labels($data['dates']);
        if ($type == 'sales') {
            $chart->dataset(trans('franchisee.sales_count'), 'line', $data['nb_sales'])->color('#6408c7')->fill(false);
        } else {
            $chart->dataset(trans('franchisee.turnover'), 'line', $data['turnover'])->color('#00d1ce')->fill(false);
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


    public function chartLine() {
        $data = $this->get_sales_turnover_by_day(503);
        $api = url('/chart-line-ajax');
        $chart = new FranchiseeStatsChart;
        $chart->labels($data['dates'])->load($api);
        return $chart;
    }

    public function chartLineAjax(Request $request) {
        $year = $request->has('year') ? $request->year : date('Y');
        $data = $this->get_sales_turnover_by_day(503);

        $chart = new FranchiseeStatsChart;
        $chart->dataset('New User Register Chart', 'line', $data['nb_sales'])->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0'
        ]);

        return $chart->api();
    }

}

