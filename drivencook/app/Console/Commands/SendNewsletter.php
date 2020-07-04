<?php

namespace App\Console\Commands;

use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Models\User;
use App\Http\Controllers\Corporate\FranchiseeController;
use App\Traits\EmailTools;
use App\Traits\NewslettersTools;
use App\Traits\UserTools;
use Illuminate\Console\Command;

class SendNewsletter extends Command
{
    use NewslettersTools;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send_monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly newsletter';

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
        $this->sendNewsLettersAllClients();
    }
}
