<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
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
    
    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold d-none d-sm-none d-md-none d-lg-none d-xl-inline d-xxl-inline">
                        Filtrage</h5>
                    <div class="ms-auto">
                        <div class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline d-xxl-inline">

                          


                        </div>
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
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Ville, Téléphone,SIP Ou Code Plaque " wire:model="search" />
                                <label for="floatingInput">Ville, Téléphone, SIP Ou Code Plaque</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="client_status">
                                    <option value="" selected>Tous</option>
                                    <option value="Down">Down</option>
                                    <option value="Affecté">Affecté</option>
                                    <option value="Connecté">Connecté</option>
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
    </div> --}}

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered table-nowrap mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Case</th>
                            <th class="text-center">SIP</th>
                            <th class="text-center">Access</th>
                            <th>Adresse</th>
                            <th>Client</th>
                            <th class="text-center">Telephone</th>
                            <th class="text-center">Date de creation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr>                                
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
                <form wire:submit.prevent="delete">
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

    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="edit">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-modalLabel">Modifier un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        wire:model.lazy="e_address" />
                                    <label for="floatingInput">Adresse de client</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        wire:model="e_name" />
                                    <label for="floatingInput">Nom du client</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" min="10"
                                            wire:model="e_sip" />
                                        <label for="floatingInput">Login SIP</label>
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
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="e_type">
                                        <option value="" selected>Choisissez un type</option>
                                        <option value="B2B">B2B</option>
                                        <option value="B2C">B2C</option>
                                    </select>
                                    <label for="floatingSelect">Type de client</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                     <select class="form-select" id="floatingSelect" wire:model.lazy="e_type_prob">
                                        <option value="" selected>Choisissez un type</option>
                                        <option value="Accès">Accès</option>
                                        <option value="Changement routeur payant">Changement routeur payant</option>
                                         <option value="Emplacement équipement
">Emplacement équipement
</option>
                                          <option value="Lenteur débit">Lenteur débit</option>
                                           <option value="Microcoupure data">Microcoupure data</option>
                                             <option value="Réception

">Réception</option>
                                               <option value="Incompatibilité
">Incompatibilité</option>
                                    </select>
                                   
                                    <label for="floatingInput">Type Probleme</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        wire:model.lazy="e_description" />
                                    <label for="">Commentaire</label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="e_debit">
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
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="e_routeur">
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
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
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

    <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="affectation">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Affectation des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @error('technicien_affectation')
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
                                aria-label="Floating label select example" wire:model="technicien_affectation">
                                <option selected>Sélectionnez un technicien</option>
                                @foreach ($techniciens as $item)
                                    <option value="{{ $item->id }}">{{ $item->user->getFullname() }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Technicien </label>
                        </div>
                    </div>
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

    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="add">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-modalLabel">Ajouter un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model.lazy="new_name" />
                            <label for="floatingInput">Nom de client</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model.lazy="new_address" />
                            <label for="floatingInput">Adresse de client</label>
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

                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        wire:model.lazy="new_id_case" />
                                    <label for="floatingInput">Id Case</label>
                                </div>
                            </div>
                            <div class="col-6">



                                <div class="form-floating mb-3">
                                    <input type="number" min="10" class="form-control" id="floatingInput"
                                        wire:model.lazy="new_phone" />
                                    <label for="floatingInput">Téléphone</label>
                                </div>
                            </div>



                            <div>

                            </div>

                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="new_type">
                                        <option value="" selected>Choisissez un type</option>
                                        <option value="B2B">B2B</option>
                                        <option value="B2C">B2C</option>
                                    </select>
                                    <label for="floatingSelect">Type de client</label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model.lazy="new_type_prob">
                                        <option value="" selected>Choisissez un type</option>
                                        <option value="Accès">Accès</option>
                                        <option value="Changement routeur payant">Changement routeur payant</option>
                                         <option value="Emplacement équipement
">Emplacement équipement
</option>
                                          <option value="Lenteur débit">Lenteur débit</option>
                                           <option value="Microcoupure data">Microcoupure data</option>
                                             <option value="Réception

">Réception</option>
                                               <option value="Incompatibilité
">Incompatibilité</option>
                                    </select>
                                    <label for="floatingInput">Type Probleme</label>
                                </div>
                            </div>


                            <div>
                                <label for="description">Commentaire</label>

                                <textarea id="description" name="description" rows="4" cols="60" wire:model.lazy="new_description"></textarea>

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
                            <button type="button" class="btn btn-light shadow-none"
                                data-bs-dismiss="modal">Fermer</button>
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
