<?php

namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Models\FranchiseObligation;
use App\Traits\UserTools;
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

        return view('franchise.revenues_stats')->with('revenues', $current_month_sales)
                                                    ->with('history', $history)
                                                    ->with('franchisee', $franchisee)
                                                    ->with('invoicing_period', $invoicing_period)
                                                    ->with('current_obligation', $current_obligation);
    }

}

