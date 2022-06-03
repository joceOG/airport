@extends('layout.mail')
@section('title')
    <title>Nouvelle Requête</title>
@endsection
@section('content')
    <h1 class="header">Nouvelle Requête reçue!</h1>
    <div>
        <p>Rendez vous sur votre profil dans "Mes Envois" pour répondre à cette requête.</p>
    </div>
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            Colis
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Contenu: {{ $item }}</li>
            <li class="list-group-item">Catégory: {{ $category }}</li>
            <li class="list-group-item">Poids: {{ $weight }}</li>
            <li class="list-group-item">Lieu de départ: {{ $departure }}</li>
            <li class="list-group-item">Destination: {{ $destination }}</li>
            <li class="list-group-item">Prix: {{ $prix }}</li>
        </ul>
    </div>
@endsection
