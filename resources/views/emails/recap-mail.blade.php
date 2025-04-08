    <style>
        /* CSS styles */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        
        /* Add your custom styles here */

    </style>

    <div class="container">
        <p>Bonjour,</p>

        <p>Merci de trouver ci-joint l'état du {{ $todays->format('d-m-Y') }} avec {{ $clients_validations + $client_no_validations  }} installations</p>
        
        <ul>
            <li>Routeur ZTE Installé : {{ $clients_validations }}</li>
            <li>En attente activation ZTE : {{ $client_no_validations }}</li>
            <li>Blocage client : {{ $blocage_clients }}</li>
            <li>Blocage technique : {{ $blocage_technique }}</li>
            <li>Planifier pour {{ date('d-m-Y') }} : {{ $clients_planned }}</li>
            <li>Planifié Ultérieurement/En cours de planification : {{ $clients_planned_all - $clients_planned }}</li>
            <li>Clients Hors Plaque : {{ $client_horsPlaque }}</li> <!-- Added this line -->
        </ul>

        <p>Ci-dessous le détail du blocage client et technique:</p>

        <ul>
            <li>Client a annulé sa demande {{ $blocage_cancel_client }}</li>
            <li>Client injoignable (+2 jours) {{ $blocage_injoignable }}</li>
            <li>Blocage technique : {{ $blocage_technique }}</li>
        </ul>

        <p>Cordialement,<br>
        L'équipe de support.</p>
    </div>

