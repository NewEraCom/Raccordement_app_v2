<div class="container-fluid">

    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3 mb-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients">Clients</h5>
                    <h3 class="mt-3 mb-1">{{ $affectations }} <small>(Aujourd'hui : {{ $daily_affectations }})</small></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3 mb-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-check-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Terminé Aujourd'hui">Client Terminé Aujourd'hui</h5>
                    <h3 class="mt-3 mb-1">{{ $clients_done }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3 mb-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-clock widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="RDV">RDV</h5>
                    <h3 class="mt-3 mb-1">7</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3 mb-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Blocages">Blocages</h5>
                    <h3 class="mt-3 mb-1">2</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex flex-wrap">
                    <h5 class="text-muted fw-bold d-none d-lg-inline">Filtrage</h5>
                    <div class="ms-auto">
                        <button class="btn btn-success btn-sm shadow-none mb-1" data-bs-toggle="modal"
                            data-bs-target="#exportation-modal">
                            <i class="uil-export me-2"></i> Exporter
                        </button>
                        <button class="btn btn-secondary btn-sm shadow-none mb-1" data-bs-toggle="modal"
                            data-bs-target="#affecter-modal">
                            <i class="uil-label me-2"></i> Affecter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Nom, Ville, Téléphone, SIP Ou Code Plaque" wire:model="search_term" />
                                <label for="floatingInput">Rechercher par nom, ville, téléphone, SIP ou code plaque</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="client_status">
                                    <option value="" selected>Tous</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Planifié">Planifié</option>
                                    <option value="Bloqué">Bloqué</option>
                                    <option value="Terminé">Terminé</option>
                                    <option value="Affecté">Affecté</option>
                                </select>
                                <label for="floatingSelect">Statut de client</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="technicien">
                                    <option value="" selected>-</option>
                                    @foreach ($techniciens as $item)
                                    <option value="{{ $item->id }}">{{ $item->user->getFullname() }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Technicien</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="end_date" />
                                <label for="floatingInput">Au</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-centered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">Sip</th>
                            <th>Adresse</th>
                            <th>Nom du client</th>
                            <th>Technicien</th>
                            <th class="text-center">Date de dernière mise à jour</th>
                            <th class="text-center">Etat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $affectation)
                        <tr class="align-middle">
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input" value="{{ $affectation->id }}"
                                    wire:model="selectedItems">
                            </td>
                            <td class="text-center">{{ $affectation->client->sip }}</td>
                            <td>
                                <h5 class="font-14 my-1">{{ Str::limit($affectation->client->address, 30) }}</h5>
                                <span class="text-muted font-13">{{ $affectation->client->city->name }}</span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1">{{ $affectation->client->name }}</h5>
                                <span class="text-muted font-13">{{ $affectation->client->returnPhoneNumber() }}</span>
                            </td>
                            <td>
                                {!! 
                                    $affectation->technicien ? 
                                    $affectation->technicien->user->getFullname() . 
                                    ' <small>(' . 
                                    ($affectation->technicien->soustraitant ? $affectation->technicien->soustraitant->name : 'N/A') . 
                                    ')</small>' 
                                    : '-'
                                !!}
                            </td>
                            <td class="text-center fw-bold">
                                {{ \Carbon\Carbon::parse($affectation->updated_at)->format('d-m-Y H:i') }}
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge badge-{{ $affectation->getStatusColor() }}-lighten p-1 ps-2 pe-2">{{
                                    $affectation->status }}</span>
                                <br>
                                @if ($affectation->status == 'Bloqué')
                                <span class="badge badge-danger-lighten p-1 ps-2 pe-2 mt-1">{{
                                    $affectation->blocages->last()->cause ?? '-' }}</span>
                                @endif
                                @if ($affectation->status == 'Planifié')
                                <span class="badge badge-warning-lighten p-1 ps-2 pe-2 mt-1">{{
                                    $affectation->planification_date ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($affectation->client)
                                    <button type="button" class="btn btn-primary btn-sm shadow-none"
                                            wire:click="setClient({{ $affectation->client->id }})" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#detail-modal">
                                        <i class="uil-eye"></i>
                                    </button>
                                @else
                                    <span>No client data</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucun affectation trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-2 ps-4">
                {{ $clients->links() }}
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


    <div id="detail-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detail-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="detail-modalLabel">Détails du client</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($client)
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Informations générales</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Id client</label>
                                                    <p class="fw-bold">{{ $client->client_id }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Nom du client</label>
                                                    <p class="fw-bold">{{ $client->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Coordonnées</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Numéro de téléphone</label>
                                                    <p class="fw-bold">{{ $client->phone_no }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">SIP</label>
                                                    <p class="fw-bold">{{ $client->sip }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Détails techniques</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Type de routeur</label>
                                                    <p class="fw-bold">{{ $client->routeur_type }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Type d'installation</label>
                                                    <p class="fw-bold">{{ $client->offre }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Localisation</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Position GPS</label>
                                                    @if($client->lat && $client->lng)
                                                        <p class="fw-bold">
                                                            <a href="https://www.google.com/maps/search/{{ $client->lat }}+{{ $client->lng }}" 
                                                               target="_blank" 
                                                               class="text-primary">
                                                                <i class="uil-map-pin-alt me-2"></i>
                                                                {{ number_format($client->lat, 6) }} , {{ number_format($client->lng, 6) }}
                                                            </a>
                                                        </p>
                                                    @else
                                                        <p class="fw-bold">Aucune position GPS</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Adresse de client</label>
                                                    <p class="fw-bold">{{ $client->address }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center">Aucun client trouvé.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>


      <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
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
                                            {{ $item->user->getFullname()}}
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
    </div>
</div>