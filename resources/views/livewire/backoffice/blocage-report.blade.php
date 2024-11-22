<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('blocage-pdf', ['blocage' => $blocage]) }}" class="btn btn-primary shadow-none">
                        <i class="ri-download-2-line me-2"></i>
                        Télécharger le rapport
                    </a>
                </div>
                <h4 class="page-title">Rapport De : {{ $blocage->affectation->client->name }}</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row p-2 ps-3 pe-3">
                <div class="col-3 text-center p-2 border">
                    <img src="{{ asset('assets/images/NewEraCom.png') }}" height="120" alt="" srcset="">
                </div>
                <div class="col-6 d-flex align-items-center justify-content-center border border-left-0 border-right-0">
                    <div class="text-center">
                        <h3>PV Problème De Raccordement </h3>
                        <h5>{{ $blocage->affectation->client->name }}</h5>
                    </div>
                </div>
                <div class="col-3 text-center p-2 border">
                    <img src="{{ asset('assets/images/Orange.png') }}" height="120" alt="" srcset="">
                </div>
            </div>
            <div class="row p-2 ps-3 pe-3">
                <div class="col-7 mx-auto">
                    <table class="table table-bordered table-striped table-centered">
                        <tr>
                            <th>Nom Technicien / Tele</th>
                            <td>{{ $blocage->affectation->client->technicien->user->getFullName() . ' - ' . $blocage->affectation->client->technicien->user->returnPhoneNumber() }}
                            </td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{{ $blocage->affectation->client->name }}</td>
                        </tr>
                        <tr>
                            <th>SIP</th>
                            <td>{{ $blocage->affectation->client->sip }}</td>
                        </tr>
                        <tr>
                            <th>Prestataire</th>
                            <td>Neweracom</td>
                        </tr>
                        <tr>
                            <th>Type de blocage</th>
                            <td>{{ $blocage->cause }}</td>
                        </tr>
                        @if ($blocage->justification != null)
                            <tr>
                                <th>Justification</th>
                                <td>{{ $blocage->justification }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="row p-2 ps-3 pe-3">
                <div class="col-12">
                    @foreach ($blocage->blocagePictures as $item)
                        <div class="text-center mb-4">
                            <img src="data:image/png;base64,{{ $item->image_data }}" width="550">
                            <h4 class="mt-2">{{ $item->image }}</h4>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
