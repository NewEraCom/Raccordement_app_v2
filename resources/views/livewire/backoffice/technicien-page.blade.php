<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <button class="btn btn-success btn-sm shadow-none mb-1" data-bs-toggle="modal"
                        data-bs-target="#get-localisation-modal"> <i class="uil-location me-2"></i> Obtenir
                        l'emplacement en
                        direct
                    </button>
                </div>
                <h4 class="page-title">{{ $technicien->user->getFullname() }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <div class="badge-primary-lighten rounded p-2">
                            <img src="{{ asset('assets/images/green-icon.png') }}" height="24" alt="" srcset="">
                        </div>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total d'affectations">Total d'affectations</h5>
                    <h3 class="mt-3 mb-1">{{ $profileTech->affectations_count }} <small>(En cours : {{
                            $profileTech->clientSaisie->count() }})</small> </h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <div class="badge-primary-lighten rounded p-2">
                            <img src="{{ asset('assets/images/blue-icon.png') }}" height="24" alt="" srcset="">
                        </div>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Déclaration">Total Déclaration</h5>
                    <h3 class="mt-3 mb-1">{{ $profileTech->declarations_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <div class="badge-primary-lighten rounded p-2">
                            <img src="{{ asset('assets/images/red-icon.png') }}" height="24" alt="" srcset="">
                        </div>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Blocage">Total Blocage</h5>
                    <h3 class="mt-3 mb-1">{{ $profileTech->blocages_count }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <div class="badge-primary-lighten rounded p-2">
                            <img src="{{ asset('assets/images/orange-icon.png') }}" height="24" alt="" srcset="">
                        </div>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Planifié">Clients Planifié</h5>
                    <h3 class="mt-3 mb-1">{{ $profileTech->affectations->where('status','Planifié')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

   


    <div id="get-localisation-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="importation-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="getLocalisation">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Localisation de ce technicien</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Êtes-vous sûr de vouloir obtenir la localisation de ce technicien ?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger shadow-none">
                            <span wire:loading.remove wire:target="getLocalisation">Oui, obtenir la position</span>
                            <span wire:loading wire:target="getLocalisation">
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

    @php
    $i = 0;
    @endphp

    
</div>