<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Rapports clients</h4>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="app-search">
                <form>
                    <div class="mb-2 position-relative">
                        <input type="text" class="form-control" placeholder="SIP" wire:model='search'>
                        <span class="mdi mdi-magnify search-icon"></span>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-centered table-nowrap mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Sip</th>
                            <th>Client</th>
                            <th class="text-center">Back Office</th>
                            <th class="text-center">Controle Qualité</th>
                            <th class="text-center">Responsable</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                        <tr>
                            <td class="text-center">{{ $client->sip }}</td>

                            <td>
                                <h5 class="font-14 my-1">{{ $client->name }}</h5>
                                <span class="text-muted font-13">{{ $client->offre }}</span>
                            </td>
                            <td class="text-center">
                                @if ($client->phase_one == 1)
                                <i class="uil-check font-24 text-success"></i>
                                @else
                                <i class="uil-times font-24 text-danger"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($client->phase_two == 1)
                                <i class="uil-check font-24 text-success"></i>
                                @else
                                <i class="uil-times font-24 text-danger"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($client->phase_three == 0)
                                <i class="uil-minus font-24 text-warning"></i>
                                @endif
                                @if ($client->phase_three == 1)
                                <i class="uil-check font-24 text-success"></i>                                
                                @endif
                                @if ($client->phase_three == 2)
                                <i class="uil-times font-23 text-danger"></i>
                                @endif
                            </td>
                            <td class="text-end">
                                <a class="btn btn-primary btn-sm shadow-none"
                                    href="{{ route('admin.clients.profile',$client) }}" target="_blank">
                                    <i class="uil-eye"></i>
                                </a>
                                <button class="btn btn-success btn-sm shadow-none"
                                    wire:click="$set('client',{{ $client->id }})" data-bs-toggle="modal"
                                    data-bs-target="#valider-modal">
                                    <i class="uil-check"></i>
                                </button>
                                <button class="btn btn-danger btn-sm shadow-none"
                                    wire:click="$set('client',{{ $client->id }})" data-bs-toggle="modal"
                                    data-bs-target="#refuser-modal">
                                    <i class="uil-times"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucun client trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="valider-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="valider">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Valide Le rapport</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment valider le rapport ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="valider">Valider</span>
                            <span wire:loading wire:target="valider">
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

    <div id="refuser-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="refuser">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Temporiser paiement</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir temporiser le paiement ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="refuser">Temporiser paiement</span>
                            <span wire:loading wire:target="refuser">
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