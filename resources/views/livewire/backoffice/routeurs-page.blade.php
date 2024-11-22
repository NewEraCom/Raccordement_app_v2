<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Routeurs</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-technology widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total">Total</h5>
                    <h3 class="mt-3 mb-1">{{ $data['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-technology widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total actif">Total actif</h5>
                    <h3 class="mt-3 mb-1">{{ $data['total_active'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-technology widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total inactif">Total inactif</h5>
                    <h3 class="mt-3 mb-1">{{ $data['total_inactive'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-technology widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Besoin de vérification">Besoin de vérification</h5>
                    <h3 class="mt-3 mb-1">{{ $data['total_need_verification'] }}</h3>
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
                        <button class="btn btn-success btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#add-modal"> <i class="uil-plus me-2"></i> Ajouter
                        </button>
                        <button class="btn btn-warning btn-sm shadow-none" data-bs-toggle="modal"
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
                        <div class="col-xl-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Amine Bachiri" wire:model="routeur" />
                                <label for="floatingInput">GPON ou Mac de routeur</label>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : 0548445185" wire:model="client" />
                                <label for="floatingInput">Nom ou SIP de client</label>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="routeur_status">
                                    <option value="" selected>Tous</option>
                                    <option value="2">Besoin de vérification</option>
                                    <option value="1">Actif</option>
                                    <option value="0">Inactif</option>
                                </select>
                                <label for="floatingSelect">Statut du routeur</label>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-xl-3">
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
            <div class="row">
                <div class="col-12">
                    <table class="table table-centered table-responsive mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center">GPON</th>
                                <th class="text-center">MAC</th>
                                <th class="text-center">Sip</th>
                                <th class="text-center">Nom du client</th>
                                <th class="text-center">Technicien</th>
                                <th class="text-center">Statut</th>
                                <th class="text-center">Créé à</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($routeurs as $item)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input" value="{{ $item->id }}"
                                            wire:model="selectedItems">
                                    </td>
                                    <td class="text-center">{{ $item->sn_gpon }}</td>
                                    <td class="text-center">{{ $item->sn_mac }}</td>
                                    <td class="text-center">{{ $item->returnClientSip() }}</td>
                                    <td class="text-center">{{ $item->returnClientName() }}</td>
                                    <td class="text-center">
                                        {{ $item->technicien ? $item->technicien->user->getFullname() : '-' }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ $item->getStatusColor() }}-lighten p-1 ps-2 pe-2">{{ $item->status == 0 ? 'Inactif' : ($item->status === 1 ? 'Actif' : 'Besoin de vérification') }}</span>
                                    </td>
                                    <td class="text-center">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-success btn-sm shadow-none" data-bs-toggle="modal"
                                            data-bs-target="#actif-modal"
                                            wire:click="$set('routeur_id',{{ $item->id }})">
                                            <i class="uil-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm shadow-none"
                                            wire:click="setRouteur({{ $item }})"data-bs-toggle="modal"
                                            data-bs-target="#edit-modal"><i class="uil-pen"></i> </button>
                                        <button type="button" class="btn btn-danger btn-sm shadow-none"
                                            wire:click="$set('routeur_id',{{ $item->id }})"
                                            data-bs-toggle="modal" data-bs-target="#delete-modal"><i
                                                class="uil-trash"></i> </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Aucun routeur trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-2 ps-4">
                    {{ $routeurs->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="add">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-modalLabel">Ajouter un routeur</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model.lazy="sn_gpon" />
                            <label for="floatingInput">SN_GPON</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model.lazy="sn_mac" />
                            <label for="floatingInput">SN_MAC</label>
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

    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="edit">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-modalLabel">Ajouter un routeur</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model.lazy="e_sn_gpon" />
                            <label for="floatingInput">SN_GPON</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model.lazy="e_sn_mac" />
                            <label for="floatingInput">SN_MAC</label>
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

    <div id="importation-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="import">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Importer liste des routeurs</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="example-fileinput" class="form-label mb-2">Veuillez utiliser le modèle
                                ci-dessous.</label>
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
                                <span wire:loading.remove wire:target="import">Import</span>
                                <span wire:loading wire:target="import">
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

    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="delete">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Supprimer un routeur</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir supprimer ce routeur ?</p>
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

    <div id="actif-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="activer">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Activer le routeur</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment activer ce routeur ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="activer">Oui, activer</span>
                            <span wire:loading wire:target="activer">
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
                <form wire:submit.prevent="deleteSelected">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Supprimer des routeurs</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer les routeurs ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger shadow-none">
                            <span wire:loading.remove wire:target="deleteSelected">Oui, supprimez-le</span>
                            <span wire:loading wire:target="deleteSelected">
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
                        <h4 class="modal-title" id="importation-modalLabel">Exporter liste des routeurs</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir exporter un liste des routeurs vers un fichier
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

</div>
