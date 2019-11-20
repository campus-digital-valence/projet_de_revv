<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Hash;
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
        $user = Auth::user();

        return view('user.user.index', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

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

        return redirect()->route('user.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete()
    {
        $user = Auth::user();

        return view('user.user.delete', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        Auth::logout();

        return redirect()->route('home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function passwordEdit()
    {
        return view('user.user.password');
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
