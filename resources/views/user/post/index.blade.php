@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Annonce</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('user.post.create') }}" class="btn btn-success">Ajouter une annonce</a>
        </div>
    </div>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item">Annonce</li>
            </ol>
        </nav>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Titre</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <th scope="row">{{ $post->updated_at }}</th>
                <td>{{ $post->title }}</td>
                <td>{{ $post->status }}</td>
                <td class="text-right">
                    <a href="{{ route('user.post.show', $post) }}" class="btn btn-sm btn-outline-primary"><span
                                data-feather="more-horizontal"></span> Accéder</a>
                    <a class="btn btn-sm btn-outline-danger"
                       href="{{ route('user.post.beforedelete', $post) }}"><span
                                data-feather="trash"></span> Supprimer</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination justify-content-center">{{ $posts->links() }}</div>
@endsection