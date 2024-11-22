<style>
    /* CSS styles */
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f4f4f4;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    a {
        font-size: 14px !important
    }

    .custom-button {
        background-color: #865ea6;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Add your custom styles here */
</style>

<div class="container">
    <p>Bonjour,</p>

    <p>Je voulais vous informer que j'ai planifié un rendez-vous avec un client pour 
        {{ $new_date }}.</p>

    <p>Voici les informations du client : </p>
    <ul>
        <li style="font-size:14px !important">Nom: {{ $client->name }}</li>
        <li style="font-size:14px !important">SIP: {{ $client->sip }}</li>
        <li style="font-size:14px !important">Téléphone: {{ $client->phone_no }}</li>
        <li style="font-size:14px !important">Adresse: {{ $client->address }}</li>
        <li style="font-size:14px !important">Ville : {{ $client->city->name }}</li>
    </ul>

    <p>Le technicien {{ $old_technicien->user->getFullname() }} a signalé le blocage suivant : {{ $old_blocage }}</p>

    @if($client->feedback)
    <p>Commentaire de contrôle qualité : {{ $client->feedback->note }}</p>
    @endif

    <p>Veuillez consulter le profil client pour plus d'informations</p>

    <a class="custom-button" href="{{ route('controller.clients.profile',$client) }}"> Voir Profile Client </a>
    <br>
    <br>
    <p>Cordialement,<br>
        Contrôle Qualité</p>

</div>