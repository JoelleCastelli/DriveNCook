<?php

namespace App\Console\Commands;

use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Models\User;
use App\Http\Controllers\Corporate\FranchiseeController;
use App\Traits\UserTools;
use Illuminate\Console\Command;

class GenerateMonthlyInvoices extends Command
{
    use UserTools;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:generate_monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly fee invoices for all franchisees who made sales in the previous month.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $franchisees = User::where('role', 'Franchisé')->get()->toArray();
        $current_obligation = FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
        foreach($franchisees as $franchisee) {
            $data = app('App\Http\Controllers\Corporate\FranchiseeController')->get_franchise_current_month_sale_revenues($franchisee['id']);
            if ($data['sales_total'] > 0){
                $invoice_total = $data['sales_total'] * $current_obligation['revenue_percentage'] / 100;
                $invoice = ['amount' => $invoice_total,
                    'date_emitted' => date("Y-m-d"),
                    'status' => 'A payer',
                    'monthly_fee' => 1,
                    'initial_fee' => 0,
                    'user_id' => $franchisee['id']];
                $invoice = Invoice::create($invoice)->toArray();
                $reference = $this->create_invoice_reference('MF', $franchisee['id'], $invoice['id']);
                $this->save_franchisee_invoice_pdf($invoice['id'], $reference);
            }
        }
    }
}
