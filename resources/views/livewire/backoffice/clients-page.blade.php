

<div class="container-fluid">   

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                @role('admin')
                <div class="page-title-right">
                    <button class="btn btn-success btn-sm shadow-none mb-1" data-bs-toggle="modal"
                        data-bs-target="#exportation-modal"> <i class="uil-export me-2"></i> Exproter
                    </button>
                    <button class="btn btn-info btn-sm shadow-none mb-1" data-bs-toggle="modal"
                        data-bs-target="#importation-modal"> <i class="uil-down-arrow me-2"></i> Importer
                    </button>
                    <button class="btn btn-warning btn-sm shadow-none mb-1" wire:click="importAuto">
                        <span wire:target="importAuto" wire:loading.remove>
                            <i class="uil-down-arrow me-2"></i> Importer
                            automatique
                        </span>
                        <span wire:target="importAuto" wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Chargement
                        </span>
                    </button>
                    <button class="btn btn-danger btn-sm shadow-none mb-1" data-bs-target="#pipe"
                        data-bs-toggle="modal"> <i class="uil-archive me-2"></i> Import
                        PIPE</button>
                </div>
                @endrole
                <h4 class="page-title">Clients</h4>
            </div>
        </div>
    </div>

    @role('admin')
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-envelope-add widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients du jour">Clients du jour</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientsOfTheDay'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Clients">Total Clients</h5>
                    <h3 class="mt-3 mb-1">{{ $data['allClients'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients B2B">Clients B2B</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientsB2B'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients B2C">Clients B2C</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientsB2C'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-envelope-add widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Saisie">Clients Saisie</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientsSaisie'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Affecté">Clients Affecté</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientAffecte'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-6 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Déclaré">Clients Déclaré</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientDeclare'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-6 col-xxl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Validé">Clients Validé</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientValide'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('supervisor')
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Récu">Client Récu</h5>
                    <h3 class="mt-3 mb-1">{{ $clientsCount->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-check-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Réalise">Client Réalise</h5>
                    <h3 class="mt-3 mb-1">{{ $clientsCount->whereIn('status', ['Validé', 'Déclaré'])->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-chart-line widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Taux du chut">Taux du chut</h5>
                    <h3 class="mt-3 mb-1">{{ $clientsCount->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-clock widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Taux du chut">RDV</h5>
                    <h3 class="mt-3 mb-1">{{ $problem['affectationsPlanned'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Taux du chut">Problème technique</h5>
                    <h3 class="mt-3 mb-1">{{ $problem['problemTechnique'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Taux du chut">Problème client</h5>
                    <h3 class="mt-3 mb-1">{{ $problem['problemClient'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    @endrole


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold d-none d-sm-none d-md-none d-lg-none d-xl-inline d-xxl-inline">
                        Filtrage</h5>
                    <div class="ms-auto">
                        <div class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline d-xxl-inline">
                            @role('admin')
                            <button class="btn btn-primary btn-sm shadow-none mb-1" data-bs-toggle="modal"
                                data-bs-target="#add-modal">
                                <i class="uil-plus me-2"></i> Ajouter un client
                            </button>
                            <button class="btn btn-warning btn-sm shadow-none mb-1" data-bs-toggle="modal"
                                data-bs-target="#deblocage"> <i class="uil-refresh me-2"></i> Déblocage
                            </button>
                            <button class="btn btn-danger btn-sm shadow-none mb-1" data-bs-toggle="modal"
                                data-bs-target="#delete-all-modal"> <i class="uil-trash me-2"></i> Supprimer
                            </button>
                            <button class="btn btn-secondary btn-sm shadow-none mb-1" data-bs-toggle="modal"
                                data-bs-target="#affecter-modal"> <i class="uil-label me-2"></i> Affecter
                            </button>
                            @endrole
                            @role('supervisor')
                            <button class="btn btn-success btn-sm shadow-none mb-1" data-bs-toggle="modal"
                                data-bs-target="#exportation-modal"> <i class="uil-export me-2"></i> Exproter
                            </button>
                            @endrole
                        </div>
                        @role('admin')
                        <div class="btn-group dropdown d-inline d-sm-inline d-md-inline d-lg-none d-xl-none d-xxl-none">
                            <a href="#"
                                class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-xs shadow-none"
                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                    class="mdi mdi-dots-horizontal"></i></a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add-modal">
                                    <i class="uil-plus me-2"></i> Ajouter un client
                                </button>
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#exportation-modal"> <i class="uil-export me-2"></i> Exproter
                                </button>
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#importation-modal"> <i class="uil-down-arrow me-2"></i> Importer
                                </button>
                                <button class="dropdown-item" wire:click="importAuto">
                                    <span wire:target="importAuto" wire:loading.remove>
                                        <i class="uil-down-arrow me-2"></i> Importer
                                        automatique
                                    </span>
                                    <span wire:target="importAuto" wire:loading>
                                        <span class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span> Chargement
                                    </span>
                                </button>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete-all-modal">
                                    <i class="uil-trash me-2"></i> Supprimer
                                </button>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#affecter-modal">
                                    <i class="uil-label me-2"></i> Affecter
                                </button>
                            </div>
                        </div>
                        @endrole
                    </div>
                </div>
                <div class="card-body">
                    @role('admin')
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-4 mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Nom, Ville, Téléphone, SIP Ou Code Plaque " wire:model="search_term" />
                                <label for="floatingInput">Rechercher par nom, ville, téléphone, SIP ou code plaque</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="client_status">
                                    <option value="" selected>Tous</option>
                                    <option value="Saisie">Saisie</option>
                                    <option value="Affecté">Affecté</option>
                                    <option value="Déclaré">Déclaré</option>
                                    <option value="Validé">Validé</option>
                                    <option value="Bloqué">Bloqué</option>
                                </select>
                                <label for="floatingSelect">Statut du client</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="technicien">
                                    <option value="" selected>-</option>
                                    @foreach ($techniciens as $item)
                                    <option value="{{ $item->id }}">{{ $item->user->getFullname() }}
                                        <small>({{ $item->soustraitant->name }})</small>
                                    </option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Technicien</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="end_date" />
                                <label for="floatingInput">Au</label>
                            </div>
                        </div>
                    </div>
                    @endrole
                    @role('supervisor')
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-4 mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Ville, Téléphone,SIP, " wire:model="search" />
                                <label for="floatingInput">Ville ou Téléphone ou SIP</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-4 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="client_status">
                                    <option value="" selected>Tous</option>
                                    <option value="Saisie">Saisie</option>
                                    <option value="Affecté">Affecté</option>
                                    <option value="Déclaré">Déclaré</option>
                                    <option value="Validé">Validé</option>
                                    
                                </select>
                                <label for="floatingSelect">Statut du client</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="end_date" />
                                <label for="floatingInput">Au</label>
                            </div>
                        </div>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        @role('admin')
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered table-nowrap mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">Sip</th>
                            <th>Adresse</th>
                            <th>Client</th>
                            <th class="text-center">Technicien</th>
                            <th class="text-center">Sous-traitant</th>
                            <th class="text-center">Status de client</th>
                            <th class="text-center">Status d'affectation</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input" value="{{ $client->id }}"
                                    wire:model="selectedItems">
                            </td>
                            <td class="text-center">{{ $client->sip }}</td>
                            <td>
                                <h5 class="font-14 my-1">{{ Str::limit($client->address, 20) }}</h5>
                                <span class="text-muted font-13">{{ $client->city->name ?? '-' }}</span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1">{{ $client->name }}</h5>
                                <span class="text-muted font-13">{{ $client->returnPhoneNumber() }} <small
                                        class="badge bg-info">{{ $client->offre }}</small> </span>
                            </td>

                            <td class="text-center">
                                @if ($client->flagged && $client->technicien_id == 97)
                                {!! '<h4> <i class="uil-tag-alt text-danger"></i> </h4>' !!}
                                @else
                                {!! $client->technicien
                                ? $client->technicien->user->getFullname() . ' <small>(' .
                                    $client->technicien->soustraitant->name . ')</small>'
                                : '-' !!}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($client->affectations->isNotEmpty() && $client->affectations->first()->soustraitant)
                                    {!! $client->affectations->first()->soustraitant->name !!}
                                @else
                                    -
                                @endif
                            </td>
                            
                            <td class="text-center">
                                <span class="badge badge-{{ $client->getStatusColor() }}-lighten p-1 ps-2 pe-2">{{
                                    $client->status }}</span>
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge badge-{{ $client->affectations->count() > 0 ? $client->affectations->first()->getStatusColor() : '-' }}-lighten p-1 ps-2 pe-2">
                                    {{ $client->affectations->count() > 0 ? $client->affectations->first()->status : '-'
                                    }}
                                </span>
                                <br>
                                @if ($client->affectations->count() > 0)
                                @if ($client->affectations->last()->status == 'Bloqué')
                                <span class="badge badge-danger-lighten p-1 ps-2 pe-2 mt-1">{{
                                    $client->affectations->last()->blocages->last()->cause ?? '-' }}</span>
                                @endif
                                @if ($client->affectations->last()->status == 'Planifié')
                                <span class="badge badge-warning-lighten p-1 ps-2 pe-2 mt-1">{{
                                    $client->affectations->last()->planification_date ?? '-' }}</span>
                                @endif
                                @endif
                            </td>
                            <td class="text-end">
                                <a class="btn btn-primary btn-sm shadow-none" target="_blank"
                                    href="{{ route('admin.clients.profile', [$client->id]) }}"><i class="uil-eye"></i>
                                </a>

                                
                          


                            @if ($latestAffectation = $client->affectations()->latest()->first())
                            @if ($latestAffectation->status == 'Bloqué')
                                <button class="btn btn-sm btn-success shadow-none"
                                    wire:click="$set('affectation_id', {{ $latestAffectation->id }})"
                                    data-bs-toggle="modal" data-bs-target="#deblocage-modal">
                                    <i class="uil-user-check" alt="résolue le blocage"></i>
                                </button>
                            @endif
                        @endif
                                @if ($client->relance())
                                <button class="btn btn-sm btn-dark shadow-none"
                                    wire:click="$set('client_id',{{ $client->id }})" data-bs-toggle="modal"
                                    data-bs-target="#relance-modal">
                                    <i class="uil-refresh"></i>
                                </button>
                                @endif
                                <button type="button" class="btn btn-warning btn-sm shadow-none"
                                    wire:click="setClient({{ $client->id }})" data-bs-toggle="modal"
                                    data-bs-target="#edit-modal"><i class="uil-pen"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm shadow-none"
                                    wire:click="$set('client_id',{{ $client->id }})" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal"><i class="uil-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <h5>Aucun client trouvé</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $clients->links() }}
            </div>
        </div>
        @endrole
        @role('supervisor')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-centered table-nowrap mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Sip</th>
                            <th>Adresse</th>
                            <th>Client</th>
                            <th>Numéro de téléphone</th>
                            @if (Auth::user()->email != 'b.elboudri@neweracom.ma')
                            <th class="text-center">Technicien</th>
                            @endif
                            <th class="text-center">Statut de client</th>
                            <th class="text-center">Statut d'affectation</th>
                            <th class="text-center">Créé à</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                        <tr>
                            <td class="text-center">{{ $client->sip }}</td>
                            <td>
                                <h5 class="font-14 my-1">{{ Str::limit($client->address, 30) }}</h5>
                                <span class="text-muted font-13">{{ $client->city->name }}</span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1">{{ $client->name }}</h5>
                                <span class="text-muted font-13">{{ $client->offre }}</span>
                            </td>

                            <td>{{ $client->returnPhoneNumber() }}</td>
                            @if (Auth::user()->email != 'b.elboudri@neweracom.ma')
                            <td>{{ $client->technicien ? $client->technicien->user->getFullname() : '-' }}</td>
                            @endif
                            <td class="text-center">
                                <span class="badge badge-{{ $client->getStatusColor() }}-lighten p-1 ps-2 pe-2">{{
                                    $client->status }}</span>
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge badge-{{ $client->affectations->count() > 0 ? $client->affectations->first()->getStatusColor() : '-' }}-lighten p-1 ps-2 pe-2">
                                    {{ $client->affectations->count() > 0 ? $client->affectations->first()->status : '-'
                                    }}
                                </span>
                                <br>
                                @if ($client->affectations->count() > 0)
                                @if ($client->affectations->first()->status == 'Bloqué')
                                <span class="badge badge-danger-lighten p-1 ps-2 pe-2 mt-1">{{
                                    $client->affectations->first()->blocages->first()->cause ?? '-' }}</span>
                                @endif
                                @if ($client->affectations->first()->status == 'Planifié')
                                <span class="badge badge-warning-lighten p-1 ps-2 pe-2 mt-1">{{
                                    $client->affectations->first()->planification_date ?? '-' }}</span>
                                @endif
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $client->created_at->format('d-m-Y H:i') }}
                            </td>
                            <td class="text-end">
                                <a class="btn btn-primary btn-sm shadow-none"
                                    href="{{ route('supervisor.clients.profile', [$client->id]) }}"><i
                                        class="uil-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <h4 class="my-4">Aucun client trouvé</h4>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $clients->links() }}
            </div>
        </div>
        @endrole
    </div>

   
    <div class="modal fade" id="deblocage-modal" tabindex="-1" role="dialog"
    aria-labelledby="deblocage-modalLabel" aria-hidden="true"  wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form wire:submit.prevent="debloque">
                <div class="modal-header">
                    <h4 class="modal-title" id="deblocage-modalLabel">Résolu le blocage</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-bold f-16">Es-tu sûr que ce problème a été résolu ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-danger shadow-none">
                        <span wire:loading.remove wire:target="debloque">Oui</span>
                        <span wire:loading wire:target="debloque">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Chargement...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    <div id="importation-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="importManual">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Importer liste des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="example-fileinput" class="form-label"></label>
                            <input type="file" id="example-fileinput" class="form-control" wire:model="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none" {{ $file==null ? 'disabled' : '' }}>
                            <span wire:target="file" wire:loading.remove>
                                <span wire:loading.remove wire:target="importManual">Import</span>
                                <span wire:loading wire:target="importManual">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"
                                        aria-hidden="true">
                                    </span>
                                    Chargement...
                                </span>
                            </span>
                            <span wire:loading wire:target="file">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true">
                                </span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="exportation-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exportation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="export">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exportation-modalLabel">Exporter liste des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir exporter un liste des clients vers un fichier
                            Excel ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="export">Oui, exporter</span>
                            <span wire:loading wire:target="export">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="delete">
                    <div class="modal-header">
                        <h4 class="modal-title" id="delete-modalLabel">Supprimer un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer ce client ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger shadow-none">
                            <span wire:loading.remove wire:target="delete">Oui, supprimez-le</span>
                            <span wire:loading wire:target="delete">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="delete-all-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete-all-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="deleteAll">
                    <div class="modal-header">
                        <h4 class="modal-title" id="delete-all-modalLabel">Supprimer des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer les clients ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger shadow-none">
                            <span wire:loading.remove wire:target="deleteAll">Oui, supprimez-le</span>
                            <span wire:loading wire:target="deleteAll">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="edit">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-modalLabel">Modifier un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" wire:model="e_address" />
                                    <label for="floatingInput">Adresse de client</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" wire:model="e_name" />
                                    <label for="floatingInput">Nom du client</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" min="10"
                                            wire:model="e_sip" />
                                        <label for="floatingInput">Login SIP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" min="10"
                                            wire:model="e_id" />
                                        <label for="floatingInput">Login Internet</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" min="10" class="form-control" id="floatingInput"
                                        wire:model.lazy="e_phone" />
                                    <label for="floatingInput">Téléphone</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="e_type" required>
                                        <option value="" selected>Choisissez un type</option>
                                        <option value="B2B">B2B</option>
                                        <option value="B2C">B2C</option>
                                    </select>
                                    <label for="floatingSelect">Type de client</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="e_offre" required>
                                        <option value="" selected>Choisissez un type</option>
                                        <option value="Nouvelle offre">Nouvelle offre</option>
                                        <option value="Déménagement">Déménagement</option>
                                    </select>
                                    <label for="floatingSelect">Type d'offre</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="e_debit" required>
                                        <option value="" selected disabled>Choisissez un débit</option>
                                        <option value="-"></option>
                                        <option value="20">20 Méga</option>
                                        <option value="50">50 Méga</option>
                                        <option value="100">100 Méga</option>
                                        <option value="200">200 Méga</option>
                                    </select>
                                    <label for="floatingSelect">Débit</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="e_routeur"
                                        required>
                                        <option value="" selected disabled>Choisissez un équipement</option>
                                        <option value="-"></option>
                                        <option value="ZTE F660">ZTE F660</option>
                                        <option value="ZTE F680">ZTE F680</option>
                                        <option value="ZTE F6600">ZTE F6600</option>
                                    </select>
                                    <label for="floatingSelect">Equipement</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="edit">Modifier</span>
                            <span wire:loading wire:target="edit">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- the previous one created bu chahid  --}}
    {{-- <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="affectation">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Affectation des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @error('technicien_affectation')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                        @error('selectedItems')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                                wire:model="technicien_affectation">
                                <option selected>Sélectionnez un technicien</option>
                                @foreach ($techniciens as $item)
                                <option value="{{ $item->id }}">{{ $item->user->getFullname() }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Technicien </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="affectation">Affecter</span>
                            <span wire:loading wire:target="affectation">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}



{{-- the right one  --}}

    {{-- <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="affectation">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Affectation des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @error('technicien_affectation')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
    
                        @error('selectedItems')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
    
                        <!-- Display selected technician or search for one -->
                        @if ($technicien_affectation) <!-- Check if a technician is selected -->
                            <div class="alert alert-info" role="alert">
                                <strong>Technicien sélectionné:</strong> {{ $selectedTechnicianName }}
                            </div>
                        @else
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="technicianSearch" placeholder="Rechercher un technicien" wire:model="searchTerm">
                                <label for="technicianSearch">Rechercher un technicien</label>
                            </div>
    
                            <ul class="list-group">
                                @foreach ($techniciens ?? [] as $item)
                                    @if (str_contains(strtolower($item->user->getFullname()), strtolower($searchTerm)) ||
                                         str_contains(strtolower($item->soustraitant->name), strtolower($searchTerm)))
                                        <li class="list-group-item d-flex justify-content-between align-items-center" 
                                            wire:click="selectTechnician({{ $item->id }})" 
                                            style="cursor: pointer;">
                                            {{ $item->user->getFullname() . ' (' . $item->soustraitant->name . ')' }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
    
                            <!-- Display no results message only if the search term is not empty -->
                            @if ($searchTerm && !count($techniciens))
                                <div class="alert alert-warning mt-2" role="alert">
                                    Aucun technicien trouvé correspondant à votre recherche.
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($technicien_affectation)
                            <button type="button" class="btn btn-secondary btn-sm" wire:click="resetTechnician">Changer</button>
                        @endif
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none" @if (!$technicien_affectation) disabled @endif>
                            <span wire:loading.remove wire:target="affectation">Affecter</span>
                            <span wire:loading wire:target="affectation">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    
    

    <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="affecter-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="affectation">
                    <div class="modal-header">
                        <h4 class="modal-title" id="affecter-modalLabel">Affectation des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Display validation errors -->
                        @error('soustraitant_affectation')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
    
                        @error('selectedItems')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
    
                        <!-- Display selected subcontractor or search for one -->
                        @if ($soustraitant_affectation) <!-- Check if a subcontractor is selected -->
                            <div class="alert alert-info" role="alert">
                                <strong>Soustraitant sélectionné:</strong> {{ $selectedSoustraitantName }}
                            </div>
                        @else
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="soustraitantSearch" placeholder="Rechercher un soustraitant" wire:model="searchTerm">
                                <label for="soustraitantSearch">Rechercher un soustraitant</label>
                            </div>
    
                            <ul class="list-group">
                                @foreach  ($soustraitants ?? [] as $item)
                                    @if (str_contains(strtolower($item->name), strtolower($searchTerm)))
                                        <li class="list-group-item d-flex justify-content-between align-items-center"
                                            wire:click="selectSoustraitant({{ $item->id }})"
                                            style="cursor: pointer;">
                                            {{ $item->name }}
                                        </li>
                                    @endif
                                @endforeach
                            
                            </ul>
                




                            <!-- Display no results message only if the search term is not empty -->
                            @if ($searchTerm && !count($soustraitants))
                                <div class="alert alert-warning mt-2" role="alert">
                                    Aucun soustraitant trouvé correspondant à votre recherche.
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($soustraitant_affectation)
                            <button type="button" class="btn btn-secondary btn-sm" wire:click="resetSoustraitant">Changer</button>
                        @endif
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none" @if (!$soustraitant_affectation) disabled @endif>
                            <span wire:loading.remove wire:target="affectation">Affecter</span>
                            <span wire:loading wire:target="affectation">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    



    
    <div id="relance-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="relance">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Rejouer le client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" wire:model.lazy="cause" />
                            <label for="floatingInput">Cause de rejouer le client</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="relance">Rejouer-le</span>
                            <span wire:loading wire:target="relance">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div id="deblocage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deblocage-modalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form wire:submit.prevent="rejouerBlocage">
                <div class="modal-header">
                    <h4 class="modal-title" id="importation-modalLabel">Rejouer les blocages</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" wire:model="causeDeblocage">
                            <option selected value="-">Sélectionnez blocage</option>
                            @foreach ($blocages as $item)
                            <option value="{{ $item->cause }}">{{ $item->cause }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Cause de blocage</label>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="deblocage_start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="deblocage_end_date" />
                                <label for="floatingInput">Au</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary shadow-none">
                        <span wire:loading.remove wire:target="rejouerBlocage">Rejouer</span>
                        <span wire:loading wire:target="rejouerBlocage">
                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                aria-hidden="true"></span>
                            Chargement...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="add">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-modalLabel">Ajouter un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" wire:model.lazy="new_address" />
                            <label for="floatingInput">Adresse de client</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" wire:model.lazy="new_name" />
                            <label for="floatingInput">Nom de client</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        wire:model.lazy="new_sip" />
                                    <label for="floatingInput">Login SIP</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        wire:model.lazy="new_id" />
                                    <label for="floatingInput">Login Internet</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" min="10" class="form-control" id="floatingInput"
                                wire:model.lazy="new_phone" />
                            <label for="floatingInput">Téléphone</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" wire:model.lazy="new_type" required>
                                <option value="" selected>Choisissez un type</option>
                                <option>B2B</option>
                                <option>B2C</option>
                            </select>
                            <label for="floatingSelect">Type de client</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" wire:model.lazy="new_offre" required>
                                <option value="" selected>Choisissez un type</option>
                                <option>Nouvelle offre</option>
                                <option>Déménagement</option>
                            </select>
                            <label for="floatingSelect">Type d'offre</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="new_debit"
                                        required>
                                        <option value="" selected disabled>Choisissez un débit</option>
                                        <option value="-"></option>
                                        <option value="20">20 Méga</option>
                                        <option value="50">50 Méga</option>
                                        <option value="100">100 Méga</option>
                                        <option value="200">200 Méga</option>
                                    </select>
                                    <label for="floatingSelect">Débit</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="new_routeur"
                                        required>
                                        <option value="" selected disabled>Choisissez un equipement</option>
                                        <option value="-"></option>
                                        <option>ZTE F660</option>
                                        <option>ZTE F680</option>
                                        <option>ZTE F6600</option>
                                    </select>
                                    <label for="floatingSelect">Equipement</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="add">Ajouter</span>
                            <span wire:loading wire:target="add">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="pipe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pipe-modalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="pipe">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Importer pipe</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="example-fileinput" class="form-label">Veuillez utiliser le modèle ci-dessous</label>
                            <input type="file" id="example-fileinput" class="form-control" wire:model="file" required>
                        </div>
                        <a href="{{ asset('PIPE_TEMPLATE.xlsx') }}" class="m-0"> <i class="uil-file me-1 font-18"></i>Télécharger le modèle</a>
                        <br>
                        <small class="text-danger"> <i class=" uil-info-circle"></i> Veuillez prendre en considération le changement du type d'offre Déménagement en DEM</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="pipe">Importer</span>
                            <span wire:loading wire:target="pipe">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   

</div>