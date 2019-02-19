@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Membre {{ $user->id }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            @if($user->role->role_type_id == 2 || $user->role->role_type_id == 3 || $user->id == $post->user_id)
                <a href="{{route('user.post.edit', ['post' => $post])}}" class="btn btn-primary mr-2">Modifer</a>
                <a href="{{route('user.post.beforedelete', ['post' => $post])}}" class="btn btn-danger">Supprimer</a>
            @endif
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.post.index') }}">Annonce</a></li>
            <li class="breadcrumb-item">Annonce {{ $post->id }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-6">
            <div>
                <h2>{{ $post->title }}</h2>
            </div>
            {{ $post->text_content }}
        </div>
    </div>

@endsection

