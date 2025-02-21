<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                </div>
                <h4 class="page-title">{{ $client->name }}</h4>
            </div>
        </div>
    </div>

    <div class="card bg-{{ $client->getStatusColor() }} shadow-none">
        <div class="card-body profile-user-box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row align-items-center">
                        <div class="col">
                            <div>
                                <h4 class="mt-1 mb-1 text-white">{{ $client->name }}</h4>
                                <p class="font-13 text-white-50"></p>
                                <ul class="mb-0 list-inline text-light">
                                    <li class="list-inline-item me-3">
                                        <h5 class="mb-1 text-white">{{ $client->created_at->format('d-m-Y') }}
                                        </h5>
                                        <p class="mb-0 font-13 text-white-50">Date de creation</p>
                                    </li>
                                    <li class="list-inline-item">
                                        <h5 class="mb-1 text-white">{{ $client->status }}</h5>
                                        <p class="mb-0 font-13 text-white-50">Status</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col text-end">
                            {!! $client->flagged ? '<h1><i class="uil-tag-alt text-danger"></i></h1>' : '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 col-xxl-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title bg-light p-2 mt-0 mb-3"> <i class="uil-user me-2"></i> Informations du
                        client</h4>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">SIP</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->sip }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Login internet</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->client_id }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Nom du client</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->name }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Adresse</label>
                        <div class="col-7">
                            <p>{{ $client->address }}</p>
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Numéro de téléphone</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->returnPhoneNumber() }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Ville</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->city->name }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Type</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->type }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Equipement</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->routeur_type }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Débit</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->debit != '-' ? $client->debit . ' Méga' : '-' }} ">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Sous Type Opportunité </label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->offre }}">
                        </div>
                    </div>
                    @unlessrole('sales')
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Status du client</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->status }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Date de création</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->created_at->format('d-m-Y H:i:s') }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Rapport telecharger</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->updated_at->format('d-m-Y H:i:s') }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Date de la dernière mise à
                            jour</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->updated_at->format('d-m-Y H:i:s') }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Créé par</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->createdBy === null ? 'Auto' : $client->createdBy->getFullname() }}">
                        </div>
                    </div>
                    @endunlessrole
                    @if ($client->status == 'Affecté')
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Type d'affectation</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->type_affectation }}">
                        </div>
                    </div>
                    @endif
                    @if ($client->affectations->last() != null)
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Affecter par</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->affectations->last()->affectedBy ? $client->affectations->last()->affectedBy->getFullname() : '-' }}">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 col-xxl-5">
            <div class="card">

                <div class="card-body">
                    @role('admin|superviseur')

                    <h4 class="header-title bg-light p-2 mt-0 mb-1"> <i class="uil-chart me-2"></i> Historique des
                        affectations</h4>
                    <div class="timeline-alt">
                        @forelse ($affe as $value)
                        @foreach ($value->history as $item)
                        <div class="timeline-item">
                            <i
                                class="bg-{{ $item->getStatusColor() }}-lighten text-{{ $item->getStatusColor() }} ri-bookmark-fill timeline-icon"></i>
                            <div class="timeline-item-info">
                                <h5 class="mt-0 mb-1">{{ $item->status }}
                                    <small>
                                        {{ $item->status == 'Planifié' ? '(' . $item->cause . ')' : ($item->status ==
                                        'Bloqué' ? '(' . $item->cause . ')' : '') }}
                                    </small>
                                </h5>
                                {{-- <p class="font-14"><i class="uil-user"></i>
                                    {{ $item->technicien->id == 97
                                    ? 'Contrôle Qualité'
                                    : ' Technicien :
                                    ' . $item->technicien->user->getFullname() }}
                                    <span class="ms-2 font-12">
                                        <i class="uil-clock"></i>
                                        {{ $item->created_at->format('d-m-Y H:i:s') }}
                                    </span>
                                </p> --}}
                                <p class="font-14"><i class="uil-user"></i>
                                    @if ($item->soustraitant)
                                        Sous-traitant : {{ $item->soustraitant->name }}
                                        <span class="ms-2 font-12">
                                            <i class="uil-clock"></i>
                                            {{ $item->created_at->format('d-m-Y H:i:s') }}
                                        </span><br>
                                    @endif
                                
                                    @if ($item->technicien && $item->technicien->id == 97)
                                        Contrôle Qualité
                                        <span class="ms-2 font-12">
                                            <i class="uil-clock"></i>
                                            {{ $item->created_at->format('d-m-Y H:i:s') }}
                                        </span>
                                    @elseif ($item->technicien)
                                        Technicien : 
                                        <span class="affecter-name" style="font-weight: bold; color: #2c3e50;">
                                            Affecter à {{ $item->technicien->user->getFullname() }}
                                        </span>
                                        <span class="ms-2 font-12">
                                            <i class="uil-clock"></i>
                                            {{ $item->created_at->format('d-m-Y H:i:s') }}
                                        </span>
                                    @endif
                                </p>
                                
                                
                                
                                
                                
                            </div>
                        </div>
                        @endforeach
                        @empty
                        <div class="text-center">
                            <h1><i class="uil-times-circle"></i></h1>
                            <h4>Il n'y a pas encore d'affectations.</h4>
                        </div>
                        @endforelse
                    </div>
                    <h4 class="header-title bg-light p-2 mt-2 mb-3"> <i class="uil-file me-2"></i> Rapports</h4>
                    @if ($client->declarations->count() != 0)
                    <div class="card mb-2 shadow-none border">
                        <div class="p-1">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-danger rounded">
                                            .PDF
                                        </span>
                                    </div>
                                </div>
                                <div class="col ps-0">
                                    <a href="#" class="text-muted fw-bold">Rapport de declaration</a>
                                    <p class="mb-0 font-12 fw-bold">
                                        {{ $client->declarations->last()->created_at }}</p>
                                </div>
                                <div class="col-auto" id="tooltip-container9">
                                    @role('admin')
                                    <a href="{{ route('admin.client.report', $client) }}" target='_blank'
                                        class="btn btn-primary btn-sm shadow-none">
                                        <i class="ri-eye-2-line"></i>
                                    </a>
                                    @endrole
                                    @role('supervisor')
                                    <a href="{{ route('supervisor.client.report', $client) }}" target='_blank'
                                        class="btn btn-primary btn-sm shadow-none">
                                        <i class="ri-eye-2-line"></i>
                                    </a>
                                    @endrole
                                    @role('controller')
                                    <a href="{{ route('controller.client.report', $client) }}" target='_blank'
                                        class="btn btn-primary btn-sm shadow-none">
                                        <i class="ri-eye-2-line"></i>
                                    </a>
                                    @endrole
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($client->blocages->count() != 0)
                    @foreach ($client->blocages as $item)
                    <div class="card mb-2 shadow-none border">
                        <div class="p-1">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-danger rounded">
                                            .PDF
                                        </span>
                                    </div>
                                </div>
                                <div class="col ps-0">
                                    <a href="#" class="text-muted fw-bold">Rapport de blocage
                                        <small>({{ $item->cause }})</small> </a>
                                    <p class="mb-0 font-12 fw-bold">
                                        {{ $item->created_at }}
                                    </p>
                                </div>
                                <div class="col-auto" id="tooltip-container9">
                                    @role('admin')
                                    <a href="{{ route('admin.client.blocage.report', $item) }}" target='_blank'
                                        class="btn btn-primary btn-sm shadow-none">
                                        <i class="ri-eye-2-line"></i>
                                    </a>
                                    @endrole
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @if ($client->blocages->count() == 0 && $client->declarations->count() == 0)
                    <div class="text-center">
                        <h1><i class="uil-file-question-alt"></i></h1>
                        <h4>Aucun rapport trouvé pour le moment.</h4>
                    </div>
                    @endif
                    @if ($client->flagged && $client->feedback)
                    <h4 class="header-title bg-light p-2 mt-4 mb-3"> <i class="uil-map me-2"></i> Feedback de
                        Contrôle
                        Qualité </h4>
                    <div class="mb-2">
                        <p>{{ $client->feedback->note }}</p>
                    </div>
                    @endif
                    @endrole
                    <h4 class="header-title bg-light p-2 mt-4 mb-3"> <i class="uil-map me-2"></i> Map</h4>
                    <div id="map" style="height:350px !important"></div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>
    <script>
        let map, markers = [];
            /* ----------------------------- Initialize Map ----------------------------- */
            function initMap() {
                map = L.map('map', {
                    center: {
                        lat: {{ $client->lat }},
                        lng: {{ $client->lng }},
                    },
                    zoom: 14
                });

                var redIcon = L.icon({
                    iconUrl: '../../assets/images/red-icon.png',
                    iconSize: [30, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41],
                    shadowAnchor: [12, 41]
                });

                var blueIcon = L.icon({
                    iconUrl: '../../assets/images/blue-icon.png',
                    iconSize: [30, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41],
                    shadowAnchor: [12, 41]
                });

                var greenIcon = L.icon({
                    iconUrl: '../../assets/images/green-icon.png',
                    iconSize: [30, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41],
                    shadowAnchor: [12, 41]
                });


                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© Neweraconnect'
                }).addTo(map);

                if ({{ $client->lat }} != null) {
                    L.marker([{{ $client->lat }}, {{ $client->lng }}], {
                        icon: greenIcon
                    }).setIcon(greenIcon).addTo(map);
                }

                @if ($client->blocages->count() != 0 && $client->blocages[0]->lat != null)
                    L.marker([{{ $client->blocages[0]->lat }}, {{ $client->blocages[0]->lng }}], {
                        icon: redIcon
                    }).setIcon(redIcon).addTo(map);
                @endif

                @if ($client->declarations->count() != 0 && $client->declarations[0]->lat != null)
                    L.marker([{{ $client->declarations[0]->lat }}, {{ $client->declarations[0]->lng }}], {
                        icon: blueIcon
                    }).setIcon(blueIcon).addTo(map);
                @endif
            }
            initMap();
    </script>
    @endpush
</div>