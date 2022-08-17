@extends('emails.layout.mail')
@section('title')
    <title>Nouveau compte</title>
@endsection
@section('content')
    <h1 class="header">Votre Nouveau compte a été crée!!</h1>
    <div>
        <p>Bienvenue chez Koli&co {{ $first_name }} !</p>
        <p>Pour terminer la vérification vous devez:</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Aller sur votre profil dans 'Mes Détails' et téléverser un copie des deux faces d'une pièce d'identité gouvernementale (avec photo)</li>
            <li class="list-group-item">Clickez sur ce lien pour vérifier votre adresse e-mail: {{ url('http://127.0.0.1:8000/user/validate/' . $user_id) }}</li>
        </ul>
        <p>Vous pouver aussi téléverser une copie de la page d'identification de votre passport si il n'est pas utilisé comme votre pièce d'identité principale..</p>
    </div>
@endsection
