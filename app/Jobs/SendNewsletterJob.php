<?php

namespace App\Jobs;

use App\Mail\SendNewsletter;
use App\Newsletter;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $newsletter;

    /**
     * Create a new job instance.
     *
     * @param Newsletter $newsletter
     */
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->newsletter->status = 'sending';
        $this->newsletter->save();

        if ($this->newsletter->sendTo === 'all') {
            $users = User::all();
        } elseif ($this->newsletter->sendTo == 'admin') {
            $users = User::whereHas('role', function ($query) {
                $query->where('role_type_id', 2);
            })->get();
        } else {
            $users = User::newsletter()->get();
        }

        foreach ($users as $user) {
            Mail::to($user)->send(new SendNewsletter($this->newsletter, $user));
            $this->newsletter->increment('counter'); // update live counter in index page
            $this->newsletter->save();
        }

        $this->newsletter->status = 'sent';
        $this->newsletter->save();
    }
}
