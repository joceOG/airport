@extends('emails.layout.mail')
@section('title')
<title>Mise à jour sur la livraison</title>
@endsection
@section('content')
<h1 class="header">Confirmation de livraison!</h1>
@if($status === 'livrée')
    <div>
        <p>Votre livraison pour la commande #{{ $order_id }}a été a été marquée comme {{ $status }} par le destinataire.</p>
        <p>Le paiement pour cette livraison est en cours de traitement.</p>
        <p>Rendez vous sur votre profil dans "Mes Livraisons" pour voir le nouveau status de votre livraison.</p>
    </div>
@elseif($status === 'non-livrée')
    <div>
        <p>Cette commande a été marquée comme {{ $status }} par l'envoyeur.</p>
    </div>
@else
    <div>
        <p>Cette commande a été {{ $status }}.</p>
    </div>
@endif

@endsection

