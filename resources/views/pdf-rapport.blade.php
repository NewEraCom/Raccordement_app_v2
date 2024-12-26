<div>
    <div class="line">
        <img src="{{ public_path('assets/images/Orange.png') }}" alt="Image 2" class="logo">
        <h4>Rapport d'intervention Client Fixe</h4>
        <h4 class="text">DTF</h4>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Informations sur l'intervention</h4>
    </div>
    <div>
        <table>
            <tr>
                <th>Date de la demande</th>
                <th>Priorité</th>
                <th>Type d'intervention</th>
                <th>Date prévue de l'intervention</th>
                <th>Prestataire</th>
            </tr>
            <tr>
                <td>{{ $client->created_at}}</td>
                <td></td>
                <td>Intégration</td>
                <td></td>
                <td>Neweracom_Prestataire</td>
            </tr>

        </table>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Données client</h4>
    </div>
    <div>
        <table>
            <tr>
                <td style="width:35%">Nom et Prénom</td>
                <td style="width:65%">{{ $client->name }}</td>
            </tr>
            <tr>
                <td>Adresse</td>
                <td>{{ $client->address }}</td>
            </tr>
            <tr>
                <td>Ville</td>
                <td>{{ $client->city->name }}</td>
            </tr>
            <tr>
                <td>Nom du contact</td>
                <td>{{ $client->name }}</td>
            </tr>
            <tr>
                <td>Numéro de téléphone et Prénom</td>
                <td>{{ $client->phone_no }}</td>
            </tr>
            <tr>
                <td>Service</td>
                <td></td>
            </tr>
            <tr>
                <td>Type de la demande</td>
                <td>{{ $client->offre }}</td>
            </tr>
        </table>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>interenants Prestataire/Client</h4>
    </div>
    <div>
        <table>
            <tr>
                <th>Prestataire</th>
                <th>Nom de l'intervenant </th>
                <th>Téléphone</th>
                <th>Date d'intervention</th>
            </tr>
            <tr>
                <td>Neweracom_Prestataire</td>
                <td>{{ $client->technicien->user->first_name.' '.$client->technicien->user->last_name }}</td>
                <td>{{ $client->technicien->user->phone_no }}</td>
                <td>{{ $client->declarations->first()->created_at }}</td>
            </tr>

        </table>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Equipements remis au client</h4>
    </div>
    <div>
        <table>
            <tr>
                <th colspan="2">Equipement</th>
                <th>Qté</th>
                <th colspan="2">Référence</th>
                <th colspan="2">S/N & Mac</th>
            </tr>
            <tr class="bg-grey">
                <td>Nouveau</td>
                <td>Ancien</td>
                <td></td>
                <td>Nouveau</td>
                <td>Ancien</td>
                <td>Nouveau</td>
                <td>Ancien</td>
            </tr>
            <tr>
                <td>ROUTEUR</td>
                <td></td>
                <td>1</td>
                <td></td>
                <td></td>
                <td>{{ $client->declarations->first()->routeur->sn_mac }}</td>
                <td></td>
            </tr>
            <tr>
                <td>GPON</td>
                <td></td>
                <td>1</td>
                <td></td>
                <td></td>
                <td>{{ $client->declarations->first()->routeur->sn_gpon }}</td>
                <td></td>
            </tr>
            <tr>
                <td>TEL</td>
                <td></td>
                <td>{{ $client->declarations->first()->sn_telephone ? 1 : 0 }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
<div>
    <div class="line">
        <img src="{{ public_path('assets/images/Orange.png') }}" alt="Image 2" class="logo">
        <h4>Rapport d'intervention Client Fixe</h4>
        <h4 class="text">DTF</h4>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Reportage photos</h4>
    </div>
    <div class="row text-center">
        <div class="column">
            <p>Équipement installé</p>
            @if ($client->validations->first()->router_tel_image_url)
               
                <img src="{{ asset('storage/' . $client->validations->first()->router_tel_image_url) }}" width="80%" alt="" srcset="">
            @elseif ($client->validations->first()->router_tel_image)
                
                <img src="data:image/png;base64,{{ $client->validations->first()->router_tel_image }}" width="80%" alt="" srcset="">
            @endif
        </div>
        <div class="column">
            <p>Test de signal (photomètre)</p>
            @if ($client->declarations->first()->image_test_signal_url)
               
                <img src="{{ asset('storage/' . $client->declarations->first()->image_test_signal_url) }}" width="80%" alt="" srcset="">
            @elseif ($client->declarations->first()->image_test_signal)
                
                <img src="data:image/png;base64,{{ $client->declarations->first()->image_test_signal }}" width="80%" alt="" srcset="">
            @endif
        </div>
    </div>
    
    <div class="row text-center mt-5">
        <div class="column">
            <p>Test de débit (Par câble)</p>
            @if ($client->validations->last()->test_debit_via_cable_image_url)
               
                <img src="{{ asset('storage/' . $client->validations->last()->test_debit_via_cable_image_url) }}" width="80%" alt="Test débit via câble">
            @elseif ($client->validations->last()->test_debit_via_cable_image)
                
                <img src="data:image/png;base64,{{ $client->validations->last()->test_debit_via_cable_image }}" width="80%" alt="Test débit via câble">
            @endif
        </div>
        <div class="column">
            <p>Test de débit (Par wifi)</p>
            @if ($client->validations->first()->photo_test_debit_via_wifi_image_url)
               
                <img src="{{ asset('storage/' . $client->validations->first()->photo_test_debit_via_wifi_image_url) }}" width="80%" alt="Test débit via wifi">
            @elseif ($client->validations->first()->photo_test_debit_via_wifi_image)
                
                <img src="data:image/png;base64,{{ $client->validations->first()->photo_test_debit_via_wifi_image }}" width="80%" alt="Test débit via wifi">
            @endif
        </div>
    </div>
    
</div>

<div class="page-break"></div>
<div>
    
    <div class="line">
        <img src="{{ public_path('assets/images/Orange.png') }}" alt="Image 2" class="logo">
        <h4>Rapport d'intervention Client Fixe</h4>
        <h4 class="text">DTF</h4>
    </div>
    <div class="row text-center">
        <div class="column">
            <p>Photo PBI avant l'installation</p>
            @if ($client->declarations->first()->image_pbi_before_url)
               
                <img src="{{ asset('storage/' . $client->declarations->first()->image_pbi_before_url) }}" width="80%" alt="Photo PBI avant l'installation">
            @elseif ($client->declarations->first()->image_pbi_before)
                
                <img src="data:image/png;base64,{{ $client->declarations->first()->image_pbi_before }}" width="80%" alt="Photo PBI avant l'installation">
            @endif
        </div>
        <div class="column">
            <p>Photo PBI après l'installation</p>
            @if ($client->declarations->first()->image_pbi_after_url)
               
                <img src="{{ asset('storage/' . $client->declarations->first()->image_pbi_after_url) }}" width="80%" alt="Photo PBI après l'installation">
            @elseif ($client->declarations->first()->image_pbi_after)
                
                <img src="data:image/png;base64,{{ $client->declarations->first()->image_pbi_after }}" width="80%" alt="Photo PBI après l'installation">
            @endif
        </div>
    </div>
    
    <div class="row text-center mt-5">
        <div class="column">
            <p>Photo PBO avant l’installation</p>
            @if ($client->declarations->first()->image_pbo_before_url)
               
                <img src="{{ asset('storage/' . $client->declarations->first()->image_pbo_before_url) }}" width="80%" alt="Photo PBO avant l’installation">
            @elseif ($client->declarations->first()->image_pbo_before)
                
                <img src="data:image/png;base64,{{ $client->declarations->first()->image_pbo_before }}" width="80%" alt="Photo PBO avant l’installation">
            @endif
        </div>
        <div class="column">
            <p>Photo PBO après l’installation</p>
            @if ($client->declarations->first()->image_pbo_after_url)
               
                <img src="{{ asset('storage/' . $client->declarations->first()->image_pbo_after_url) }}" width="80%" alt="Photo PBO après l’installation">
            @elseif ($client->declarations->first()->image_pbo_after)
                
                <img src="data:image/png;base64,{{ $client->declarations->first()->image_pbo_after }}" width="80%" alt="Photo PBO après l’installation">
            @endif
        </div>
    </div>
    

</div>
<div class="page-break"></div>
<div>
    <div class="line">
        <img src="{{ public_path('assets/images/Orange.png') }}" alt="Image 2" class="logo">
        <h4>Rapport d'intervention Client Fixe</h4>
        <h4 class="text">DTF</h4>
    </div>
    <div class="row text-center">
        <div class="">
            <p>Etiquetage outdoor:</p>
            @if ($client->validations->last()->etiquetage_image_url)
               
                <img src="{{ asset('storage/' . $client->validations->last()->etiquetage_image_url) }}" width="30%" alt="Etiquetage outdoor">
            @elseif ($client->validations->last()->etiquetage_image)
                
                <img src="data:image/png;base64,{{ $client->validations->last()->etiquetage_image }}" width="30%" alt="Etiquetage outdoor">
            @endif
        </div>
        
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Réception de service</h4>
    </div>
    <div class="row text-center">
        <div class="">
            <p>PV d'installation:</p>
            @if ($client->validations->last()->pv_image_url)
                
                <img src="{{ asset('storage/' . $client->validations->last()->pv_image_url) }}" width="50%" alt="PV d'installation">
            @elseif ($client->validations->last()->pv_image)

                <img src="data:image/png;base64,{{ $client->validations->last()->pv_image }}" width="50%" alt="PV d'installation">
            @endif
        </div>
        
    </div>
</div>

<div class="page-break"></div>
<div>
    <div class="line">
        <img src="{{ public_path('assets/images/Orange.png') }}" alt="Image 2" class="logo">
        <h4>Rapport d'intervention Client Fixe</h4>
        <h4 class="text">DTF</h4>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Commentaires</h4>
    </div>
    <div>
        <table>
            <tr>
                <td style="width:75%;text-align:left">Service Internet:</td>
                <td style="text-align:left">Ok</td>
            </tr>
            <tr>
                <td style="width:75%;text-align:left">Service Voix:</td>
                <td style="text-align:left">Ok</td>
            </tr>
            <tr>
                <td style="width:75%;text-align:left">Emplacement du matériel choisi par le client:</td>
                <td style="text-align:left">..............</td>
            </tr>
            <tr>
                <td style="width:75%;text-align:left">Mot de passe d’accès à distance :</td>
                <td style="text-align:left">..............</td>
            </tr>
        </table>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Commentaires</h4>
    </div>
    <div>
        <table>
            <tr>
                <td style="width:35%;text-align:left">Date:</td>
                <td style="text-align:left">
                    ........................................................................................................
                </td>
            </tr>
            <tr>
                <td style="width:35%;text-align:left">ApprobateurOrange:</td>
                <td style="text-align:left">
                    ........................................................................................................
                </td>
            </tr>
            <tr>
                <td style="width:35%;text-align:left">Signature:</td>
                <td style="text-align:left">
                    ........................................................................................................
                </td>
            </tr>
        </table>
    </div>
</div>
<style>
    . {
        font-size: 12.5px !important;
    }

    .column {
        float: left;
        width: 49.34%;
        padding: 5px;
    }

    /* Clear floats after image containers */
    .row::after {
        content: "";
        clear: both;
        display: table;
    }

    .page-break {
        page-break-after: always;
    }

    .line {
        width: 100%;
        height: 95px;
        position: relative;
        border: #000000 1px solid;
    }

    .line .logo {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-right: 0.5px black solid;
    }

    .line .text {
        position: absolute;
        left: 90%;
        top: 30%;
        text-align: center;
        transform: translate(-50%, -50%);
    }

    .line .logo:first-child {
        left: 0;
    }

    .line h4 {
        position: absolute;
        left: 50%;
        top: 30%;
        text-align: center;
        transform: translate(-50%, -50%);
    }

    .line .logo:last-child {
        right: 0;
    }

    .first-pic {
        border: 1px solid black;
        padding: 10px;
    }

    .mt-5 {
        margin-top: 15px;
    }

    .p-5 {
        padding: 15px;
    }

    .h-25 {
        height: 55px;
        text-align: center;
        vertical-align: middle;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th {
        border: 1px solid black;
        padding: 5px;
        height: 35px;
        background-color: #FF7900;
        text-align: center;
        vertical-align: middle;
    }

    table td {
        border: 1px solid black;
        padding: 5px;
        height: 35px;
        text-align: center;
        vertical-align: middle;
    }

    .td-left {
        text-align: left !important;
    }

    .td-right {
        text-align: right !important;
    }

    footer {
        position: fixed;
        bottom: -30px;
        left: 0px;
        right: 0px;
        height: 50px;
        font-size: 14px !important;
        text-align: left;
        line-height: 35px;
    }

    .text-center {
        text-align: center;
    }

    .text-blue-1 {
        color: #192969;
    }

    .text-blue-2 {
        color: #304fcf;
    }

    .underline {
        text-decoration: underline;
    }

    .border {
        border: 1px solid black;
    }

    .bg-black {
        background-color: #000000;
        color: white;
    }

    .bg-grey {
        background-color: #e0e0e0;
    }

    .table-schema {
        margin: 0 auto;
        width: 60%;
        border-collapse: collapse;
    }

    .table-keys {
        margin: 0 auto;
        width: 75%;
        border-collapse: collapse;
    }

    span {
        display: inline-block;
    }

    .td-60 {
        height: 120px !important;
    }

    .mt-auto {
        margin: auto;
    }
</style>
