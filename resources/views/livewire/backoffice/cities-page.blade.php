<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Villes</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex align-items-center justify-content-between mb-4">
                        <div class="col-2">
                            @role('admin')
                                <button class="btn btn-primary shadow-none" data-bs-target="#add-modal"
                                    data-bs-toggle="modal">
                                    <i class="uil-plus me-2"></i> Ajouter une ville
                                </button>
                            @endrole
                        </div>
                        <div class="col-4 form-horizontal">
                            <div class="row">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Rechercher"
                                        wire:model="search">
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center">Clients</th>
                                <th scope="col" class="text-center">Plaque</th>
                                <th scope="col" class="text-center">Technicien</th>
                                <th scope="col" class="text-center">Declaration</th>
                                <th scope="col" class="text-center">Validation</th>
                                <th scope="col" class="text-center">Blocage</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cities as $item)
                                <tr class="align-middle">
                                    <td class="text-center">
                                        {{ $item->id }}
                                    </td>
                                    <th class="fw-bold text-center">{{ $item->name }} <small class="text-muted">({{ $item->compteur }})</small> </th>
                                    <td class="fw-bold text-center">
                                        <span
                                            class="badge badge-warning-lighten rounded-pill p-2 font-12">{{ $item->clients_count }}
                                            Clients</span>
                                    </td>
                                    <td class="fw-bold text-center">
                                        <span
                                            class="badge badge-primary-lighten rounded-pill p-2 font-12">{{ $item->plaques_count }}
                                            Plaques</span>
                                    </td>

                                    <td class="fw-bold text-center">
                                        <span
                                            class="badge badge-success-lighten rounded-pill p-2 font-12">{{ $item->techniciens_count }}
                                            Techniciens</span>
                                    </td>
                                    <td class="fw-bold text-center">
                                        <span
                                            class="badge badge-info-lighten rounded-pill p-2 font-12">{{ $item->declarations_count }}
                                            Declarations</span>
                                    </td>
                                    <td class="fw-bold text-center">
                                        <span
                                            class="badge badge-warning-lighten rounded-pill p-2 font-12">{{ $item->validations_count }}
                                            Validations</span>
                                    </td>
                                    <td class="fw-bold text-center">
                                        <span
                                            class="badge badge-danger-lighten rounded-pill p-2 font-12">{{ $item->blocages_count }}
                                            Blocages</span>
                                    </td>
                                    <td class="text-center">
                                        @role('supervisor')
                                            <a
                                                class="btn btn-primary btn-sm shadow-none"href="{{ route('supervisor.cities.profile', $item) }}"><i
                                                    class="uil-eye"></i>
                                            </a>
                                        @endrole
                                        @role('admin')
                                            <a
                                                class="btn btn-primary btn-sm shadow-none"href="{{ route('admin.cities.profile', $item) }}"><i
                                                    class="uil-eye"></i>
                                            </a>
                                            <button type="button" wire:click="setCity({{ $item }})"
                                                data-bs-target="#edit-modal" data-bs-toggle="modal"
                                                class="btn btn-warning btn-sm shadow-none"><i class="uil-pen"></i>
                                            </button>
                                            <button type="button" wire:click="$set('city_id',{{ $item->id }})"
                                                data-bs-target="#delete-modal" data-bs-toggle="modal"
                                                class="btn btn-danger btn-sm shadow-none"><i class="uil-trash"></i>
                                            </button>
                                        @endrole
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Aucune ville n'a été trouvée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $cities->links() }}
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
                        <h4 class="modal-title" id="importation-modalLabel">Supprimer une ville</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment supprimer cette ville ?</p>
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

    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="add">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Nouveau ville</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" wire:model="city_name" />
                            <label for="floatingInput">Nom de ville</label>
                        </div>
                        <div class="form-floating">
                            <input type="number" class="form-control" id="floatingInput" wire:model="compteur" />
                            <label for="floatingInput">Compteur de ville</label>
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
                        <h4 class="modal-title" id="importation-modalLabel">Modifier ville</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model="edit_city_name" />
                            <label for="floatingInput">Nom de ville</label>
                        </div>
                        <div class="form-floating">
                            <input type="number" class="form-control" id="floatingInput"
                                wire:model="e_compteur" />
                            <label for="floatingInput">Compteur de ville</label>
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

    <div id="set-status-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="setStatus">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Activer/Désactiver une ville</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment activer/désactiver cette ville ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger shadow-none">
                            <span wire:loading.remove wire:target="delete">Oui</span>
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

</div>
