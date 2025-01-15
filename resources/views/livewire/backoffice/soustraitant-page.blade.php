<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Soustraitant</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold">Filtrage</h5>
                 <div class="ms-auto">
                       <button class="btn btn-warning btn-sm shadow-none" data-bs-toggle="modal"
                            data-bs-target="#add-modal">
                            <i class="uil-plus me-2"></i> Ajouter
                        </button> 
                    </div>  
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Neweracom" wire:model="name" />
                                <label for="floatingInput">Soustraitant</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($soustraitant as $item)
            <div class="col-12 col-sm-12 col-lg-12 col-xl-6 col-xxl-4">
                    @hasanyrole('admin|sav')
                    <a href="{{ route('admin.soustraitant.profile', $item) }}">
                    @endhasanyrole
                    @role('supervisor')
                        <a href="{{ route('supervisor.soustraitant.profile', $item) }}">
                    @endrole
                        <div class="card">
                            <div class="card-body">
                                <span class="float-start m-2 me-4">
                                    <img src="{{ asset('assets/images/logo.png') }}"
                                        style="height: 100px;width:100px;object-fit:contain" alt="avatar-2"
                                        class="rounded-circle img-thumbnail">
                                </span>
                                <div class="">
                                    <h4 class="mt-1 mb-1 fw-bold text-dark">{{ $item->name }}</h4>
                                    <p class="font-13 text-dark">ID : {{ $item->uuid }}</p>

                                    <ul class="mb-0 list-inline">
                                        <li class="list-inline-item me-3">
                                            <h5 class="mb-1">{{ $item->techniciens_count }}</h5>
                                            <p class="mb-0 font-13 text-dark fw-bold">Technicien</p>
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 class="mb-1">{{ $item->clients_count }}</h5>
                                            <p class="mb-0 font-13 text-dark fw-bold">Clients</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Aucun soustraitant trouvé</h4>
                            <p>Il n'y a aucun soustraitant dans la base de données.</p>
                            <hr>
                            <p class="mb-0">Veuillez ajouter un soustraitant.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importation-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="add">
                    <div class="modal-header">
                        <h4 class="modal-title" id="importation-modalLabel">Nouveau soustraitant</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput"
                                wire:model="soustraitant_name" />
                            <label for="floatingInput">Nom de soustraitant</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
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

</div>
