<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Gift;
use App\Payment;
use App\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->load('gifts.payment.paymentMethod');
        $payments_methods = PaymentMethod::all();

        return view('user.gift.create', ['user' => $user, 'payments_methods' => $payments_methods]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs  = $request->validate([
            'amount' => 'required|numeric|min:0|max:999999',
        ]);
        $inputs['user_id'] = Auth::user()->id;
        $inputs['amount'] = $request->input('amount');
        $gift = Gift::create($inputs);
        $inputs['payment_id'] = $gift->id;
        $inputs['payment_type'] = "App\gift";
        $inputs['payment_method_id'] = '2';
        Payment::create($inputs);

        return back()->with('message', 'Le don a bien été ajouté !');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
