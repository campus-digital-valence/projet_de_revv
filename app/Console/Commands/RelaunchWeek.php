<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Subscription;
use Illuminate\Console\Command;
use App\Mail\MembershipRelaunchWeek;
use Illuminate\Support\Facades\Mail;

class RelaunchWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'relaunch:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users the end week of subscription';

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
        $subscriptions = Subscription::where('date_end', Carbon::now()->subWeek())
            ->with('user')
            ->get();

        foreach ($subscriptions as $subscription) {
            Mail::to($subscription->user)->send(new MembershipRelaunchWeek($subscription));
        }
    }
}
