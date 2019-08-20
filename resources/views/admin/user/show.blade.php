@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>{{ __('app.Member') }} {{ $user->id }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.user.gift.create', $user) }}" class="btn btn-success mr-2">Ajouter un Don</a> <a
                    href="{{ route('admin.subscription.create') }}" class="btn btn-success mr-2">Ajouter une
                Adhésion</a> <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-primary mr-2">Modifier</a>
            <a href="{{route('admin.user.delete', ['user' => $user])}}" class="btn btn-danger">Supprimer</a>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">{{ __('app.Members') }}</a></li>
            <li class="breadcrumb-item">{{ __('app.Member') }} {{ $user->id }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-sm-6">
            <h2>{{ $user->firstname }} {{ $user->lastname }}</h2>

            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Gender') }}</div>
                <div class="col-sm-6">
                    @if($user->gender == 0)
                        {{ __('app.Gender') }}
                    @elseif($user->gender == 1)
                        {{ __('app.Mr') }}
                    @elseif($user->gender == 2)
                        {{ __('app.Ms') }}
                    @endif

                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Lastname') }}</div>
                <div class="col-sm-6">
                    {{ $user->lastname }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Firstname') }}</div>
                <div class="col-sm-6">
                    {{ $user->firstname }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.E-Mail Address') }}</div>
                <div class="col-sm-6">
                    {{ $user->email }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Birthdate') }}</div>
                <div class="col-sm-6">
                    {{ $user->birthdate }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Address_line1') }}</div>
                <div class="col-sm-6">
                    {{ $user->address_line1 }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Address_line2') }}</div>
                <div class="col-sm-6">
                    {{ $user->address_line2 }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.City') }}</div>
                <div class="col-sm-6">
                    {{ $user->city }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Zipcode') }}</div>
                <div class="col-sm-6">
                    {{ $user->zipcode }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Phone 1') }}</div>
                <div class="col-sm-6">
                    {{ $user->phone_1 }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Phone 2') }}</div>
                <div class="col-sm-6">
                    {{ $user->phone_2 }}
                </div>
            </div>


            <div class="col-6">
                <input class="form-check-input" type="checkbox" name="newspaper" id="newspaper"
                       {{$user->newspaper == 1 ? "checked" : ""}} value="1" disabled> <label class="col-sm-8"
                                                                                             class="form-check-label"
                                                                                             for="newspaper">{{ __('app.Newspaper') }}</label>

            </div>

            <div class="col-6">
                <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter"
                       {{$user->newsletter == 1 ? "checked" : ""}} value="1" disabled> <label class="col-sm-8"
                                                                                              class="form-check-label"
                                                                                              for="newsletter">{{ __('app.Newsletter') }}</label>
            </div>


            <h2 class="mt-5">Infos Conjoint
                <small>(facultatif)</small>
            </h2>
            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Partner Gender') }}</div>
                <div class="col-sm-6">
                    @if($user->gender_joint == 0)
                        -
                    @elseif($user->gender_joint == 1)
                        {{ __('app.Mr') }}
                    @elseif($user->gender_joint == 2)
                        {{ __('app.Ms') }}
                    @endif

                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Partner Lastname') }}</div>
                <div class="col-sm-6">
                    {{ $user->lastname_joint }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Partner Firstname') }}</div>
                <div class="col-sm-6">
                    {{ $user->firstname_joint }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Partner Birthdate') }}</div>
                <div class="col-sm-6">
                    {{ $user->birthdate_joint }}
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">{{ __('app.Partner E-Mail Address') }}</div>
                <div class="col-sm-6">
                    {{ $user->email_joint }}
                </div>

            </div>
        </div>
        <div class="col-sm-6">
            <h2>Adhésions</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Depuis</th>
                    <th>Jusqu'au</th>
                    <th>Montant</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if($user->subscriptions)

                    @forelse($user->subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->date_start }}</td>
                            <td>{{ $subscription->date_end }}</td>
                            <td>{{ $subscription->amount }}</td>
                            <td>{{ $subscription->type->name }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.subscription.edit', $subscription) }}"
                                   class="btn btn-sm btn-outline-primary"><span data-feather="edit"></span></a> <a
                                        class="btn btn-sm btn-outline-danger"
                                        href="{{ route('admin.subscription.delete', $subscription) }}"><span
                                            data-feather="trash"></span> Supprimer</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Aucune adhésion</td>
                        </tr>
                    @endforelse
                @endif
                </tbody>
            </table>


            <h2>Dons</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Methode de paiement</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if($user->gifts)
                    @forelse($user->gifts as $gift)
                        <tr>
                            <td>{{ $gift->created_at->format('d/m/Y') }}</td>
                            <td>{{ $gift->amount }}</td>
                            <td>{{ $gift->payment->paymentMethod->name }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.gift.edit', $gift) }}"
                                   class="btn btn-sm btn-outline-primary"><span data-feather="edit"></span> Modifier</a>
                                <a class="btn btn-sm btn-outline-danger" href="{{ route('admin.gift.delete', $gift) }}"><span
                                            data-feather="trash"></span> Supprimer</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Aucun don</td>
                        </tr>
                    @endforelse
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection