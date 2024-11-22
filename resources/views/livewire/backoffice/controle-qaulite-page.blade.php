<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Controle de Qualité</h4>
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
                    <h5 class="text-muted fw-bold mt-0" title="Clients En Cours">Clients En Cours</h5>
                    <h3 class="mt-3 mb-1">{{ $data['en_cours'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Planifié">Clients Planifié</h5>
                    <h3 class="mt-3 mb-1">{{ $data['planifie'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Bloqué">Clients Bloqué</h5>
                    <h3 class="mt-3 mb-1">{{ $data['bloque'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Terminé">Clients Terminé</h5>
                    <h3 class="mt-3 mb-1">{{ $data['termine'] }}</h3>
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
                            <button class="btn btn-success btn-sm shadow-none mb-1" data-bs-toggle="modal"
                                data-bs-target="#affecter-modal"> <i class="uil-label me-2"></i> Affecter
                            </button>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Ville, Téléphone,SIP Ou Code Plaque " wire:model="search" />
                                <label for="floatingInput">Ville, Téléphone, SIP Ou Nom</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="status">
                                    <option value="" selected>Tous</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Planifié">Planifié</option>
                                    <option value="Bloqué">Bloqué</option>
                                    <option value="Terminé">Terminé</option>
                                </select>
                                <label for="floatingSelect">Statut du client</label>
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
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">Sip</th>
                            <th>Adresse</th>
                            <th>Client</th>
                            <th class="text-center">Technicien</th>
                            <th class="text-center">Status d'affectation</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $item)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input" value="{{ $item->id }}"
                                    wire:model="selectedItems">
                            </td>
                            <td class="text-center">{{ $item->client->sip }}</td>
                            <td>
                                <h5 class="font-14 my-1">{{ Str::limit($item->client->address, 20) }}</h5>
                                <span class="text-muted font-13">{{ $item->client->city->name ?? '-' }}</span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1">{{ $item->client->name }}</h5>
                                <span class="text-muted font-13">{{ $item->client->returnPhoneNumber() }} <small
                                        class="badge bg-info">{{ $item->client->offre }}</small> </span>
                            </td>
                            <td class="text-center">
                                @if ($item->client->flagged == true && $item->technicien_id == 97)
                                {!! '<h4> <i class="uil-tag-alt text-danger"></i> </h4>' !!}
                                @else
                                {!! $item->technicien
                                ? $item->technicien->user->getFullname() . ' <small>(' .
                                    $item->technicien->soustraitant->name . ')</small>'
                                : '-' !!}
                                @endif
                               
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $item->getStatusColor() }}-lighten p-1 ps-2 pe-2">{{
                                    $item->status }}</span>
                                <br>
                                @if ($item->status == 'Bloqué')
                                <span class="badge badge-danger-lighten p-1 ps-2 pe-2 mt-1">{{
                                    $item->blocages->last()->cause ?? '-' }}</span>
                                @endif
                                @if ($item->status == 'Planifié')
                                <span class="badge badge-warning-lighten p-1 ps-2 pe-2 mt-1">{{
                                    $item->planification_date ?? '-' }}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm shadow-none" target="_blank"
                                    href="{{ route('admin.clients.profile', [$item->client_id]) }}"><i
                                        class="uil-eye"></i>
                                </a>
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
            <div class="mt-2 m-2">
                {{ $clients->links() }}
            </div>
        </div>
    </div>

    <div id="affecter-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
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
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                                wire:model="technicien_affectation">
                                <option selected>Sélectionnez un technicien</option>
                                @foreach ($techniciens as $item)
                                <option value="{{ $item->id }}">{{ $item->user->getFullname() }} <small>({{ $item->soustraitant->name }})</small> </option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Technicien </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
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

</div>