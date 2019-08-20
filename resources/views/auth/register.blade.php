@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 py-4">
                <div class="card">
                    <div class="card-header">{{ __('app.Register') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('app.Register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.E-Mail Address') }}</label>
                                <div class="col-md-8">
                                    <input id="email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Password') }}</label>
                                <div class="col-md-8">
                                    <input id="password" type="password"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Confirm Password') }}</label>
                                <div class="col-md-8">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>


                            <h4>{{__('app.Personal Informations')}}</h4>

                            <div class="form-group row">
                                <label for="gender"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Gender') }}</label>
                                <div class="col-md-8">
                                    <select id="gender" name="gender"
                                            class="custom-select{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                        <option value="0">  {{ __('app.Choose gender') }}</option>
                                        <option value="1"
                                                @if(old('gender') ==1)selected @endif> {{ __('app.Mr') }}</option>
                                        <option value="2"
                                                @if(old('gender') ==2)selected @endif>{{ __('app.Ms') }}</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastname"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Lastname') }}</label>
                                <div class="col-md-8">
                                    <input id="lastname" type="text"
                                           class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                           name="lastname" value="{{ old('lastname') }}" required>
                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="firstname"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Firstname') }}</label>
                                <div class="col-md-8">
                                    <input id="firstname" type="text"
                                           class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                           name="firstname" value="{{ old('firstname') }}" required>
                                    @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birthdate"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Birthdate') }}</label>
                                <div class="col-md-8">
                                    <input id="birthdate" type="date"
                                           class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}"
                                           name="birthdate" value="{{ old('birthdate') }}" required>
                                    @if ($errors->has('birthdate'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address_line1"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Address_line1') }}</label>
                                <div class="col-md-8">
                                    <input id="address_line1" type="text"
                                           class="form-control{{ $errors->has('address_line1') ? ' is-invalid' : '' }}"
                                           name="address_line1" value="{{ old('address_line1') }}" required>
                                    @if ($errors->has('address_line1'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address_line1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address_line2"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Address_line2') }}</label>
                                <div class="col-md-8">
                                    <input id="address_line2" type="text"
                                           class="form-control"
                                           name="address_line2" value="{{ old('address_line2') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="zipcode"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Zipcode') }}</label>
                                <div class="col-md-8">
                                    <input id="zipcode" type="text"
                                           class="form-control {{ $errors->has('zipcode') ? ' is-invalid' : '' }}"
                                           name="zipcode" value="{{ old('zipcode') }}" required>
                                    @if ($errors->has('zipcode'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('zipcode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('app.City') }}</label>
                                <div class="col-md-8">
                                    <input id="city" type="text"
                                           class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                           name="city" value="{{ old('city') }}" required>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone_1"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Phone 1') }}</label>
                                <div class="col-md-8">
                                    <input id="phone_1" type="text"
                                           class="form-control {{ $errors->has('phone_1') ? ' is-invalid' : '' }}"
                                           name="phone_1" value="{{ old('phone_1') }}" required>
                                    @if ($errors->has('phone_1'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone_2"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Phone 2') }}</label>
                                <div class="col-md-8">
                                    <input id="phone_2" type="text"
                                           class="form-control {{ $errors->has('phone_2') ? ' is-invalid' : '' }}"
                                           name="phone_2" value="{{ old('phone_2') }}">
                                    @if ($errors->has('phone_2'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_2') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter" value="1"
                                               @if(old('newsletter') == 1) checked @endif>
                                        <label for="newsletter"
                                               class="col-form-label text-md-right">{{ __('app.Subscribe to the newsletter') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="newspaper" id="newspaper" value="1"
                                               @if(old('newspaper') == 1) checked @endif>
                                        <label for="newspaper"
                                               class="col-form-label text-md-right">{{ __('app.Subscribe to the newspaper') }}</label>
                                    </div>
                                </div>
                            </div>

                            <h4>{{__('app.Partner informations (if family)')}}</h4>
                            <div class="form-group row">
                                <label for="gender_joint"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Partner Gender') }}</label>
                                <div class="col-md-8">
                                    <select id="gender_joint" name="gender_joint" class="custom-select">
                                        <option value="0"
                                                @if(old('gender_joint') == 0) selected @endif>{{ __('app.Partner Gender') }}</option>
                                        <option value="1"
                                                @if(old('gender_joint') == 1) selected @endif>{{ __('app.Mr') }}</option>
                                        <option value="2"
                                                @if(old('gender_joint') == 2) selected @endif>{{ __('app.Ms') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastname_joint"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Partner Lastname') }}</label>
                                <div class="col-md-8">
                                    <input id="lastname_joint"
                                           type="text"
                                           class="form-control"
                                           name="lastname_joint"
                                           value="{{ old('lastname_joint') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="firstname_joint"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Partner Firstname') }}</label>
                                <div class="col-md-8">
                                    <input id="firstname_joint" type="text"
                                           class="form-control"
                                           name="firstname_joint" value="{{ old('firstname_joint') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email_joint"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Partner E-Mail Address') }}</label>
                                <div class="col-md-8">
                                    <input id="email_joint" type="email"
                                           class="form-control"
                                           name="email_joint" value="{{ old('email_joint') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birthdate_joint"
                                       class="col-md-4 col-form-label text-md-right">{{ __('app.Partner Birthdate') }}</label>
                                <div class="col-md-8">
                                    <input id="birthdate_joint" type="date"
                                           class="form-control"
                                           name="birthdate_joint" value="{{ old('birthdate_joint') }}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('app.Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
