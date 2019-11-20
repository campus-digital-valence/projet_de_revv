<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Payment;
use App\PaymentMethod;
use App\Subscription;
use App\SubscriptionType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::with(['type', 'user', 'payment.paymentMethod'])
            ->orderBy('date_start', 'desc')
            ->paginate();

        return view('admin.subscription.index', ['subscriptions' => $subscriptions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paymentsMethods = PaymentMethod::all();
        $subscriptionTypes = SubscriptionType::all();

        return view('admin.subscription.create', [
            'paymentsMethods' => $paymentsMethods,
            'subscriptionTypes' => $subscriptionTypes,
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
        $validator = $request->validate([
            'user_id' => 'required|numeric',
            'subscription_type_id' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_methods' => 'required|numeric',
            'date_start' => 'required|date',
        ]);

        $validator['opt_out_mail'] = 0;
        $validator['subscription_source'] = 0;

        $subscription = Subscription::create($validator);

        $validator['payment_id'] = $subscription->id;
        $validator['payment_type'] = 'App\Subscription';
        $validator['payment_method_id'] = $validator['payment_methods'];

        Payment::create($validator);

        return redirect()->route('admin.subscription.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        $payments_methods = PaymentMethod::all();
        $subscription_types = SubscriptionType::all();
        $subscription->load('payment');

        return view('admin.subscription.edit', [
            'subscription' => $subscription,
            'subscription_types' => $subscription_types,
            'payments_methods' => $payments_methods,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validator = $request->validate([
            'subscription_type_id' => 'required|integer',
            'amount' => 'required|numeric',
            'date_start' => 'required|date',
            'payment_method_id' => 'required|numeric',
        ]);

        $dateStart = new Carbon($validator['date_start']);

        $validator['date_end'] = $dateStart->addYear()->format('Y-m-d');
        $validator['opt_out_mail'] = 0;
        $validator['subscription_source'] = 0;

        $subscription->update($validator);

        $validator['payment_id'] = $subscription->id;
        $validator['payment_type'] = 'App\Subscription';

        $payment = Payment::where([
            ['payment_id', $subscription->id],
            ['payment_type', 'App\Subscription'],
        ]);

        $payment->update([
            'amount' => $validator['amount'],
            'payment_method_id' => $validator['payment_method_id'],
        ]);

        return back()->with('message', 'Mise a jour effectuée');
    }

    public function delete(Subscription $subscription)
    {
        return view('admin.subscription.beforedelete', ['subscription' => $subscription]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscription $subscription
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('admin.subscription.index')->with('message', 'Adhésion supprimée');
    }
}
