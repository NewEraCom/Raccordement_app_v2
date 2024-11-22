<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Planification</h4>
            </div>
        </div>
    </div>

    

    <div class="card">
        <div class="card-header border-bottom d-flex">
            <h5 class="text-muted fw-bold">Filtré</h5>            
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3 mb-1">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingInput"
                            placeholder="Ex : Ville, Téléphone,SIP Ou Adresse " wire:model="search" />
                        <label for="floatingInput">Nom, Ville, Téléphone ou SIP</label>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3 mb-1">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" wire:model="client_status">
                            <option value="" selected>Tous</option>
                            <option value="Planifié">Planifié</option>
                            <option value="Terminé">Terminé</option>
                        </select>
                        <label for="floatingSelect">Status de client</label>
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
        
        <div class="card-body p-0">
            <div class="row">
                <div class="col-12">
                    <table class="table table-centered table-responsive mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Sip</th>
                                <th>Adresse</th>
                                <th>Client</th>
                                <th class="text-center">Status de client</th>
                                <th class="text-center">Date d'affectation</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($planification as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $item->sip }}
                                    </td>
                                    <td>
                                        <h5 class="font-14 my-1">{{ Str::limit($item->address, 25) }}</h5>
                                        <span class="text-muted font-13">{{ $item->city->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <h5 class="font-14 my-1">{{ $item->name }}</h5>
                                        <span class="text-muted font-13">{{ $item->returnPhoneNumber() }} </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ $item->affectations->count() > 0 ? $item->affectations->first()->getStatusColor() : '-' }}-lighten p-1 ps-2 pe-2">
                                            {{ $item->affectations->count() > 0 ? $item->affectations->first()->status : '-'
                                            }}
                                        </span>
                                        <br>
                                        @if ($item->affectations->count() > 0)
                                        @if ($item->affectations->last()->status == 'Bloqué')
                                        <span class="badge badge-danger-lighten p-1 ps-2 pe-2 mt-1">{{
                                            $item->affectations->last()->blocages->last()->cause ?? '-' }}</span>
                                        @endif
                                        @if ($item->affectations->last()->status == 'Planifié')
                                        <span class="badge badge-warning-lighten p-1 ps-2 pe-2 mt-1">{{
                                            $item->affectations->last()->planification_date ?? '-' }}</span>
                                        @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $item->affectations->last()->created_at->format('d-m-Y H:i') ?? '-' }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('controller.clients.profile',$item) }}" class="btn btn-sm btn-primary shadow-none" target="_blank"> <i class="uil-eye"></i> </a>
                                        <button class="btn btn-sm btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#feedback-modal" wire:click="$set('client_id',{{ $item->id }})"> <i class="uil-times-circle"></i> </button>
                                        <button class="btn btn-sm btn-warning shadow-none" data-bs-toggle="modal" data-bs-target="#planifier-modal" wire:click="$set('client_id',{{ $item->id }})"> <i class="uil-edit-alt"></i> </button>
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
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                {{ $planification->links() }}
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
                                        wire:model="planification_date" required/>
                                    <label for="floatingInput">Planifier pour (Date)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" id="floatingInput" placeholder=""
                                        wire:model="planification_time" required/>
                                    <label for="floatingInput">Planifier pour (Heure)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="floatingTextarea" wire:model="comment"
                                        style="height: 100px;" required></textarea>
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
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="floatingTextarea" wire:model="feedback_blocage"
                                style="height: 100px;" required></textarea>
                            <label for="floatingTextarea">Commentaire</label>
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