@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Suppression du membre</h1>
    </div>

    @if($user->subscriptions_count > 0 || $user->gifts_count > 0 || $user->newlsetter_count > 0)
        <p>Ce membre a effectué un adhésion, un don, ou une newsletter et ne peut pas etre completement supprimé de la base de donnée</p>
    @else
        <p>Ce membre n'a pas d'adhésion ou de don et sera completement supprimé de la base de donnée</p>
    @endif

    <form action="{{ route('admin.user.destroy', $user) }}" method="post">
        <p>Souhaitez-vous supprimer {{ $user->firstname }} {{ $user->lastname }} ?</p>
        @csrf
        @method('DELETE')
        <input type="submit" class="btn btn-danger" value="Oui">
        <a type="button" class="btn btn-secondary ml-2" href="{{ route('user.index') }}">Non</a>
    </form>

@endsection
