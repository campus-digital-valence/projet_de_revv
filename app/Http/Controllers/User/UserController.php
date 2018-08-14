<?php

namespace App\Http\Controllers\User;

use Auth;
use Hash;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('user.user.index', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param User $user
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
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
        if ($request->has('role_type_id')) {
            $role_type_id = $request->validate([
                'role_type_id' => 'integer',
            ]);

            $role = $user->role();
            $role->update($role_type_id);
        }
        if ($request['newspaper'] == null) {
            $validateData['newspaper'] = 0;
        }
        if ($request['newsletter'] == null) {
            $validateData['newsletter'] = 0;
        }

        $user->update($validateData);

        return redirect()->route('user.edit', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
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
     * @throws
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('home');
    }

    public function history()
    {
        $user = Auth::user();
        $user->load('gifts');
        $user->load('subscriptions');

        return view('user.history.index', ['user' => $user]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function passwordEdit()
    {
        return view('users.password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();

        if (! Hash::check($request->input('password'), $user->password)) {
            return back()
                ->withErrors(['password' => 'Mot de passe incorrect'])
                ->withInput();
        } else {
            $validateRequest = $request->validate([
                'password' => 'required|string|min:6|max:191',
                'new_password' => 'required|string|min:6|max:191|confirmed',
            ]);

            $user->password = Hash::make($validateRequest['new_password']);
            $user->save();

            return redirect()->route('home');
        }
    }
}
