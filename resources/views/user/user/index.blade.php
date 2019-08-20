@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>{{ __('app.Personal informations') }}</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.Home') }}</a></li>
            <li class="breadcrumb-item">{{ __('app.Personal informations') }}</li>
        </ol>
    </nav>

    <form action="{{ route('user.update') }}" method="post">
        @csrf
        <div class="form-group row">
            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('app.Gender') }}</label>
            <div class="col-md-8">
                <select class="custom-select form-control" name="gender" id="gender">
                    <option value="0" @if($user->gender == 0) selected @endif>{{ __('app.Gender') }}</option>
                    <option value="1" @if($user->gender == 1) selected @endif>{{ __('app.Mr') }}</option>
                    <option value="2" @if($user->gender == 2) selected @endif>{{ __('app.Ms') }}</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('app.Lastname') }}</label>
            <div class="col-md-8">
                <input type="text"
                       class="form-control {{$errors->has('lastname') ? 'is-invalid':''}}"
                       name="lastname"
                       id="lastname"
                       value="{{ old('lastname') ? old('lastname')  : $user->lastname}}">

                @if ($errors->has('lastname'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('app.Firstname') }}</label>
            <div class="col-md-8">
                <input type="text" name="firstname"
                       class="form-control {{$errors->has('firstname') ? 'is-invalid':''}}" id="firstname"
                       value="{{ old('firstname') ? old('firstname')  : $user->firstname}}">

                @if ($errors->has('firstname'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('firstname') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('app.E-Mail Address') }}</label>
            <div class="col-md-8">
                <input type="email"
                       name="email"
                       id="email"
                       class="form-control {{$errors->has('email') ? 'is-invalid':''}}"
                       value="{{ old('email') ? old('email')  : $user->email}}">

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('app.Birthdate') }}</label>
            <div class="col-md-8">
                <input type="date"
                       name="birthdate"
                       class="form-control {{$errors->has('birthdate') ? 'is-invalid':''}}"
                       id="birthdate"
                       value="{{ old('birthdate') ? old('birthdate')  : $user->birthdate}}">

                @if ($errors->has('birthdate'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('birthdate') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group row">
            <label for="address_line1" class="col-md-4 col-form-label text-md-right">{{ __('app.Address_line1') }}</label>
            <div class="col-md-8">
                <input type="text" name="address_line1"
                       class="form-control {{$errors->has('address_line1') ? 'is-invalid':''}}"
                       id="address_line1"
                       value="{{ old('address_line1') ? old('address_line1')  : $user->address_line1}}">

                @if ($errors->has('address_line1'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address_line1') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group row">
            <label for="address_line2" class="col-md-4 col-form-label text-md-right">{{ __('app.Address_line2') }}</label>
            <div class="col-md-8">
                <input type="text"
                       name="address_line2"
                       class="form-control {{$errors->has('address_line2') ? 'is-invalid':''}}"
                       id="address_line2"
                       value="{{ old('address_line2') ? old('address_line2')  : $user->address_line2}}">

                @if ($errors->has('address_line2'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address_line2') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('app.City') }}</label>
            <div class="col-md-8">
                <input type="text"
                       name="city"
                       class="form-control {{$errors->has('city') ? 'is-invalid':''}}"
                       id="city"
                       value="{{ old('city') ? old('city')  : $user->city}}">

                @if ($errors->has('city'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group row">
            <label for="zipcode" class="col-md-4 col-form-label text-md-right">{{ __('app.Zipcode') }}</label>
            <div class="col-md-8">
                <input type="text"
                       name="zipcode"
                       class="form-control {{$errors->has('zipcode') ? 'is-invalid':''}}"
                       id="zipcode"
                       value="{{ old('zipcode') ? old('zipcode')  : $user->zipcode}}">

                @if ($errors->has('zipcode'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('zipcode') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group row">
            <label for="phone_1" class="col-md-4 col-form-label text-md-right">{{ __('app.Phone 1') }}</label>
            <div class="col-md-8">
                <input type="text"
                       name="phone_1"
                       class="form-control {{$errors->has('phone_1') ? 'is-invalid':''}}"
                       id="phone_1"
                       value="{{ old('phone_1') ? old('phone_1')  : $user->phone_1}}">

                @if ($errors->has('phone_1'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone_1') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group row">
            <label for="phone_2" class="col-md-4 col-form-label text-md-right">{{ __('app.Phone 2') }}</label>
            <div class="col-md-8">
                <input type="text"
                       name="phone_2"
                       class="form-control {{$errors->has('phone_2') ? 'is-invalid':''}}"
                       id="phone_2"
                       value="{{ old('phone_2') ? old('phone_2')  : $user->phone_2}}">

                @if ($errors->has('phone_2'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone_2') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="newspaper"
                           id="newspaper" {{$user->newspaper == 1 ? "checked" : ""}}
                           value="1">
                    <label class="form-check-label" for="newspaper">{{ __('app.Newspaper') }}</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="newsletter"
                           id="newsletter" {{$user->newsletter == 1 ? "checked" : ""}}
                           value="1">
                    <label class="form-check-label" for="newsletter">{{ __('app.Newsletter') }}</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <h4>{{__('app.Partner informations (if family)')}}</h4>
            </div>
        </div>

        <div class="form-group row">
            <label for="gender_joint" class="col-md-4 col-form-label text-md-right">{{ __('app.Partner Gender') }}</label>
            <div class="col-md-8">
                <select class="custom-select form-control" name="gender_joint" id="gender_joint">
                    <option value="0"
                            @if($user->gender_joint == 0) selected @endif>{{ __('app.Partner Gender') }}</option>
                    <option value="1" @if($user->gender_joint == 1) selected @endif>{{ __('app.Mr') }}</option>
                    <option value="2" @if($user->gender_joint == 2) selected @endif>{{ __('app.Ms') }}</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="lastname_joint" class="col-md-4 col-form-label text-md-right">{{ __('app.Partner Lastname') }}</label>
            <div class="col-md-8">
                <input type="text"
                       name="lastname_joint"
                       class="form-control {{$errors->has('lastname_joint') ? 'is-invalid' : ''}}"
                       id="lastname_joint"
                       value="{{ old('lastname_joint') ? old('lastname_joint')  : $user->lastname_joint}}">

                @if($errors->has('lastname_joint'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('lastname_joint') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="firstname_joint" class="col-md-4 col-form-label text-md-right">{{ __('app.Partner Firstname') }}</label>
            <div class="col-md-8">
                <input type="text"
                       name="firstname_joint"
                       class="form-control {{$errors->has('firstname_joint') ? 'is-invalid' : ''}}"
                       id="firstname_joint"
                       value="{{ old('firstname_joint') ? old('firstname_joint')  : $user->firstname_joint}}">

                @if($errors->has('firstname_joint'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('firstname_joint') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="birthdate_joint" class="col-md-4 col-form-label text-md-right">{{ __('app.Partner Birthdate') }}</label>
            <div class="col-md-8">
                <input type="date"
                       name="birthdate_joint"
                       class="form-control  {{$errors->has('birthdate_joint') ? 'is-invalid' : ''}}"
                       id="birthdate_joint"
                       value="{{ old('birthdate_joint') ? old('birthdate_joint')  : $user->birthdate_joint}}">

                @if($errors->has('birthdate_joint'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('birthdate_joint') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="email_joint" class="col-md-4 col-form-label text-md-right">{{ __('app.Partner E-Mail Address') }}</label>
            <div class="col-md-8">
                <input type="email"
                       name="email_joint"
                       class="form-control {{$errors->has('email_joint') ? 'is-invalid' : ''}}"
                       id="email_joint"
                       value="{{ old('email_joint') ? old('email_joint')  : $user->email_joint}}">

                @if($errors->has('birthdate_joint'))
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email_joint') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">{{ __('app.Update') }}</button>
                <a href="{{ route('user.delete') }}" class="btn btn-outline-danger">{{ __('app.Remove account') }}</a>
            </div>
        </div>
    </form>
@endsection
