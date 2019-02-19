@extends('layouts.app')

@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.post.index') }}">Annonce</a></li>
                <li class="breadcrumb-item">Nouvelle annonce</li>
            </ol>
        </nav>
    </div>

    <form method="post" action="{{route('user.post.store')}}">
        @csrf
        <div class="input-group">
            <label for="title">Titre de l'annonce :</label>
        </div>
        <input type="text" name="title" class="form-control">
        <div class="input-group mt-5">
            <label for="text_content">Contenu de l'annonce :</label>
        </div>
        <textarea rows="20" cols="20" type="text" name="text_content"
                  class="form-control"></textarea>
        <div class="input-group mb-3 mt-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Options</label>
            </div>
            <select class="custom-select" id="status" name="status">
                <option selected>Status</option>
                <option value="1">Donner/Vendre</option>
                <option value="2">Rechercher</option>
            </select>
        </div>
        <div class="row justify-content-around">
            <input type="submit" class="btn-sm btn-primary m-2" value="Enregistrer">
            <a class="btn-sm btn-danger m-2" href="{{route('user.post.index')}}">Annuler</a>
        </div>
    </form>
@endsection