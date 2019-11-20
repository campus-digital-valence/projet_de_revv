<?php

namespace App\Observers;

use App\Mail\MembershipNew;
use App\Mail\MembershipRenewal;
use App\Subscription;
use Illuminate\Support\Facades\Mail;

class SubscriptionObserver
{
    /**
     * Handle the subscription "created" event.
     *
     * @param  \App\Subscription $subscription
     * @return void
     */
    public function created(Subscription $subscription)
    {
        $subscription->load('user', 'type');
        $user = $subscription->user;

        if (Subscription::where('user_id', $user->id)->count() === 1) {
            Mail::to($user)->send(new MembershipNew($subscription));
        } else {
            Mail::to($user)->send(new MembershipRenewal($subscription));
        }
    }

    /**
     * Handle the subscription "updated" event.
     *
     * @param  \App\Subscription $subscription
     * @return void
     */
    public function updated(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the subscription "deleted" event.
     *
     * @param  \App\Subscription $subscription
     * @return void
     */
    public function deleted(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the subscription "restored" event.
     *
     * @param  \App\Subscription $subscription
     * @return void
     */
    public function restored(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the subscription "force deleted" event.
     *
     * @param  \App\Subscription $subscription
     * @return void
     */
    public function forceDeleted(Subscription $subscription)
    {
        //
    }
}
