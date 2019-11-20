<?php

namespace App\Console\Commands;

use App\Mail\MembershipRelaunchMonth;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RelaunchMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'relaunch:month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users the end month of subscription';

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
        $subscriptions = Subscription::where('date_end', Carbon::now()->addMonth()->toDateString())
            ->with('user')
            ->get();

        foreach ($subscriptions as $subscription) {
            Mail::to($subscription->user)->send(new MembershipRelaunchMonth($subscription));
        }
    }
}
