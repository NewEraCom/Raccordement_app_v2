<div class="container">
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
            <div class="card">
                <div class="card-header py-4 text-center bg-white">
                    <img src="{{ asset('assets/images/NEWERACONNECT.png') }}" alt="logo" height="120">
                </div>
                <div class="card-body p-4">                   
                    <div class="text-center w-100 m-auto">
                        <h4 class="text-dark-50 text-center pb-0 fw-bold">Se connecter</h4>
                        <p class="text-muted mb-4">Saisissez votre adresse e-mail et votre mot de passe pour accéder à
                            votre tableau de bord.</p>
                    </div>
                    <form wire:submit.prevent='login'>
                        @error('error')
                            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                                role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Adresse e-mail</label>
                            <input class="form-control" type="email" id="emailaddress" required
                                placeholder="Entrez votre adresse email" wire:model.lazy="email">
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('forget-password') }}" class="text-muted float-end"><small>Mot de passe
                                    oublié?</small></a>
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control"
                                    placeholder="Entrez votre mot de passe" wire:model.lazy="password" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mb-0 d-grid">
                            <button class="btn btn-primary shadow-none" type="submit">
                                <span wire:target="login" wire:loading.remove> Connexion</span>
                                <span wire:target="login" wire:loading>
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
</div>
