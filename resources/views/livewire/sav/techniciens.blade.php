<div>
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Techniciens</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-users-alt widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Affectations du jour">Total Techniciens</h5>
                        <h3 class="mt-3 mb-1">{{ $data['total_technicien'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-mobile-android widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Appareil connecté">Appareil connecté</h5>
                        <h3 class="mt-3 mb-1">{{ $data['total_connecte'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-users-alt widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Total Affectations">Technicien Actif</h5>
                        <h3 class="mt-3 mb-1">{{ $data['technicien_actif'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-users-alt widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Total Déclarations">Technicien Inactif</h5>
                        <h3 class="mt-3 mb-1">{{ $data['technicien_inactif'] }}</h3>
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
                                data-bs-target="#add-modal">
                                <i class="uil-user-plus me-2"></i> Nouveau Technicien
                            </button>
                            {{--  <button class="btn btn-primary btn-sm shadow-none" data-bs-target="#importation-modal"
                                data-bs-toggle="modal">
                                <i class="uil-download-alt me-2"></i> Importer
                            </button>
                            <button class="btn btn-warning btn-sm shadow-none" wire:click="export">
                                <i class="uil-export me-2"></i> Exporter
                            </button>
                            <button class="btn btn-danger btn-sm shadow-none" data-bs-toggle="modal"
                                data-bs-target="#delete-all-modal">
                                <i class="uil-trash me-2"></i> Supprimer
                            </button>  --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput"
                                        placeholder="Ex : Amine Bachiri" wire:model="filtrage_name" />
                                    <label for="floatingInput">Nom de technicien</label>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelect" wire:model="soustraitant_selected">
                                        <option value="" selected>Tous</option>
                                        @foreach ($soustraitants as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Soustraitant</label>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table table-centered table-responsive mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th></th>
                                    <th>Technicien</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Ticket</th>
                                    <th class="text-center">Clients connectés</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($techniciens as $item)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input"
                                                value="{{ $item->id }}" wire:model="selectedItems">
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1">{{ $item->user->getFullname() }}
                                                {!! $item->user->status
                                                    ? '<i class="uil-check-circle text-success font-16"></i>'
                                                    : '<i class="uil-times-circle text-danger font-16"></i>' !!}
                                            </h5>
                                            <span class="text-muted font-13">
                                                @foreach ($item->cities as $city)
                                                    {{ $city->name }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                                - {{ $item->soustraitant->name }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {!! $item->user->device_key
                                                ? '<i class="uil-check-circle text-success font-16"></i> Appareil connecté'
                                                : '<i class="uil-times-circle text-danger font-16"></i> Appareil déconnecté' !!}
                                            {!! $item->player_id
                                                ? '<i class="uil-bell text-success font-16"></i>'
                                                : '<i
                                                                                        class="uil-bell-slash text-danger font-16"></i>' !!}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-{{ $item->getStatus()[0] }}-lighten rounded-pill p-2 font-12">{{ $item->getStatus()[1] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-warning-lighten rounded-pill p-2 font-12">{{ $item->tickets_count }}
                                                Ticket</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-danger-lighten rounded-pill p-2 font-12">{{ $item->connected_count }}
                                                Connecté</span>
                                        </td>

                                        {{--  <td class="text-end">
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" style="">
                                                    <a href="{{ route('sav.technicien', ['technicien' => $item]) }}"
                                                        class="dropdown-item"><i
                                                            class="uil uil-eye me-1"></i>Profil</a>
                                                    <button wire:click="$set('user_id',{{ $item->user->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#desactive-modal"
                                                        class="dropdown-item"><i
                                                            class="uil uil-{{ $item->user->status ? 'times' : 'check' }}-circle me-1"></i>
                                                        {{ $item->user->status ? 'Désactiver' : 'Activer' }}
                                                    </button>
                                                    <button wire:click="$set('technicien_id',{{ $item->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#refresh-modal"
                                                        class="dropdown-item"><i
                                                            class="uil uil-refresh me-1"></i>Rafraîchir
                                                    </button>
                                                    <button lass="btn btn-warning btn-sm shadow-none"
                                                        wire:click="setTech({{ $item }})"
                                                        data-bs-toggle="modal" data-bs-target="#edit-modal"
                                                        class="dropdown-item"><i class="uil uil-pen me-1"></i>Modifier
                                                    </button>

                                                    <button wire:click="$set('technicien_id',{{ $item->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                        class="dropdown-item text-danger">
                                                        <i class="uil uil-trash me-1"></i>Supprimer
                                                    </button>
                                                </div>
                                            </div>
                                        </td>  --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            Aucun technicien trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $techniciens->links() }}
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
                            <h4 class="modal-title" id="add-modalLabel">Nouveau Technicien</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-6 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput"
                                            placeholder="Ex : Amine" wire:model.lazy="first_name" required />
                                        <label for="floatingInput">Prénom de technicien</label>
                                    </div>
                                </div>
                                <div class="col-xl-6 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput"
                                            placeholder="Ex : El Harti" wire:model.lazy="last_name" required />
                                        <label for="floatingInput">Nom de technicien</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="Ex : a.harti@neweracom.ma" wire:model.lazy="email"
                                            required />
                                        <label for="floatingInput">Email de technicien</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect"
                                            wire:model.lazy="soustraitant_id" required>
                                            <option value="" selected>Choisissez un soustraitant</option>
                                            @foreach ($soustraitant_list as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelect">Soustraitant</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="form">
                                        <select id="example-multiselect" multiple class="form-control"
                                            wire:model="city_id" required>
                                            <option value="" selected disabled>Choisissez une ville</option>
                                            @foreach ($city_selected as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="floatingInput"
                                            placeholder="Ex : 0645885555" wire:model.lazy="phone_no" />
                                        <label for="floatingInput">Numéro de téléphone</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="" class="mb-2">Type de racco</label>
                                    <div class="row ms-1">
                                        <div class="form-check col-6">
                                            <input class="form-check-input" wire:model="type_tech" type="checkbox" value="1"
                                                id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Sav
                                            </label>
                                        </div>
                                        <div class="form-check col-6">
                                            <input class="form-check-input" wire:model="type_tech" type="checkbox" value="2"
                                                id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Racco
                                            </label>
                                        </div>
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

        <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="update">
                        <div class="modal-header">
                            <h4 class="modal-title" id="importation-modalLabel">Modifier Technicien</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-6 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput"
                                            placeholder="Ex : Amine" wire:model="e_first_name" required />
                                        <label for="floatingInput">Prénom de technicien</label>
                                    </div>
                                </div>
                                <div class="col-xl-6 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput"
                                            placeholder="Ex : El Harti" wire:model="e_last_name" required />
                                        <label for="floatingInput">Nom de technicien</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="Ex : a.harti@neweracom.ma" wire:model="e_email" required />
                                        <label for="floatingInput">Email de technicien</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect"
                                            wire:model="e_soustraitant_id" required>
                                            <option value="" selected>Choisir un sous-traitant</option>
                                            @foreach ($soustraitant_list as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelect">Soustraitant</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="form">
                                        <select id="example-multiselect" multiple class="form-control"
                                            wire:model="e_city_id" required>
                                            <option value="" selected>Choisissez une ville</option>
                                            @foreach ($city_selected as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-12 mb-2">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="floatingInput"
                                            placeholder="Ex : 0645885555" wire:model="e_phone_no" />
                                        <label for="floatingInput">Numéro de téléphone</label>
                                    </div>
                                </div>

                                {{-- <div class="col-xl-12 mb-2">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="floatingInput"
                                            placeholder="Ex : 2" wire:model="e_city_compteur" />
                                        <label for="floatingInput">Compteur d'affectation par ville</label>
                                    </div>
                                </div> --}}
                                <div class="col-xl-12 mb-2">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingInput"
                                            value="" autocomplete="new-password" wire:model="e_password" />
                                        <label for="floatingInput">Mot de passe</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light shadow-none"
                                data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary shadow-none">
                                <span wire:loading.remove wire:target="update">Modifier</span>
                                <span wire:loading wire:target="update">
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
                            <h4 class="modal-title" id="importation-modalLabel">Supprimer un technicien</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <p class="fw-bold f-16">Voulez-vous vraiment supprimer ce technicien ?</p>
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
                            <h4 class="modal-title" id="importation-modalLabel">Supprimer des techniciens</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <p class="fw-bold f-16">Voulez-vous vraiment supprimer les techniciens ?</p>
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

        <div id="desactive-modal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="disable">
                        <div class="modal-header">
                            <h4 class="modal-title" id="importation-modalLabel">Activer/Désactiver le compte</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <p class="fw-bold f-16">Êtes-vous sûr de vouloir désactiver/activer le compte technicien?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light shadow-none"
                                data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-danger shadow-none">
                                <span wire:loading.remove wire:target="disable">Oui, Désactiver/Activer</span>
                                <span wire:loading wire:target="disable">
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
                            <h4 class="modal-title" id="importation-modalLabel">Importer technicien</h4>
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
                                <span wire:loading.remove wire:target="import">Import</span>
                                <span wire:loading wire:target="import">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"
                                        aria-hidden="true">
                                    </span>
                                    Chargement...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="refresh-modal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="refresh">
                        <div class="modal-header">
                            <h4 class="modal-title" id="importation-modalLabel">Déconnecter un appareil</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <p class="fw-bold f-16">Êtes-vous sûr de vouloir déconnecter un appareil ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light shadow-none"
                                data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-danger shadow-none">
                                <span wire:loading.remove wire:target="refresh">Oui, Déconnecter</span>
                                <span wire:loading wire:target="refresh">
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
