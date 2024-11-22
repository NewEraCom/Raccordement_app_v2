<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold d-none d-sm-none d-md-none d-lg-none d-xl-inline d-xxl-inline">
                        Filtrage
                    </h5>
                    <div class="ms-auto">
                        <div class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline d-xxl-inline">
                            <button class="btn btn-success btn-sm shadow-none mb-1" data-bs-toggle="modal"
                                data-bs-target="#exportation-modal"> <i class="uil-export me-2"></i> Exproter
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-4 mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Ville, Téléphone,SIP Ou Code Plaque " wire:model="client_sip" />
                                <label for="floatingInput">Ville, Téléphone, SIP Ou Code Plaque</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="client_status">
                                    <option value="" selected>Tous</option>
                                    <option value="Saisie">Saisie</option>
                                    <option value="Affecté">Affecté</option>
                                    <option value="Déclaré">Déclaré</option>
                                    <option value="Validé">Validé</option>
                                </select>
                                <label for="floatingSelect">Statut du client</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-2 mb-1">
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
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-2 mb-1">
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
                                <th class="text-center">Sip</th>
                                <th>Adresse</th>
                                <th>Client</th>                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $client)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input" value="{{ $client->id }}"
                                        wire:model="selectedItems">
                                </td>
                                <td class="text-center">{{ $client->sip }}</td>
                                <td>
                                    <h5 class="font-14 my-1">{{ Str::limit($client->address, 65) }}</h5>
                                    <span class="text-muted font-13">{{ $client->city->name ?? '-' }}</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1">{{ $client->name }}</h5>
                                    <span class="text-muted font-13">{{ $client->returnPhoneNumber() }} <small
                                            class="badge bg-info">{{ $client->offre }}</small> </span>
                                </td>                               
                                <td class="text-end">
                                    <a class="btn btn-primary btn-sm shadow-none" target="_blank"
                                        href="{{ route('sales.clients.profile', [$client->id]) }}"><i
                                            class="uil-eye"></i>
                                    </a>
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
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="exportation-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exportation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="export">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exportation-modalLabel">Exporter liste des clients</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir exporter un liste des clients vers un fichier
                            Excel ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
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