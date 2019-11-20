<?php

namespace App\Http\Controllers\Admin;

use App\Gift;
use App\Http\Controllers\Controller;
use App\Payment;
use App\PaymentMethod;
use App\User;
use Auth;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gifts = Gift::with('user')->latest()->paginate();

        return view('admin.gift.index', ['gifts' => $gifts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $paymentsMethod = PaymentMethod::all();

        return view('admin.gift.create', [
            'user' => $user,
            'payments_methods' => $paymentsMethod,
                ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        $inputs = $request->validate([
            'amount' => 'required|numeric|min:0|max:999999',
            'payment_method_id' => 'required|integer',
        ]);
        $inputs['user_id'] = $user->id;
        $gift = Gift::create($inputs);

        $inputs['payment_id'] = $gift->id;
        $inputs['payment_type'] = 'App\Gift';
        $inputs['payment_method_id'] = $request['payment_method_id'];

        Payment::create($inputs);

        return back()->with('message', 'Le don a bien été ajouté pour ce membre !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $user->load('gifts.payment.paymentMethod');

        $paymentsMethods = PaymentMethod::all();

        return view('admin.gift.show', ['user' => $user, 'paymentsMethods' => $paymentsMethods]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Gift $gift
     * @return \Illuminate\Http\Response
     */
    public function edit(Gift $gift)
    {
        $gift->load('user');

        return view('admin.gift.edit', ['gift' => $gift]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Gift $gift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gift $gift)
    {
        $inputs = $request->validate([
            'amount' => 'required|numeric|min:0|max:999999',
        ]);

        $gift->update($inputs);

        return redirect()->route('admin.gift.index')->with('message', 'Modification confirmée');
    }

    /**
     * @param Gift $gift
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Gift $gift)
    {
        return view('admin.gift.delete', ['gift' => $gift]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Gift $gift
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Gift $gift)
    {
        $gift->delete();

        return redirect()->route('admin.gift.index')->with('message', 'Don supprimé');
    }
}
