<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Traits\UserTools;


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
        if($current_month_sales['sales_count'] == 0) {
            $payment_methods_chart = '';
            $origins_chart = '';
        } else {
            $payment_methods_chart = $this->generate_chart($franchisee['id'], 'payment_methods');
            $origins_chart = $this->generate_chart($franchisee['id'], 'origin');
        }

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


}

