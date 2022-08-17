@extends('emails.layout')

@section('content')
    <p>{{ $message }}</p>
    <button class="btn btn-success"><a href="{{ url('http://127.0.0.1:8000/') }}">Retour vers la page d'accueil</a></button>
@endsection
