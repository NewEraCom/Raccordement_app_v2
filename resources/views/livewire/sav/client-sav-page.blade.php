<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right d-flex justify-content-start align-items-center gap-1">
                    <button class="btn btn-success btn-sm shadow-none mb-1" wire:click="exportToCsv">
                        <span wire:target="exportToCsv" wire:loading.remove>
                            <i class="uil-up-arrow me-2"></i> Exporter
                        </span>
                        <span wire:target="exportToCsv" wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                aria-hidden="true"></span>
                            Chargement
                        </span>
                    </button>
                    <button class="btn btn-warning btn-sm shadow-none mb-1" wire:click="importAuto">
                        <span wire:target="importAuto" wire:loading.remove>
                            <i class="uil-down-arrow me-2"></i> Importer
                            automatique
                        </span>
                        <span wire:target="importAuto" wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                aria-hidden="true"></span>
                            Chargement
                        </span>
                    </button>
                    <button class="btn btn-primary btn-sm shadow-none mb-1 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add-modal">
                        <i class="uil-plus me-2"></i> Ajouter un client
                    </button>
                </div>
                <h4 class="page-title">Clients</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-envelope-add widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations du jour">Total Client</h5>
                    <h3 class="mt-3 mb-1">{{ $clientsCount }}</h3>
                </div>
            </div>
        </div>        
    </div>
   
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold d-none d-sm-none d-md-none d-lg-none d-xl-inline d-xxl-inline">
                        Filtrage</h5>
                    <div class="ms-auto">
                        <div class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline d-xxl-inline">
                         
                            <button class="btn btn-primary btn-sm shadow-none mb-1 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#affecter-modal">
                                <i class="uil-plus me-2"></i> Affecter
                            </button>
                        </div>
                        <div class="btn-group dropdown d-inline d-sm-inline d-md-inline d-lg-none d-xl-none d-xxl-none">
                            <a href="#" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-xs shadow-none"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add-modal">
                                    <i class="uil-plus me-2"></i> Ajouter un client
                                </button>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportation-modal">
                                    <i class="uil-export me-2"></i> Exporter
                                </button>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#importation-modal">
                                    <i class="uil-down-arrow me-2"></i> Importer
                                </button>
                                <button class="dropdown-item" wire:click="importAuto">
                                    <span wire:target="importAuto" wire:loading.remove>
                                        <i class="uil-down-arrow me-2"></i> Importer automatique
                                    </span>
                                    <span wire:target="importAuto" wire:loading>
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Chargement
                                    </span>
                                </button>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete-all-modal">
                                    <i class="uil-trash me-2"></i> Supprimer
                                </button>
                                <!-- Add the Affecter option here in the dropdown -->
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#affecter-modal">
                                    <i class="uil-label me-2"></i> Affecter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                    
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput"
                                        placeholder="Ex : Ville, Téléphone,SIP, " wire:model="search" />
                                        <label for="floatingInput">Rechercher par ID Case, Ville, Nom Client ou SIP</label>
                                </div>
                           
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="client_status">
                                    <option value="" selected>Tous</option>
                                    <option value="Down">Down</option>
                                    <option value="Affecté">Affecté</option>
                                    <option value="Connecté">Connecté</option>
                                    <option value="Saisie">Saisie</option>
                                </select>
                                <label for="floatingSelect">Status du client</label>
                            </div>
                        </div>
    
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-3 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-3 mb-1">
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
    

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered table-nowrap mb-0">
                    <thead class="table-dark">
                        <tr><th class="text-center"></th>
                            <th>ID Case</th>
                            <th class="text-center">SIP</th>
                            <th class="text-center">Access</th>
                            <th>Adresse</th>
                            <th>Client</th>
                            <th class="text-center">Telephone</th>
                            <th class="text-center">Date de creation</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr>        
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input" value="{{ $client->id }}"
                                        wire:model="selectedItems">
                                </td>                        
                                <td>{{ $client->n_case }}</td>
                                <td class="text-center">{{ $client->sip }}</td>
                                <td class="text-center">{{ $client->login }}</td>
                                <td>
                                    <h5 class="font-14 my-1">{{ Str::limit($client->address, 40) }}</h5>
                                    <span class="text-muted font-13">{{ $client->city->name ?? '-' }}</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1">{{ $client->client_name }}</h5>                                    
                                </td>
                                <td class="text-center">
                                    {{$client->contact}}
                                </td>    
                                <td class="text-center">
                                    {{$client->date_demande}}
                                </td>   
                                <td>
                                    @if ($client->status == 'Bloqué')
                                        <span class="badge bg-danger p-1">{{ $client->status }}</span>
                                    @elseif($client->status == 'Planifié')
                                        <span class="badge bg-warning p-1">{{ $client->status }}</span>
                                    @elseif($client->status == 'Saisie')
                                        <span class="badge bg-primary p-1">{{ $client->status }}</span>
                                    @elseif($client->status == 'En cours')
                                        <span class="badge bg-primary p-1">{{ $client->status }}</span>
                                    @elseif($client->status == 'Validé')
                                        <span class="badge bg-success p-1">{{ $client->status }}</span>
                                    @elseif($client->status == 'Affecté')
                                        <span class="badge bg-warning p-1">{{ $client->status }}</span>
                                    @endif

                                </td>
                                <td class="text-center"> 
                                    <div>
                                        <button class="btn btn-danger btn-sm shadow-none" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal"
                                        wire:click="$set('client_id',{{ $client->id }})"><i
                                            class="uil-trash"></i></button>
                                            <button type="button" class="btn btn-warning btn-sm shadow-none"
                                            wire:click="setClient({{ $client->id }})" data-bs-toggle="modal"
                                            data-bs-target="#edit-modal"><i class="uil-pen"></i>
                                        </button>
                                        <a class="btn btn-primary btn-sm shadow-none" target="_blank"

                                        href="{{ route('sav.clients.screen', $client) }}"><i
                                            class="uil-eye"></i>
                                    </a>
                                        
                                    </div>
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
                {{$clients->links()}}
            </div>
        </div>


    </div>


    <div id="importation-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="importManual">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Importer liste des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="example-fileinput" class="form-label"></label>
                            <input type="file" id="example-fileinput" class="form-control" wire:model="file"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none"
                            {{ $file == null ? 'disabled' : '' }}>
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

    <div id="exportation-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="exportation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="export">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exportation-modalLabel">Exporter liste des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir exporter un liste des clients vers un fichier
                            Excel ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
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
                <form wire:submit.prevent="deleteSavClient">
                    <div class="modal-header">
                        <h4 class="modal-title" id="delete-modalLabel">Supprimer un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer ce client ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger shadow-none">
                            <span wire:loading.remove wire:target="deleteSavClient">Oui, supprimez-le</span>
                            <span wire:loading wire:target="deleteSavClient">
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

    <div id="delete-all-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="delete-all-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="deleteAll">
                    <div class="modal-header">
                        <h4 class="modal-title" id="delete-all-modalLabel">Supprimer des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer les clients ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
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


    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded">
                <form wire:submit.prevent="edit">
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title" id="edit-modalLabel">Modifier un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="idCaseInput" wire:model.lazy="new_id_case" placeholder=" " required />
                                    <label for="idCaseInput">ID CASE</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="networkAccessInput" wire:model.lazy="new_network_access" placeholder=" " required />
                                    <label for="networkAccessInput">Accès réseau</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="lineNumberInput" wire:model.lazy="new_line_number" placeholder=" " required />
                                    <label for="lineNumberInput">N° de la ligne</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="fullNameInput" wire:model.lazy="new_full_name" placeholder=" " required />
                                    <label for="fullNameInput">Nom et prénom</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="contactNumberInput" wire:model.lazy="new_contact_number" placeholder="" required />
                                    <label for="contactNumberInput">N° de contact</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="serviceActivitiesInput" wire:model.lazy="new_service_activities" placeholder="" required />
                                    <label for="serviceActivitiesInput">Activités de service</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <div class="">
                                <label for="addressInput">Adresse</label>
                                <input type="text" class="form-control border-primary shadow-sm" id="addressInput" wire:model.lazy="new_address" placeholder="" required />
                                
                            </div>
                        </div>
    
                        <div class="">
                            <label for "commentInput">Commentaire</label>
                            <textarea class="form-control border-primary shadow-sm" id="commentInput" wire:model.lazy="new_comment" rows=3 placeholder=""></textarea>
                           
                        </div>
    
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none me-auto" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class='btn btn-info shadow-none'>
                            <span wire:loading.remove wire:target='edit'>Modifier</span>
                            <span wire:loading wire:target='edit'>
                                <span class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span> Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded">
                <form wire:submit.prevent="Insert">
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title" id="add-modalLabel">Ajouter un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="idCaseInput" wire:model.lazy="new_id_case1" placeholder=" " required />
                                    <label for="idCaseInput">ID CASE</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="networkAccessInput" wire:model.lazy="new_network_access1" placeholder=" " required />
                                    <label for="networkAccessInput">Accès réseau</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="lineNumberInput" wire:model.lazy="new_line_number1" placeholder=" " required />
                                    <label for="lineNumberInput">N° de la ligne</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="fullNameInput" wire:model.lazy="new_full_name1" placeholder=" " required />
                                    <label for="fullNameInput">Nom et prénom</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary shadow-sm" id="contactNumberInput" wire:model.lazy="new_contact_number1" placeholder="" required />
                                    <label for="contactNumberInput">N° de contact</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select border-primary shadow-sm" id="serviceActivitiesInput" wire:model.lazy="new_service_activities1" required>
                                        <option value="" selected >Sélectionnez une activité de service</option>
                                        <option value="Incompatibilité">Incompatibilité</option>
                                        <option value="Accès">Accès</option>
                                        <option value="Emplacement équipement">Emplacement équipement</option>
                                        <option value="Lenteur débit">Lenteur débit</option>
                                        <option value="Microcoupure data">Microcoupure data</option>
                                        <option value="Réception">Réception</option>
                                    </select>
                                    <label for="serviceActivitiesInput">Activités de service</label>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select border-primary shadow-sm" id="cityInput" wire:model.lazy="new_city_id1" required>

                                        <option selected value="">Sélectionnez une ville</option>
                                        @foreach ($cities as $city)
                                        
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="cityInput">Ville</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control border-primary shadow-sm" id="dateDmdInput" wire:model.lazy="new_dmd_date1" placeholder=" " required />
                                    <label for="dateDmdInput">Date demande</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <div class="">

                                <label for="addressInput">Adresse</label>
                                <textarea class="form-control border-primary shadow-sm" id="commentInput" wire:model.lazy="new_address1" rows=3 placeholder=""></textarea>
                            </div>
                        </div>
    
                        <div class="">
                            <label for="commentInput">Commentaire</label>
                            <textarea class="form-control border-primary shadow-sm" id="commentInput" wire:model.lazy="new_comment1" rows=3 placeholder=""></textarea>
                         
                        </div>
    
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none me-auto" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class='btn btn-success shadow-none'>
                            <span wire:loading.remove wire:target='Insert'>Ajouter</span>
                            <span wire:loading wire:target='Insert'>
                                <span class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span> Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
    

  
    {{-- <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="affectation">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Affectation des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @error('soustraitant_affectation')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        @error('selectedItems')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect"
                                aria-label="Floating label select example" wire:model="soustraitant_affectation">
                                <option selected>Sélectionnez un sous traitant</option>
                                @foreach ($sousTraitant as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Sous Traitant </label>
                        </div>
                        <div class="pt-3">

                        </div>
                        {{-- <div class="form-floating  ">
                            <select class="form-select" id="floatingSelect"
                                aria-label="Floating label select example" wire:model="selectedTech">
                                <option selected>Sélectionnez un technicien (Facultatif)</option>
                                @foreach ($sTechniciens as $item)
                                    <option value="{{ $item->id }}">{{ $item->user->getFullName() }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Techniciens </label>
                        </div> --}}
                   {{-- </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
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
    <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form wire:submit.prevent="affectation">
                <div class="modal-header">
                    <h4 class="modal-title" id="importation-modalLabel">Affectation des clients</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
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

                    <!-- Search Bar -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="searchSubcontractor"
                            placeholder="Rechercher un sous-traitant" wire:model="searchTerm">
                        <label for="searchSubcontractor">Rechercher un sous-traitant</label>
                    </div>

                    <!-- Display Subcontractor Items -->
                    <div class="list-group">
                        @foreach ($filteredSousTraitant as $item)
                            <button type="button" class="list-group-item list-group-item-action"
                                wire:click="$set('soustraitant_affectation', {{ $item->id }})">
                                {{ $item->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary shadow-none">
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


    <div id="relance-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="relance">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Rejouer le client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model.lazy="cause" />
                            <label for="floatingInput">Cause de rejouer le client</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
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

 

   
    
    
    

    <div id="pipe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pipe-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="pipe">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Importer pipe</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="example-fileinput" class="form-label">Veuillez utiliser le modèle
                                ci-dessous</label>
                            <input type="file" id="example-fileinput" class="form-control" wire:model="file"
                                required>
                        </div>
                        <a href="{{ asset('PIPE_TEMPLATE.xlsx') }}" class="m-0"> <i
                                class="uil-file me-1 font-18"></i>Télécharger le modèle</a>
                        <br>
                        <small class="text-danger"> <i class=" uil-info-circle"></i> Veuillez prendre en considération
                            le changement du type d'offre Déménagement en DEM</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
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

    <div id="deblocage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deblocage-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="rejouerBlocage">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Rejouer les blocages</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
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
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
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

</div>
