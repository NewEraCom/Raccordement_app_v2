<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                </div>
                <h4 class="page-title">{{ $client->name }}</h4>
            </div>
        </div>
    </div>

    <div class="card bg-{{ $client->getStatusSavColor() }} shadow-none">
        <div class="card-body profile-user-box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row align-items-center">
                        <div class="col">
                            <div>
                                <h4 class="mt-1 mb-1 text-white">{{ $client->name }}</h4>
                                <p class="font-13 text-white-50"></p>
                                <ul class="mb-0 list-inline text-light">
                                    <li class="list-inline-item me-3">
                                        <h5 class="mb-1 text-white">{{ $client->created_at->format('d-m-Y') }}
                                        </h5>
                                        <p class="mb-0 font-13 text-white-50">Date de creation</p>
                                    </li>
                                    <li class="list-inline-item">
                                        <h5 class="mb-1 text-white">{{ $client->status }}</h5>
                                        <p class="mb-0 font-13 text-white-50">Status</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col text-end">
                            {!! $client->flagged ? '<h1><i class="uil-tag-alt text-danger"></i></h1>' : '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 col-xxl-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title bg-light p-2 mt-0 mb-3"> <i class="uil-user me-2"></i> Informations du
                        client</h4>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">ID Case</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                            value="{{ $client->n_case ?? 'N/A' }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">SIP</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->sip }}">
                        </div>
                    </div>
                    {{-- <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Login internet</label>
                        <div class="col-7">
                                <p>{{ $client->login }}</p>
                        </div>
                    </div> --}}
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Nom du client</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->client_name }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Activités de service</label>
                        <div class="col-7">
                            <p>{{ $client->service_activities }}</p>
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Adresse</label>
                        <div class="col-7">
                            <p>{{ $client->address }}</p>
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Numéro de téléphone</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->returnPhoneNumber() }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Ville</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->city->name }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Plaque</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $clientt->plaque->code_plaque }}">
                        </div>
                    </div>
                    {{-- <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Type</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->type }}">
                        </div>
                    </div> --}}
                    <!-- <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Type Probleme</label>
                        <div class="col-7">
                            <p>{{ $client->type  }}</p>
                        </div>
                    </div> -->
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Commentaire</label>
                        <div class="col-7">
                            <p>{{ $client->comment }}</p>
                        </div>
                    </div>
                    <!-- <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Equipement</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->routeur_type }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Débit</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->debit != '-' ? $client->debit . ' Méga' : '-' }} ">
                        </div>
                    </div> 
                     <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Status du client</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->status }}">
                        </div>
                    </div> -->
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Date de création</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->created_at->format('d-m-Y H:i:s') }}">
                        </div>
                    </div>
                    {{-- <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Rapport telecharger</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->updated_at->format('d-m-Y H:i:s') }}">
                        </div>
                    </div> --}}
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Date de la dernière mise à
                            jour</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->updated_at->format('d-m-Y H:i:s') }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Créé par</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->createdBy === null ? 'Auto' : $client->createdBy->getFullname() }}">
                        </div>
                    </div>
                    @if ($client->status == 'Affecté')
                        <div class="row mb-2 align-middle">
                            <label for="inputEmail3" class="col-5 col-form-label fw-bold">Type d''affectation</label>
                            <div class="col-7">
                                <input type="text" readonly class="form-control-plaintext" id="example-static"
                                    value="{{ $client->type_affectation }}">
                            </div>
                        </div>
                    @endif
                    @if ($client->savTickets->last() != null)
                        <div class="row mb-2 align-middle">
                            <label for="inputEmail3" class="col-5 col-form-label fw-bold">Affecter par</label>
                            <div class="col-7">
                                <input type="text" readonly class="form-control-plaintext" id="example-static"
                                    value="{{ $client->savTickets->last()->affectedBy ? $client->savTickets->last()->affectedBy->getFullname() : '-' }}">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 col-xxl-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title bg-light p-2 mt-0 mb-1"> <i class="uil-chart me-2"></i> Historique des
                        affectations</h4>
                <div class="timeline-alt">
                        {{-- @forelse ($affe as $value)
                        @foreach ($value->savhistories as $item)
                        <div class="timeline-item">
                            <i
                                class="bg-{{ $item->getStatusSavColor() }}-lighten text-{{ $item->getStatusSavColor() }} ri-bookmark-fill timeline-icon"></i>
                            <div class="timeline-item-info">
                                <h5 class="mt-0 mb-1">{{ $item->status }}
                                    <small>
                                        {{ $item->status == 'Planifié' ? '(' . $item->cause . ')' : ($item->status ==
                                        'Bloqué' ? '(' . $item->cause . ')' : '') }}
                                    </small>
              s                  </h5>
                                <p class="font-14"><i class="uil-user"></i>
                                    {{ $item->technicien->id == 97
                                    ? 'Contrôle Qualité'
                                    : ' Technicien :
                                    ' . $item->technicien->user->getFullname() }}
                                    <span class="ms-2 font-12">
                                        <i class="uil-clock"></i>
                                        {{ $item->created_at->format('d-m-Y H:i:s') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @empty
                        
                        @endforelse --}}

                        @foreach ($affe as $ticket)
                        @forelse ($ticket->savhistories ?? [] as $item)
                            <div class="timeline-item border rounded p-2 mb-2 bg-light">
                                <div class="d-flex align-items-start">
                                    <!-- Icon -->
                                    <i class="bg-{{ $item->getStatusSavColor($item->status) }}-lighten text-{{ $item->getStatusSavColor($item->status) }} ri-bookmark-fill fs-5 me-2"></i>
                    
                                    <!-- Content -->
                                    <div class="flex-grow-1">
                                        <!-- Status -->
                                        <h6 class="mt-0 mb-1 text-{{ $item->getStatusSavColor($item->status) }} fw-bold">
                                            {{ $item->status }}
                                        </h6>
                    
                                        <!-- Description -->
                                        <p class="text-secondary mb-1 small">{{ $item->description }}</p>
                    
                                        <!-- Sous-traitant (Only for 'Affecté') -->
                                        @if ($item->status === 'Affecté')
                                            <p class="text-dark small mb-0">
                                                <i class="ri-user-line me-1 text-primary"></i>
                                                Sous-traitant: {{ optional($item->soustraitant)->name ?? 'N/A' }}
                                            </p>
                                        @endif
                    
                                        <!-- Date -->
                                        <p class="text-muted mb-1 small">
                                            <i class="ri-calendar-2-line me-1"></i>
                                            Créé le: {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @empty
                        
                       
                        <div class="text-center">
                            <h1><i class="uil-times-circle"></i></h1>
                            <h4>Il n'y a pas encore d'affectations.</h4>
                        </div>
                        @endforelse
                  
                    
                    
                    
                    
                    </div> 


                    <h4 class="header-title bg-light p-2 mt-2 mb-1"> <i class="uil-file me-2"></i> Feed-back</h4>
                    
                    <div class="timeline-alt">
                        @forelse ($client->savTickets->last()->feedback ?? [] as $item)
                            <div class="timeline-item border rounded shadow-lg p-4 mb-4 bg-light">
                                <!-- Header with Icon and Type -->
                    
                                <p class="text-muted">
                                    <i class="ri-information-line me-1 text-info"></i>
                                    <strong>Type:</strong> {{ $item->type }}
                                </p>
                                
                    
                                <!-- Root Cause -->
                                @if ($item->root_cause)
                                    <p class="text-muted mb-3">
                                        <i class="ri-alert-line me-1 text-danger"></i>
                                        <strong>Cause Racine:</strong> {{ $item->root_cause }}
                                    </p>
                                @endif
                    
                                <!-- Unite -->
                                @if ($item->unite)
                                    <p class="text-muted mb-3">
                                        <i class="ri-hashtag me-1 text-primary"></i>
                                        <strong>Unité:</strong> {{ $item->unite }}
                                    </p>
                                @endif
                    
                                <!-- Before and After Pictures -->
                                @if ($item->before_picture || $item->after_picture)
                                <div class="row g-2">
                                    @if ($item->before_picture)
                                        <div class="col-md-6 text-center">
                                            <h6 class="text-muted small">Avant</h6>
                                            <img src="{{ asset('storage/' . $item->before_picture) }}" 
                                                 class="img-fluid rounded shadow-sm" 
                                                 alt="Before Picture" 
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#beforePictureModal">
                                        </div>
                                    @endif
                                    @if ($item->after_picture)
                                        <div class="col-md-6 text-center">
                                            <h6 class="text-muted small">Après</h6>
                                            <img src="{{ asset('storage/' . $item->after_picture) }}" 
                                                 class="img-fluid rounded shadow-sm" 
                                                 alt="After Picture" 
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#afterPictureModal">
                                        </div>
                                    @endif
                                </div>
                            
                                <!-- Modals -->
                                @if ($item->before_picture)
                                    <div class="modal fade" id="beforePictureModal" tabindex="-1" aria-labelledby="beforePictureModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="beforePictureModalLabel">Avant</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $item->before_picture) }}" 
                                                         class="img-fluid rounded" 
                                                         alt="Before Picture">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            
                                @if ($item->after_picture)
                                    <div class="modal fade" id="afterPictureModal" tabindex="-1" aria-labelledby="afterPictureModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="afterPictureModalLabel">Après</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $item->after_picture) }}" 
                                                         class="img-fluid rounded" 
                                                         alt="After Picture">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            
                            
                            </div>
                        @empty
                            <div class="text-center">
                                <h1><i class="uil-times-circle"></i></h1>
                                <h4>Il n'y a pas encore de Feedback.</h4>
                            </div>
                        @endforelse
                    </div>
                    
{{-- Blocages Section --}}
@if ($client->savTickets->last()->blocages ?? false)
<div class="blocages-section">
    {{-- <h4 class="header-title bg-light p-2 mt-0 mb-1"> <i class="uil-chart me-2"></i> Blocage</h4> --}}
    @foreach ($client->savTickets->last()->blocages as $blocage)
    <div class="timeline-item border rounded shadow-lg p-4 mb-4 bg-light">
        <div class="card-header bg-danger text-white">
            <h6 class="mb-0">Détails du Blocage</h6>
        </div>
        <div class="card-body text-center">
            <!-- Cause -->
            <p><strong>Cause :</strong> {{ $blocage->cause ?? 'Cause inconnue' }}</p>

            <!-- Justification -->
            <p><strong>Justification :</strong> 
                {{ $blocage->justification ?? 'Aucune justification fournie.' }}
            </p>

            <!-- Commentaire -->
            <p><strong>Commentaire :</strong> 
                {{ $blocage->comment ?? 'Aucun commentaire fourni.' }}
            </p>

            <!-- Statut -->
            <p>
                <strong>Statut :</strong>
                <span class="badge {{ $blocage->resolue ? 'bg-success' : 'bg-danger' }}">
                    {{ $blocage->resolue ? 'Résolu' : 'Non résolu' }}
                </span>
            </p>

            <!-- Pièces jointes -->
            @if ($blocage->pictures && $blocage->pictures->isNotEmpty())
            <div class="row justify-content-center g-3">
                @foreach ($blocage->pictures as $index => $picture)
                    <div class="col-12 d-flex justify-content-center">
                        <div class="card shadow-sm w-100">
                            <img src="{{ asset('storage/' . $picture->attachement) }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 alt="{{ $picture->description ?? 'Pièce jointe' }}" 
                                 style="max-height: 400px; object-fit: cover;" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#pictureModal{{ $index }}">
                            <div class="card-body text-center p-3">
                                <p class="small text-muted mb-0"><strong>Description :</strong> 
                                    {{ $picture->description ?? 'Aucune description disponible.' }}
                                </p>
                            </div>
                        </div>
                    </div>
        
                    <!-- Modal -->
                    <div class="modal fade" id="pictureModal{{ $index }}" tabindex="-1" aria-labelledby="pictureModalLabel{{ $index }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pictureModalLabel{{ $index }}">Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $picture->attachement) }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $picture->description ?? 'Pièce jointe' }}">
                                    <p class="small text-muted mt-3">
                                        {{ $picture->description ?? 'Aucune description disponible.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center">
    {{-- <h3>Blocages</h3> --}}
    <p>Il n'y a pas de blocages</p>
</div>
@endif




                </div>
            </div>
        </div>
    </div>

</div>


</div>
<style>
    .modal-body img {
    max-width: 100%;
    height: auto;
}

</style>
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
