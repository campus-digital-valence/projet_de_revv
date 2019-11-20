<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Payment;
use App\Subscription;
use App\SubscriptionType;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class SubscriptionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->load('subscriptions');

        $newStartDate = Carbon::now();
        $actualSubscriptionTypeId = 0;
        $subscriptionValide = 'noSubscrYet';

        $lastSubscription = $user->lastSubscription();

        if ($lastSubscription) {
            $actualSubscriptionTypeId = $lastSubscription->subscription_type_id;
            $subscriptionValide = 'subscrOutdated';
            $lastSubscriptionDate = Carbon::parse($lastSubscription->date_end);

            if ($lastSubscriptionDate >= Carbon::now()) {
                $subscriptionValide = 'subscrValide';
                $newStartDate = $lastSubscriptionDate->addDay();
            }
        }

        $newEndDate = Carbon::parse($newStartDate)->addYear();

        $subscriptionTypes = SubscriptionType::all();

        return view('user.subscription.create', [
            'user' => $user,
            'subscriptionTypes' => $subscriptionTypes,
            'subscriptionValide' => $subscriptionValide,
            'startDate' => $newStartDate,
            'endDate' => $newEndDate,
            'actualSubscriptionTypeId' => $actualSubscriptionTypeId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $newStartDate = Carbon::now();
        $type = $request->input('type');

        $subscriptionType = SubscriptionType::findOrFail($type);

        $lastSubscription = $user->lastSubscription();

        if ($lastSubscription) {
            $lastSubscriptionDate = Carbon::parse($lastSubscription->date_end);

            if ($lastSubscriptionDate > Carbon::now()) {
                $newStartDate = $lastSubscriptionDate->addDay();
            }
        }

        $newEndDate = Carbon::parse($newStartDate)->addYear();

        $sub = Subscription::create([
            'amount' => $subscriptionType->amount,
            'opt_out_mail' => 0,
            'date_start' => $newStartDate, //->format('d-m-Y'),
            'date_end' => $newEndDate, //->format('d-m-Y'),
            'subscription_source' => 1,
            'user_id' => $user->id,
            'subscription_type_id' => $subscriptionType->id,
        ]);

        Payment::create([
            'payment_type' => 'App\Subscription',
            'payment_id' => $sub->id,
            'amount' => $sub->amount,
            'user_id' => $user->id,
            'payment_method_id' => 2,
        ]);

        return back()->with('message', 'Adhésion Confirmée !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payments_methods = PaymentMethod::all();
        $subscription_type = SubscriptionType::all();
        $subscription = Subscription::with('payment')->findOrFail($id);

        return view('admin.subscription.edit', ['subscription' => $subscription,
            'payments_methods' => $payments_methods,
            'subscription_type' => $subscription_type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'user_id' => 'required|numeric',
            'subscription_type_id' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_methods' => 'required|numeric',
            'subscription_date' => 'required|date|after_or_equal:today',
        ]);

        $validator['opt_out_mail'] = 0;
        $validator['subscription_source'] = 0;

        $subscription = Subscription::findOrFail($id);

        $subscription->update($validator);

        $validator['payment_id'] = $subscription->id;
        $validator['payment_type'] = "App\Subscription";
        $validator['payment_method_id'] = $request->payment_methods;

        $payment = Payment::where([
            ['payment_id', $subscription->id],
            ['payment_type', 'App\Subscription'],
        ]);

        $payment->update($validator);

        return back()->with('message', 'Mise a jour effectuée');
    }

    /**
     * @todo
     *
     * Use Hashids
     *
     * @param $subscriptionId
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function optout($subId, $userId)
    {
        $subscription = Subscription::findOrFail($subId);
        $user = User::findOrFail($userId);

        if ($subscription->user_id === $user->id) {
            $subscription->opt_out_mail = 1;
            $subscription->save();

            return view('user.subscription.optout');
        } else {
            return abort(403);
        }
    }

    public function pdf()
    {
        $user = Auth::user();
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('user.subscription.pdf', compact('user'));
        $name = 'Adhésion_'.$user->firstname.'_'.$user->lastname.'.pdf';

        return $pdf->stream($name);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $subscriptionToDelete = Subscription::findOrFail($id);
        $subscriptionToDelete->delete();

        return redirect()->route('admin.subscription.index')->with('message', 'Adhésion supprimée');
    }
}
