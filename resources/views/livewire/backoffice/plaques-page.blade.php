<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                  <div class="page-title-right">
                        <button class="btn btn-success btn-sm shadow-none mb-1" data-bs-toggle="modal"
                            data-bs-target="#sync-modal"> <i class="uil-sync me-2"></i> Synchroniser Auto
                        </button>
                    </div>
                <h4 class="page-title">Plaques</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold">Filtrage</h5>
                    <div class="ms-auto">
                        <button class="btn btn-warning btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#add-modal">
                            <i class="uil-plus me-2"></i> Ajouter
                        </button>
                        <button class="btn btn-success btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#exportation-modal"> <i class="uil-export me-2"></i> Exproter
                        </button>
                        <button class="btn btn-info btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#importation-modal"> <i class="uil-down-arrow me-2"></i> Importer
                        </button>
                        <button class="btn btn-danger btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#delete-all-modal"> <i class="uil-trash me-2"></i> Supprimer
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : 01.18.56" wire:model="plaque_name" />
                                <label for="floatingInput">Code Plaque Ou ville</label>
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
                                <th class="text-center">Plaque</th>
                                <th class="text-center">Ville</th>
                                <th class="text-center">Client</th>
                                <th class="text-center">PPI</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($plaques->count() > 0)
                                @foreach ($plaques as $item)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input" value="{{ $item->id }}"
                                                wire:model="deleteList">
                                        </td>
                                        <td class="text-center">{{ $item->code_plaque }}</td>
                                        <td class="text-center">{{ $item->city ? $item->city->name : 'Hors Plaque' }}</td>
                                        <td class="text-center">
                                            <span
                                            class="badge badge-warning-lighten rounded-pill p-2 font-12">{{ $item->clients_count }}
                                            Clients</span>
                                        </td>
                                        <td class="text-center">
                                            <i class="mdi mdi-circle me-1 text-{{ $item->is_ppi ? 'success' : 'warning' }}"></i> {{ $item->is_ppi ? 'Plaque PPI' : 'Plaque normal' }}
                                        </td>
                                        <td class="text-end">
                                            <a
                                                class="btn btn-primary btn-sm shadow-none"href="{{ route('admin.plaques.profile', $item) }}"><i
                                                    class="uil-eye"></i>
                                            </a>
                                            <button type="button" wire:click="setPlaque({{ $item }})"
                                                data-bs-target="#edit-modal" data-bs-toggle="modal"
                                                class="btn btn-warning btn-sm shadow-none"><i class="uil-pen"></i>
                                            </button>
                                            <button type="button" wire:click="$set('plaque_id',{{ $item->id }})"
                                                data-bs-target="#delete-modal" data-bs-toggle="modal"
                                                class="btn btn-danger btn-sm shadow-none"><i class="uil-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="6">Aucun plaque trouvé</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-2 ps-4">
                    {{ $plaques->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="delete">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Supprimer un plaque</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer cet plaque ?</p>
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

    <div id="exportation-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="export">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Exporter liste des plaques</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir exporter un liste des plaques vers un fichier
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

    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="add">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Nouveau plaque</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" wire:model="plaque" />
                            <label for="floatingInput">Code Plaque</label>
                        </div>
                        <div class="form-floating mt-3">
                            <select class="form-select" id="floatingSelect"
                                aria-label="Floating label select example" wire:model="city">
                                <option selected>Sélectionnez un ville</option>
                                @foreach ($cities as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Ville </label>
                        </div>
                        <div class="form-floating mt-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input"  value="1" id="customSwitch1" wire:model='is_ppi'>
                                <label class="form-check-label" for="customSwitch1">Plaque PPI</label>
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

    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="edit">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Modification de plaque</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" wire:model="plaque" />
                            <label for="floatingInput">Code Plaque</label>
                        </div>
                        <div class="form-floating mt-3">
                            <select class="form-select" id="floatingSelect"
                                aria-label="Floating label select example" wire:model="city">
                                <option selected>Sélectionnez un ville</option>
                                @foreach ($cities as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Ville </label>
                        </div>
                        <div class="form-floating mt-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input"  value="1" id="customSwitch1" wire:model='is_ppi'>
                                <label class="form-check-label" for="customSwitch1">Plaque PPI</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="add">Modifier</span>
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
    
    <div id="sync-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="sync">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Synchronisation</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir exécuter une synchronisation automatique?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="sync">Oui, Synchroniser</span>
                            <span wire:loading wire:target="sync">
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
