<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Affectations</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4">
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
        <div class="col-12 col-sm-6 col-xl-4">
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
        
        
        <div class="col-12 col-sm-6 col-xl-4">
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
                        {{--<button class="btn btn-danger btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#delete-all-modal"> <i class="uil-trash me-2"></i> Supprimer
                        </button>--}}
                         <button class="btn btn-secondary btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#affecter-modal"> <i class="uil-label me-2"></i> Affecter
                        </button> 
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-4 mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Ville, Téléphone,SIP, " wire:model="search" />
                                <label for="floatingInput">Ville ou Téléphone ou SIP</label>
                            </div>
                        </div>

                        {{--  <div class="col-xl-2">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="technicien">
                                    <option value="" selected>-</option>
                                    @foreach ($techniciens as $item)
                                        <option value="{{ $item->id }}">{{ $item->user->getFullname() }}
                                            <small>({{ $item->soustraitant->name }})</small> </option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Technicien</label>
                            </div>
                        </div>  --}}

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
                                <th class="text-center">ID Case</th>

                                <th class="text-center">Sip</th>
                                <th>Adresse</th>
                                <th> Nom Complet </th>
                                <th class="text-center">Sous Traitant</th>
                                <th class="text-center">Technicien</th>

                                <th class="text-center">Etat</th>
                                <th class="text-center">Créé à</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($affectations as $affectation) 
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input" value="{{ $affectation->id }}"
                                            wire:model="selectedItems">
                                    </td>
                                    <td>
                                        <a href="" class="text-body fw-bold">{{ $affectation->id_case }}</a>
                                    </td>
                                    <td>
                                        {{ $affectation->client ? $affectation->client->sip : '-' }}
                                    </td>
                                    <td>
                                        {{ $affectation->client ? Str::limit($affectation->client->address, 50) : '-' }}
                                    </td>
                                    <td>
                                        {{ $affectation->client ? $affectation->client->client_name : '-' }}
                                    </td>
                                    <td>
                                        {{ $affectation->soustraitant ? $affectation->soustraitant->name : '-' }}
                                    </td>
                                    <td> {{ $affectation->technicien ?  $affectation->technicien->user->getFullname() : '-' }}</td>

                                    <td>
                                        @if ($affectation->status == 'Bloqué')
                                            <span class="badge bg-danger p-1">{{ $affectation->status }}</span>
                                        @elseif($affectation->status == 'Planifié')
                                            <span class="badge bg-warning p-1">{{ $affectation->status }}</span>
                                        @elseif($affectation->status == 'En cours')
                                            <span class="badge bg-primary p-1">{{ $affectation->status }}</span>
                                        @elseif($affectation->status == 'Validé')
                                            <span class="badge bg-success p-1">{{ $affectation->status }}</span>
                                        @elseif($affectation->status == 'Affecté')
                                            <span class="badge bg-warning p-1">{{ $affectation->status }}</span>
                                        @endif

                                    </td>
                                    <td>
                                        {{ $affectation->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">

                                        <div class="d-flex justify-content-center" target="_blank">
                                            @if ($affectation->status == 'Bloqué')
                                            <button class="btn btn-warning btn-sm shadow-none"
                                            wire:click="unblock({{ $affectation }})"
                                 ><i
                                        class="uil-refresh"></i>
                                </button>
                                            @endif 
                                            @if($affectation->client)
                                            <a class="btn btn-primary btn-sm shadow-none" target="_blank"

                                            href="{{ route('sav.clients.screen', $affectation->client) }}"><i
                                                class="uil-eye"></i>
                                        </a>
                                        @endif
                                         
                                        {{-- <button wire:click="test({{ $affectation->id }})">
                                            test
                                        </button> --}}
                                            <button class="btn btn-danger btn-sm shadow-none" data-bs-toggle="modal"
                                                data-bs-target="#delete-modal"
                                                wire:click="$set('affectation_id',{{ $affectation->id }})"><i
                                                    class="uil-trash"></i></button>
                                        </div>
                                </tr>
                               
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucune affectation trouvé</td>
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
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir exporter une liste des affectations vers un
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
                        <h4 class="modal-title" id="delete-modalLabel">Supprimer une affectation</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer cette affectation ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger shadow-none">
                            <span wire:loading.remove wire:target="delete">Oui, supprimez-la</span>
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
                            <span wire:loading.remove wire:target="deleteAll">Oui, supprimez-les</span>
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

    <!-- <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog"
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
    </div> -->
    <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog"
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
                        <!-- <div class="form-floating">
                            <select class="form-select" id="floatingSelect"
                                aria-label="Floating label select example" wire:model="soustraitant_affectation">
                                <option selected>Sélectionnez un sous traitant</option>
                                @foreach ($sousTraitant as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Sous Traitant </label>
                        </div> -->
                        <div class="pt-3">

                        </div>
                         <div class="form-floating  ">
                            <select class="form-select" id="floatingSelect"
                                aria-label="Floating label select example" wire:model="selectedTech">
                                <option selected>Sélectionnez un technicien </option>
                                @foreach ($sTechniciens as $item)
                                    <option value="{{ $item->id }}">{{ $item->user->getFullName() }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Techniciens </label>
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
