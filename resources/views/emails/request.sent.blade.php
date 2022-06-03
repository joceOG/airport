<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Requête</title>
</head>
    <body>
        <h1 class="header">Nouvelle Requête reçue!</h1>
        <div>
            <p>Rendez vous sur votre profil dans "Mes Envois" pour répondre à cette requête.</p>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Colis
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Contenu: {{ $package->item }}</li>
                <li class="list-group-item">Catégory: {{ $package->category }}</li>
                <li class="list-group-item">Poids: {{ $package->weight }}</li>
                <li class="list-group-item">Lieu de départ: {{ $package->departure }}</li>
                <li class="list-group-item">Destination: {{ $package->destination }}</li>
                <li class="list-group-item">Prix: {{ $package->prix }}</li>
            </ul>
        </div>
        <footer class="footer">Koli&co</footer>
    </body>
</html>
