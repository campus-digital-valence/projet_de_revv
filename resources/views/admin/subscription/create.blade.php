@extends('layouts.app')

@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Membres</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.user.show', Auth::user()) }}">Informations
                        utilisateur</a></li>
                <li class="breadcrumb-item">Création d'adhésion</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12">
            <h1>Creation d'Adhésion</h1>
            <div class="col-12 col-md-8 offset-md-2 mt-5">
                <form method="POST" action="{{route('admin.subscription.store')}}"
                      aria-label="{{ __('Subscription') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="subscription_type"
                               class="col-md-4 col-form-label text-md-right">Identifiant de l'Adhérent</label>
                        <div class="col-md-6">
                            <input type="text" name="user_id"
                                   class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }} text-right"
                                   placeholder="Saisir l'id du donateur ici"
                                   value="{{ old('user_id') ? old('user_id') : ''}}"
                            >
                            @if ($errors->has('user_id'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="subscription_type"
                               class="col-md-4 col-form-label text-md-right">Type d'Adhésion</label>
                        <div class="col-md-6">
                            <select id="subscription_type_id" name="subscription_type_id" class="custom-select">
                                @foreach($subscriptionTypes as $subscription_type)
                                    <option value="{{ $subscription_type->id }}"
                                            data-amount="{{ $subscription_type->amount }}">
                                        {{ $subscription_type->name }} ({{$subscription_type->amount}} €)
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('subscription_type_id'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('subscription_type_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount"
                               class="col-md-4 col-form-label text-md-right">{{ __('amount') }}</label>
                        <div class="col-md-6">
                            <input id="amount" type="text"
                                   class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                   name="amount" value="{{ old('amount') ? old('amount') : '0.00'}}">
                            @if ($errors->has('amount'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="payment_methods"
                               class="col-md-4 col-form-label text-md-right">Moyen de paiement</label>
                        <div class="col-md-6">
                            <select id="payment_methods" name="payment_methods" class="custom-select">
                                @foreach($paymentsMethods as $payment_method)
                                    <option value="{{ $payment_method->id }}">
                                        {{ $payment_method->name}}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('payment_methods'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('payment_methods') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date_start"
                               class="col-md-4 col-form-label text-md-right">Date de début</label>
                        <div class="col-md-6">
                            <input id="date_start" name="date_start" type="date"
                                   class="form-control{{ $errors->has('date_start') ? ' is-invalid' : '' }}"
                                   value="{{  date('Y-m-d')}}">
                            @if ($errors->has('date_start'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_start') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Validate') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function selectedtype() {
                let amount = $('#subscription_type_id option:selected').data('amount');
                $('#amount').val(amount);
            }

            $('#subscription_type_id').change(selectedtype);
            selectedtype();

        </script>
    @endpush
@endsection