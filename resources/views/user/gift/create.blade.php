@extends('layouts.app')

@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item">Dons</li>
            </ol>
        </nav>
    </div>
    <div>
        <div class="row">
            <div class="col-12">
                <div>
                    <h1>Faire un Don</h1>
                </div>
                <div class="text-center p-5 border border-success rounded">
                    <h5>Participer d'avantage à l'Association {{config('app.name')}}</h5>

                    <div class="col-12 col-md-4 offset-md-4 mt-5">
                        <form action="{{route('user.gift.store')}}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="amount" class="form-control text-right">
                                <div class="input-group-append">
                                    <span class="input-group-text">€</span>
                                </div>
                                <select class="form-control text-center ml-3" name="payment_methods">
                                    @foreach($payments_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}">
                                            {{ $payment_method->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input value="Donner" type="submit" class="btn btn-outline-success btn-block pt-2 mt-2">
                        </form>
                    </div>

                </div>

            </div>

        </div>
        <div class="row pt-5">
            <div class="col-12">
                <div>
                    <h1>Votre Historique de don</h1>
                </div>
                <div class="text-center p-5 border border-success rounded">
                    <table class="table">
                        <thead class="bg-success text-white">
                        <tr>
                            <th scope="col">Donateur</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Date</th>
                            <th scope="col">Methode de paiement</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($user->gifts as $gift)
                            <tr>
                                <td scope="row">{{$user->firstname}} {{$user->lastname}}</td>
                                <th>{{ $gift->amount }} €</th>
                                <td>{{ $gift->created_at->format('d/m/Y') }}</td>
                                <td> {{ $gift->payment ? $gift->payment->paymentMethod->name : '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Vous n'avez réalisé aucun don pour le moment ...</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
@endsection