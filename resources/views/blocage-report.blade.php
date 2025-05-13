<div>
    <div class="line">
        <img src="{{ public_path('assets/images/Orange.png') }}" alt="Image 2" class="logo">
        <h4>PV Problème De Raccordement</h4>
        <h4 class="text">DTF</h4>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Informations sur le client</h4>
    </div>
    <div>
        <table>
            <tr>
                <th style="width:35%">Date de la demande</th>
                <td>{{$blocage->affectation->client->created_at->format('d/m/Y H:i')}}</td>
            </tr>
            <tr>
                <th>Client</th>
                <td>{{$blocage->affectation->client->name }}</td>
            </tr>
            <tr>
                <th>Sous Type Opportunité</th>
                <td>{{$blocage->affectation->client->offre }}</td>
            </tr>
            <tr>
                <th>SIP</th>
                <td>{{$blocage->affectation->client->sip }}</td>
            </tr>
            <tr>
                <th>Ville</th>
                <td>{{$blocage->affectation->client->city->name }}</td>
            </tr>
            <tr>
                <th>Technicien</th>
                <td>{{ $blocage->affectation->client->technicien->user->first_name.'
                    '.$blocage->affectation->client->technicien->user->last_name}}</td>
            </tr>
        </table>
    </div>
    <div class="line bg-black mt-5 h-25">
        <h4>Informations sur le blocage</h4>
    </div>
    <div>
        <table>
            <tr>
                <th style="width:35%">Type de blocage</th>
                <td>{{$blocage->cause }}</td>
            </tr>
        </table>
    </div>
    <div class="row text-center">
    @php
        $sortedImages = $blocage->blocagePictures->sortBy(function ($item) use ($imageOrder) {
            return array_search($item->image, $imageOrder);
        });
    @endphp
    @foreach ($sortedImages as $item)
            <div class="column" style="width: 48%; margin: 1%;">
                <p>{{ $item->image }}</p>
                @if ($item->image_url)
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->image }}" style="width: 100%; height: auto;">
                @else
                    <img src="data:image/png;base64,{{ $item->image_data }}" alt="{{ $item->image }}" style="width: 100%; height: auto;">
                @endif
            </div>
        @endforeach
    </div>
    

</div>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap');

    . {
        font-size: 12px !important;
        font-family: 'Montserrat';
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
        font-size: 13px;
        text-align: center;
        vertical-align: middle;
    }

    table td {
        border: 1px solid black;
        padding: 5px;
        height: 35px;
        font-size: 13px;
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