<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style="width: 100%; max-width: 600px; margin: 0 auto;">
        <div style="padding: 20px;">
            <h2>Bonjour,</h2>
            <br>
            <ul>
                <li>Agent: {{ $declaration->affectation->technicien->user->getFullname() }}</li>
                <li>Adresse: {{ $declaration->affectation->client->address }}</li>
                <li>SIP: {{ $declaration->affectation->client->sip }}</li>
                <li>Ville: {{ $declaration->affectation->client->city->name }}</li>
                <li>Nom Client: {{ $declaration->affectation->client->name }}</li>
                <li>Portable: {{ $declaration->affectation->client->phone_no }}</li>
                <li>Débit: {{ $declaration->affectation->client->debit }} Méga</li>
                <li>Equipement: {{ $declaration->affectation->client->routeur_type }}</li>
                <li>SN_MAC: {{ $declaration->routeur->sn_mac }}</li>
                <li>SN_Telephone: {{ $declaration->sn_telephone }}</li>
                <li>SN_GPON: {{ $declaration->routeur->sn_gpon }}</li>
                <li>Test_signal_FO: {{ $declaration->test_signal }}</li>
            </ul>
            <br>
            <p>Cordialement,</p>
            <p>Neweracom</p>
        </div>
    </div>
</body>
</html>
