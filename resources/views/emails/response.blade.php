@extends('emails.layout.mail')
@section('title')
    <title>Nouvelle Réponse</title>
@endsection
@section('content')
    <h1 class="header">Nouvelle Réponse reçue!</h1>
    @if($status === 'acceptée')
        <div>
            <P>Votre Commande a été {{ $status }} par le livreur!</P>
            <p>Rendez vous sur votre profil dans "Mes Commandes" pour voir les détails de votre commande.</p>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Colis
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Numéro de commande: #{{ $order_id }}</li>
                <li class="list-group-item">Email du livreur: {{ $courier_email }}</li>
                <li class="list-group-item">Téléphone du livreur: {{ $courier_phone }}</li>
                <li class="list-group-item">Livreur utilise whatsapp?: {{ $courier_phone }}</li>
            </ul>
        </div>
    @elseif($status === 'rejetée')
        <div>
            <p>Cette commande a été {{ $status }} par le livreur. Veuillez essayer de sélectionner un autre livreur.</p>
        </div>
    @elseif($status === 'livrée')
        <div>
            <p>Cette commande a été marquée comme {{ $status }} par le livreur</p>
        </div>
    @else
        <div>
            <p>Cette commande a été {{ $status }}.</p>
        </div>
    @endif
@endsection
