<?php

namespace App\Console;

use App\Models\FranchiseObligation;
use App\Traits\NewslettersTools;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Traits\UserTools;

class Kernel extends ConsoleKernel
{
    use UserTools;
    use NewslettersTools;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenerateMonthlyInvoices::class,
        Commands\SendNewsletter::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $current_obligation = $this->get_current_obligation();
        $schedule->command('invoices:generate_monthly --force')
            ->monthlyOn($current_obligation['billing_day'], '10:00');

        $schedule->command('newsletter:send_monthly --force')
            ->monthlyOn(1, '10:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
