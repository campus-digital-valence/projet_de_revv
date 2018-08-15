@extends('layouts.app')

@section('content')

    <h1>Modification de l'Adhésion</h1>
    <h2>{{$subscription->user->firstname}} {{$subscription->user->lastname}}</h2>

    <div class="col-12 col-md-8 offset-md-2 mt-5">
        <form action="{{route('admin.subscription.update', ['id' => $subscription->id])}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="subscription_type"
                       class="col-md-4 col-form-label text-md-right">Identifiant de l'Adhérant</label>
                <div class="col-md-6">
                    <input type="text" name="user_id"
                           class="form-control text-right"
                           placeholder="Saisir l'id du donateur ici" value="{{$subscription->user_id}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="subscription_type"
                       class="col-md-4 col-form-label text-md-right">Type d'Adhésion</label>
                <div class="col-md-6">
                    <select id="subscription_type_id" name="subscription_type_id" class="custom-select">
                        @foreach($subscriptionTypes as $subscription_type)
                            <option value="{{ $subscription_type->id }}" {{ $subscription_type->id == $subscription->subscription_type_id ? 'selected' : ''}}>
                                {{ $subscription_type->name }} ({{$subscription_type->amount}} €)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="amount"
                       class="col-md-4 col-form-label text-md-right">Montant</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input id="amount" type="text"
                               class="form-control text-right {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                               name="amount"
                               value="{{ old('amount') ? old('amount') : $subscription->amount }}">
                        <div class="input-group-append">
                            <span class="input-group-text">€</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="payment_methods"
                       class="col-md-4 col-form-label text-md-right">Moyen de paiement</label>
                <div class="col-md-6">
                    <select id="payment_methods" name="payment_methods" class="custom-select">
                        @foreach($paymentsMethods as $payment_method)
                            <option value="{{ $payment_method->id }}" {{$payment_method->id == $subscription->payment->payment_method_id ? 'selected' : ''}}>

                                {{ $payment_method->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="subscription_date"
                       class="col-md-4 col-form-label text-md-right">Date de départ</label>
                <div class="col-md-6">
                    <input id="subscription_date" type="date"
                           class="form-control{{ $errors->has('subscription_date') ? ' is-invalid' : '' }}"
                           name="subscription_date"
                           value="{{  old('subscription_date') ?  old('subscription_date') : $subscription->subscription_date}}">
                </div>
            </div>


            <input type="submit" class="btn btn-primary" value="Editer">
        </form>
    </div>
@endsection