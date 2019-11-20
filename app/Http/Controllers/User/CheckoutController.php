<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function payment()
    {
        return view('user.payment.payment');
    }

    public function charge(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $customer = Customer::create([
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
            ]);

            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => 1999,
                'currency' => 'eur',
            ]);

            return 'Charge successful, you get the course!';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
