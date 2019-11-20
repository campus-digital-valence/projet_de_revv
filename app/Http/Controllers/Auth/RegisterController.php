<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:191|confirmed',
            'gender' => 'required|integer',
            'lastname' => 'required|string|max:45',
            'firstname' => 'required|string|max:45',
            'birthdate' => 'required|date',
            'address_line1' => 'required|string|max:32',
            'address_line2' => 'string|max:32|nullable',
            'zipcode' => 'required|string|max:5',
            'city' => 'required|string|max:45',
            'phone_1' => 'string|digits:10',
            'phone_2' => 'string|digits:10|nullable',
            'newspaper' => 'integer|nullable',
            'newsletter' => 'integer|nullable',
            'gender_joint' => 'integer|nullable',
            'firstname_joint' => 'string|max:45|nullable',
            'lastname_joint' => 'string|max:45|nullable',
            'birthdate_joint' => 'date|nullable',
            'email_joint' => 'email|max:255|nullable',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (! array_key_exists('newsletter', $data)) {
            $data['newsletter'] = 0;
        }

        if (! array_key_exists('newspaper', $data)) {
            $data['newspaper'] = 0;
        }

        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'birthdate' => $data['birthdate'],
            'address_line1' => $data['address_line1'],
            'address_line2' => $data['address_line2'],
            'zipcode' => $data['zipcode'],
            'city' => $data['city'],
            'phone_1' => $data['phone_1'],
            'phone_2' => $data['phone_2'],
            'newspaper' => $data['newspaper'],
            'newsletter' => $data['newsletter'],
            'gender_joint' => $data['gender_joint'],
            'firstname_joint' => $data['firstname_joint'],
            'lastname_joint' => $data['lastname_joint'],
            'birthdate_joint' => $data['birthdate_joint'],
            'email_joint' => $data['email_joint'],
        ]);
    }
}
