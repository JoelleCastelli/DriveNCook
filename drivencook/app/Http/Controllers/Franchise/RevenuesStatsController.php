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
        $sales_chart = $this->generate_chart($franchisee['id'], 'sales');
        $turnover_chart = $this->generate_chart($franchisee['id'], 'turnover');
        $payment_methods_chart = $this->generate_chart($franchisee['id'], 'payment_methods');
        $origins_chart = $this->generate_chart($franchisee['id'], 'origin');

        return view('franchise.revenues_stats')->with('revenues', $current_month_sales)
            ->with('franchisee', $franchisee)
            ->with('history', $history)
            ->with('invoicing_period', $invoicing_period)
            ->with('sales_chart', $sales_chart)
            ->with('payment_methods_chart', $payment_methods_chart)
            ->with('origins_chart', $origins_chart)
            ->with('turnover_chart', $turnover_chart)
            ->with('current_obligation', $current_obligation);
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

