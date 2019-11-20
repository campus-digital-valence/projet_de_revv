<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PasswordSending;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('lastname', 'asc')->paginate();

        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'gender' => 'required|integer',
            'lastname' => 'required|alpha|string|max:45|min:2',
            'firstname' => 'required|alpha|string|max:45|min:2',
            'birthdate' => 'required|date|before:today-13years|after:today-120years',
            'address_line1' => 'required|string|max:32',
            'address_line2' => 'string|max:32|nullable',
            'zipcode' => 'required|string|max:20|regex:/^\d{5}(?:[-\s]\d{4})?$/',
            'city' => 'required|string|alpha|max:45|min:2',
            'email' => 'email|max:255|unique:users|nullable',
            'gender_joint' => 'nullable|integer',
            'lastname_joint' => 'string |max:45|min:2|alpha|nullable',
            'firstname_joint' => 'string|max:45|min:2|alpha||nullable',
            'birthdate_joint' => 'date|before:today-13years|after:today-120years|nullable',
            'email_joint' => 'email|max:255|nullable',
            'phone_1' => 'string|digits:10|nullable',
            'phone_2' => 'string|digits:10|nullable',
            'volonteer' => 'integer|nullable',
            'details_volonteer' => 'string|max:600|nullable',
            'delivery' => 'integer|nullable',
            'newspaper' => 'integer|nullable',
            'newsletter' => 'integer|nullable',
            'mailing' => 'integer|nullable',
            'comment' => 'string|nullable',
            'alert' => 'integer|nullable',
        ]);

        $str_random = str_random(8);
        $inputs['password'] = Hash::make($str_random);

        $user = User::create($inputs);

        if ($inputs['email']) {
            if ($request['sendPwdByEmail']) {
                Mail::to($user)->send(new PasswordSending($user, $str_random));
            }
        }

        return redirect()->route('admin.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('subscriptions.type')
            ->load('gifts.payment.paymentMethod');

        return view('admin.user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validateData = $request->validate([
            'gender' => 'integer|max:2|nullable',
            'firstname' => 'required|alpha|string|max:45|min:2',
            'lastname' => 'required|alpha|string|max:45|min:2',
            'email' => 'string|required|email|max:255|unique:users,email,'.$user->id,
            'birthdate' => '|date|before:today-13years|after:today-120years',
            'address_line1' => '|string|max:32|',
            'address_line2' => '|string|max:32|nullable',
            'city' => 'required|string|max:45|',
            'zipcode' => 'digits:5|numeric',
            'phone_1' => 'numeric|nullable',
            'phone_2' => 'numeric|nullable',
            'newspaper' => 'boolean',
            'newsletter' => 'boolean',
            'gender_joint' => 'max:2|nullable',
            'firstname_joint' => 'alpha|max:45|nullable',
            'lastname_joint' => 'alpha|max:45|nullable',
            'birthdate_joint' => 'date|before:today-13years|after:today-120years|nullable',
            'email_joint' => 'email|max:45|nullable',
        ]);

        if ($request['newspaper'] == null) {
            $validateData['newspaper'] = 0;
        }
        if ($request['newsletter'] == null) {
            $validateData['newsletter'] = 0;
        }

        $user->update($validateData);

        return redirect()->route('admin.user.show', ['user' => $user])->with('message', 'Modification effectuée');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(User $user)
    {
        $user->load('subscriptions')
            ->load('gifts')
            ->load('newsletters');

        return view('admin.user.delete', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user->subscriptions()->count() > 0 || $user->gifts()->count() > 0 || $user->newsletters()->count() > 0) {
            $user->delete();

            return redirect()->route('admin.user.index')
                ->with('message', $user->firstname.' supprimé, mais n\'est pas retiré de la base de donnée');
        } else {
            $user->forceDelete();

            return redirect()->route('admin.user.index')
                ->with('message', $user->firstname.' est totalement supprimé');
        }
    }
}
