<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <button class="btn btn-primary btn-sm shadow-none" data-bs-toggle="modal"
                        data-bs-target="#associer-modal">
                        <i class="uil-link me-2"></i> Associer à un compte
                    </button>
                </div>
                <h4 class="page-title">{{ $soustraitant->name }}</h4>
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
                    <h5 class="text-muted fw-bold mt-0" title="Total Clients">Total Clients</h5>
                    <h3 class="mt-3 mb-1 text-primary">{{ $soustraitant->clients->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Techniciens">Techniciens</h5>
                    <h3 class="mt-3 mb-1 text-primary">{{ $soustraitant->techniciens->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-check-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Terminé">Client Terminé</h5>
                    <h3 class="mt-3 mb-1 text-primary">{{ $clients['declarations'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Blocage">Client Blocage</h5>
                    <h3 class="mt-3 mb-1 text-primary">{{ $clients['blocages'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex">
            <h5 class="text-muted fw-bold">Statistique</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-12">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="floatingInput" placeholder=""
                            wire:model="start_date" />
                        <label for="floatingInput">Du</label>
                    </div>
                </div>
                <div class="col-xl-4 col-12">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="floatingInput" placeholder=""
                            wire:model="end_date" />
                        <label for="floatingInput">Au</label>
                    </div>
                </div>
                <div class="col-xl-4 col-12">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" wire:model="city_id">
                            @foreach ($cities as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Statut d'affectation</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-12">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients">Clients</h5>
                    <h3 class="mt-3 mb-1 text-primary">{{ $clients['clientsByDate'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-check-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Declarations">Total Declarations</h5>
                    <h3 class="mt-3 mb-1 text-primary">{{ $clients['clientDeclarationByDate'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Validations">Total Validations</h5>
                    <h3 class="mt-3 mb-1 text-primary"> {{ $clients['clientValidationByDate'] }} </h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Blocages">Total Blocage</h5>
                    <h3 class="mt-3 mb-1 text-primary">{{ $clients['clientBlockedByDate'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="title-head">Clients</h4>
        </div>
        <div class="card-body p-0">
            <div class="row">
                <div class="col-12">
                    <table class="table table-centered table-responsive mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Sip</th>
                                <th>Adresse</th>
                                <th>Nom du client</th>
                                <th>Numéro de téléphone</th>
                                <th>Technicien</th>
                                <th class="text-center">Etat</th>
                                <th class="text-center">Créé à</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allClient as $client)
                                <tr>
                                    <td class="text-center">{{ $client->sip }}</td>
                                    <td>
                                        <h5 class="font-14 my-1">{{ Str::limit($client->address, 30) }}
                                        </h5>
                                        <span class="text-muted font-13">{{ $client->city->name }}</span>
                                    </td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->phone_no }}</td>
                                    <td>{{ $client->technicien ? $client->technicien->user->getFullname() : '-' }}
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ $client->getStatusColor() }}-lighten p-1 ps-2 pe-2">{{ $client->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $client->created_at->format('d-m-Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <h5 class="text-center">Aucun client trouvé</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <div class="text-center">
                        {{ $allClient->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="associer-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="associer">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-modalLabel">Associer à un compte</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @error('email')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Erreur!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" wire:model.lazy="email"
                                required />
                            <label for="floatingInput">Adresse email</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        wire:model.lazy="last_name" required />
                                    <label for="floatingInput">Nom</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        wire:model.lazy="first_name" required />
                                    <label for="floatingInput">Prénom</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" min="10" class="form-control" id="floatingInput"
                                wire:model.lazy="phone_no" />
                            <label for="floatingInput">Téléphone</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="associer">Associer</span>
                            <span wire:loading wire:target="associer">
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
