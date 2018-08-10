<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\Payment;
use App\Gift;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('lastname', 'asc')->paginate(10);
        return view('admin.user.index', ['users' => $users]);
    }

    /**
    * Display an adhesion adding for admin
     * required click on 'Modifier' in the users-list
    */
    public function beforeSubscription($id)
    {
        $user = User::findorfail($id);

        return view('admin.user.addsubscription', ['user' => $user]);
    }

    /**
     * @param Request $request
     * @param $userid
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function validatorSubscription(Request $request, $userid)
    {
        $user = User::where('id', $userid)->firstOrFail();

        $validator = $request->validate([
            'subscription_type_id' => 'required|integer',
            'amount' => 'required|numeric',
            //'payment_methods' => 'required',
            'subscription_date' => 'required|date|after_or_equal:today',
            //'opt_out_mail' => '0'
        ]);
/**
        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }
**/
        $this->createSubscription($validator, $user);
        /** todo modifier la route pour qu'elle renvoie vers la gestion des adhésions */
        // return redirect()->route('admin.user.index');

    }


    /**
     * @param $validator
     * @param $user
     *
     */
    public function createSubscription($validator, $user)
    {

        $validator['user_id'] = $user->id;


        $subscription = Subscription::create([
            'subscription_date' => $validator['subscription_date'],
            'amount' => $validator['amount'],
            'opt_out_mail' => '0', // affectation de la valeur afin que l'adhérent reçoive les relances
            'subscription_source' => '0', // affectation de la valeur pour spécifier la source admin de cette adhésion
            'user_id' => $user->id,
            'subscription_type_id' => $validator['subscription_type_id'],
        ]);

        /*Payment::create([
            'payment_type' => 'App\Subscription',
            'payment_id' => $subscription->id,
            'amount' => $validator['amount'],
            'user_id'=> $user->id,
            //a recoder !
            'payment_method_id' => '1'
        ]);*/


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Admin\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function beforeDelete($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.beforedelete', ['user' => $user]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index');
    }
}
