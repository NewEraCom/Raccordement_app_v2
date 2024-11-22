<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Affectations</h4>
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
                    <h5 class="text-muted fw-bold mt-0" title="Affectations du jour">Affectations du jour</h5>
                    <h3 class="mt-3 mb-1">{{ $data['affectationsOfTheDay'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Affectations">Total Affectations</h5>
                    <h3 class="mt-3 mb-1">{{ $data['totalAffectations'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Déclarations">Total Déclarations</h5>
                    <h3 class="mt-3 mb-1">{{ $data['totalDeclaration'] }}</h3>
                </div>
            </div>
        </div>


        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Restant">Clients Restant</h5>
                    <h3 class="mt-3 mb-1">{{ $data['totalNoAffecte'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-bolt-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations En cours">Affectations En cours</h5>
                    <h3 class="mt-3 mb-1">{{ $data['totalAffectationsEnCours'] }} <small>(Aujourd'hui :
                            {{ $data['totalAffectationsEnCoursOfTheDay'] }} )</small> </h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations Bloqué">Affectations Bloqué</h5>
                    <h3 class="mt-3 mb-1">{{ $data['totalAffectationsBlocked'] }} <small>(Aujourd'hui :
                            {{ $data['totalAffectationsBlockedOfTheDay'] }} )</small></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-clock-three widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations Planifié">Affectations Planifié</h5>
                    <h3 class="mt-3 mb-1">{{ $data['totalAffectationsPlanned'] }} <small>(Aujourd'hui :
                            {{ $data['totalAffectationsPlannedOfTheDay'] }} )</small></h3>
                </div>
            </div>
        </div>


        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-check-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations Terminé">Affectations Terminé</h5>
                    <h3 class="mt-3 mb-1">{{ $data['totalAffectationsDone'] }} <small>(Aujourd'hui :
                            {{ $data['totalAffectationsDoneOfTheDay'] }} )</small></h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold">Filtrage</h5>
                    <div class="ms-auto">
                        @if ($client_status == 'Bloqué')
                            <button class="btn btn-warning btn-sm shadow-none me-1" data-bs-toggle="modal"
                                data-bs-target="#filter-modal"> <i class="uil-filter me-2"></i> Filtre de blocage
                            </button>
                        @endif
                        <button class="btn btn-success btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#exportation-modal"> <i class="uil-export me-2"></i> Exproter
                        </button>
                        <button class="btn btn-danger btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#delete-all-modal"> <i class="uil-trash me-2"></i> Supprimer
                        </button>
                        <button class="btn btn-secondary btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#affecter-modal"> <i class="uil-label me-2"></i> Affecter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Amine Bachiri" wire:model="client_name" />
                                <label for="floatingInput">Ville, SIP ou Nom client</label>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="client_status">
                                    <option value="" selected>Tous</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Planifié">Planifié</option>
                                    <option value="Bloqué">Bloqué</option>
                                    <option value="Terminé">Terminé</option>
                                </select>
                                <label for="floatingSelect">Statut d'affectation</label>
                            </div>
                        </div>
                        <div class="col-xl-2">
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
                        <div class="col-xl-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" value="{{ $start_date }}" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="end_date" value="{{ $start_date }}" />
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
            <div class="row">
                <div class="col-12">
                    <table class="table table-centered table-responsive mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th></th>
                                <th class="text-center">Sip</th>
                                <th>Adresse</th>
                                <th>Nom du client</th>
                                @if (Auth::user()->email != 'b.elboudri@neweracom.ma')
                                <th class="text-center">Technicien</th>
                                @endif
                                <th class="text-center">Etat</th>
                                <th class="text-center">Créé à</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($affectations as $affectation)
                            <tr class="align-middle">
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input" value="{{ $affectation->id }}"
                                        wire:model="selectedItems">
                                </td>
                                <td class="text-center">{{ $affectation->client->sip }}</td>
                                <td>
                                    <h5 class="font-14 my-1">{{ Str::limit($affectation->client->address, 20) }}
                                    </h5>
                                    <span class="text-muted font-13">{{ $affectation->client->city ?
                                        $affectation->client->city->name : '-' }}</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1">{{ $affectation->client->name }}</h5>
                                    <span class="text-muted font-13">{{ $affectation->client->returnPhoneNumber()
                                        }}</span>
                                </td>
                                @if (Auth::user()->email != 'b.elboudri@neweracom.ma')
                                <td class="text-center">
                                    @if ($affectation->client->flagged && $affectation->client->technicien_id == 97)
                                    {!! '<h4> <i class="uil-tag-alt text-danger"></i> </h4>' !!}
                                    @else
                                    {!! $affectation->client->technicien
                                    ? $affectation->client->technicien->user->getFullname() . ' <small>(' .
                                        $affectation->client->technicien->soustraitant->name . ')</small>'
                                    : '-' !!}
                                    @endif

                                </td>
                                @endif                                
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
                                <td class="text-center fw-bold">
                                    {{ \Carbon\Carbon::parse($affectation->created_at)->format('d-m-Y H:i') }}
                                </td>
                                <td class="text-end">
                                    @if ($affectation->status == 'Bloqué')
                                    <button class="btn btn-sm btn-success shadow-none"
                                        wire:click="$set('affectation_id',{{ $affectation->id }})"
                                        data-bs-toggle="modal" data-bs-target="#relance-modal"> <i
                                            class="uil-user-check" alt='resolue le blocage'></i> </button>
                                    @endif
                                    <a class="btn btn-primary btn-sm shadow-none" target="_blank"
                                        href="{{ route('admin.clients.profile', [$affectation->client_id]) }}"><i
                                            class="uil-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm shadow-none"
                                        wire:click="$set('affectation_id',{{ $affectation->id }})"
                                        data-bs-toggle="modal" data-bs-target="#delete-modal"><i class="uil-trash"></i>
                                    </button>
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
                    {{ $affectations->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="exportation-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="export">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Exporter liste des affectations</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir exporter un liste des affectations vers un
                            fichier
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

    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="delete">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Supprimer un affectation</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer cet affectation ?</p>
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
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="deleteAll">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Supprimer des affectations</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer les affectations ?</p>
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
                                    <option value="{{ $item->id }}">{{ $item->user->getFullname() . ' (' .$item->soustraitant->name }} )</option>
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
    </div> --}}
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
    </div>
    
    
    
    
    
    
    <div id="relance-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="relance">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Résolu le blocage</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Es-tu sûr que ce problème a été résolu ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger shadow-none">
                            <span wire:loading.remove wire:target="relance">Oui</span>
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

    <div id="filter-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="importation-modalLabel">Filtre de blocage</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                            wire:model="blocage_type" wire:>
                            <option selected>Sélectionnez un blocage</option>
                            @foreach ($blocages as $item)
                                <option value="{{ $item->cause }}">{{ $item->cause }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Blocages </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

</div>
