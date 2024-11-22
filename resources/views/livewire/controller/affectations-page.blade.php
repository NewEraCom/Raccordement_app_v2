<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Clients</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-phone-slash widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients injoignable">Clients injoignable</h5>
                    <h3 class="mt-3 mb-1">{{ $data['injoignable'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-user-exclamation widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Indisponible">Clients Indisponible</h5>
                    <h3 class="mt-3 mb-1">{{ $data['indisponible'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-user-times widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients à annuler sa demande">Clients à annuler sa
                        demande</h5>
                    <h3 class="mt-3 mb-1">{{ $data['cancel_client'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex">
            <h5 class="text-muted fw-bold">Filtré</h5>
            <div class="ms-auto d-none d-sm-none d-md-none d-lg-inline d-xl-inline d-xxl-inline">
                <button class="btn btn-success btn-sm shadow-none mb-1" wire:click='export'> <i class="uil-export me-2"></i> Exproter
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3 mb-1">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingInput"
                            placeholder="Ex : Ville, Téléphone,SIP Ou Code Plaque " wire:model="text" />
                        <label for="floatingInput">Ville, Téléphone, SIP Ou Code Plaque</label>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3 mb-1">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" wire:model="client_status">
                            <option value="" selected>Tous</option>
                            <option value="Injoignable/SMS">Clients injoignables</option>
                            <option value="Indisponible">Clients Indisponible</option>
                            <option value="Client  a annulé sa demande">Clients à annuler sa demande</option>
                        </select>
                        <label for="floatingSelect">Type de blocage</label>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="floatingInput" placeholder=""
                            wire:model="start_date" />
                        <label for="floatingInput">Du</label>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="floatingInput" placeholder=""
                            wire:model="end_date" />
                        <label for="floatingInput">Au</label>
                    </div>
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
                                <th>Nom du client</th>
                                <th class="text-center">Numéro de téléphone</th>
                                <th class="text-center">Etat</th>
                                <th class="text-center">Créé à</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($affectations as $item)
                            <tr>
                                <td class="text-center">{{ $item->client->sip }}</td>
                                <td>
                                    <h5 class="font-14 my-1">{{ $item->client->name }} {!! $item->client->flagged ? '<i class="uil-tag-alt text-danger"></i>' : '' !!}</h5>
                                    <span class="text-muted font-13">{{ $item->client->city->name }}</span>
                                </td>
                                <td class="text-center">{{ $item->client->returnPhoneNumber() }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $item->getStatusColor() }}-lighten p-1 ps-2 pe-2">{{
                                        $item->status }}</span>
                                    <br>
                                    <span class="badge badge-danger-lighten p-1 ps-2 pe-2 mt-1">{{
                                        $item->blocages->last()->cause ?? '-' }}</span>

                                </td>
                                <td class="text-center fw-bold">
                                    {{ \Carbon\Carbon::parse($item->blocages->last()->created_at)->format('d-m-Y H:i') }}
                                </td>
                                <th class="text-end">
                                    <a class="btn btn-primary btn-sm shadow-none" target="_blank"
                                        href="{{ route('controller.clients.profile', [$item->client->id]) }}"><i
                                            class="uil-eye"></i>
                                    </a>
                                    <button class="btn btn-warning shadow-none btn-sm" wire:click='$set("client_id",{{ $item->client_id }})' data-bs-target="#planifier-modal"
                                        data-bs-toggle="modal"> <i class="uil-calendar-alt"></i> </button>
                                    <button class="btn btn-danger shadow-none btn-sm" wire:click='$set("client_id",{{ $item->client_id }})' data-bs-target="#feedback-modal"
                                        data-bs-toggle="modal"> <i class="uil-times-circle"></i> </button>
                                </th>
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
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                {{ $affectations->links() }}
            </div>
        </div>
    </div>


    <div id="planifier-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="planifier">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-modalLabel">Planifier un client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="floatingInput" placeholder=""
                                        wire:model="planification_date" />
                                    <label for="floatingInput">Planifier pour (Date)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" id="floatingInput" placeholder=""
                                        wire:model="planification_time" />
                                    <label for="floatingInput">Planifier pour (Heure)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="floatingTextarea" wire:model="comment"
                                        style="height: 100px;"></textarea>
                                    <label for="floatingTextarea">Commentaire</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="planifier">Planifier</span>
                            <span wire:loading wire:target="planifier">
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

    <div id="feedback-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="feedback">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-modalLabel">Commentaire de contrôle qualité</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" wire:model="client_feedback"
                                        required>
                                        <option value="" selected>-</option>
                                        <option value="Splitter saturé">Splitter saturé</option>
                                        <option value="Blocage coté appartement ">Blocage coté appartement </option>
                                        <option value="Le client n’a pas encore résilié">Le client n’a pas encore
                                            résilié</option>
                                        <option value="En voyage">En voyage</option>
                                        <option value="En déplacement">En déplacement</option>
                                        <option value="Le client n’est plus intéressé">Le client n’est plus intéressé</option>
                                        <option value="Injoignable/SMS">Clients injoignables</option>
                                        <option value="Indisponible">Clients Indisponible</option>
                                        <option value="Client  a annulé sa demande">Clients à annuler sa demande</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                    <label for="floatingSelect">Feedback du client</label>
                                </div>
                            </div>
                        </div>
                        @if($client_feedback == 'Autre')
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" wire:model="custom_feedback" />
                            <label for="floatingInput">Feedback de client</label>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="floatingTextarea" wire:model="comment"
                                    style="height: 100px;"></textarea>
                                <label for="floatingTextarea">Commentaire</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="feedback">Envoyer</span>
                            <span wire:loading wire:target="feedback">
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