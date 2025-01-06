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
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Login internet</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->client_id }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Nom du client</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->client_name }}">
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
                    {{-- <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Type</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->type }}">
                        </div>
                    </div> --}}
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Type Probleme</label>
                        <div class="col-7">
                            <p>{{ $client->type  }}</p>
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Commentaire</label>
                        <div class="col-7">
                            <p>{{ $client->description }}</p>
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
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
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Date de création</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->created_at->format('d-m-Y H:i:s') }}">
                        </div>
                    </div>
                    <div class="row mb-2 align-middle">
                        <label for="inputEmail3" class="col-5 col-form-label fw-bold">Rapport telecharger</label>
                        <div class="col-7">
                            <input type="text" readonly class="form-control-plaintext" id="example-static"
                                value="{{ $client->updated_at->format('d-m-Y H:i:s') }}">
                        </div>
                    </div>
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

                        @forelse ( $client->savTickets->last()->savhistories ?? [] as $item)
                        <div class="timeline-item">
                            <i class="bg-{{ $item->getStatusSavColor($item->status) }}-lighten text-{{ $item->getStatusSavColor($item->status) }} ri-bookmark-fill timeline-icon"></i>
                            <div class="timeline-item-info">
                                <h5 class="mt-0 mb-1">{{ $item->status }}
                                    <h6>
                                        {{ $item->description }}
                                    </h6>
                                </h5>
                                <p>
                                    Sous-traitant: {{ optional($item->soustraitant)->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    @empty
                            <div class="text-center">
                                <h1><i class="uil-times-circle"></i></h1>
                                <h4>Il n'y a pas encore d'affectations.</h4>
                            </div>
                        @endforelse
                    </div> 
                    <h4 class="header-title bg-light p-2 mt-2 mb-3"> <i class="uil-file me-2"></i> Rapports</h4>
                    <br>

                    <div class="timeline-alt">

                        @forelse ($client->savTickets->last()->feedback ?? [] as $item)
                            <div class="timeline-item">
                                <i
                                    class="bg-{{ $item->getStatusSavColor($item->type) }}-lighten text-{{ $item->getStatusSavColor($item->status) }} ri-bookmark-fill timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <h5 class="mt-0 mb-1">{{ $item->type }}
                                        <h6>
                                            {{ $item->description }}
                                        </h6>
                                    </h5>

                                    @if ($item->test_signal != null)
                                        <div class="text-center">
                                            <img src="data:image/png;base64,{{ $item->test_signal }}" width="320"
                                                height="220">
                                        </div>
                                    @else
                                        @if ($item->image_facultatif != null)
                                            <h6>
                                                {{ $item->type_blockage }}
                                            </h6>

                                            <div class="text-center">
                                                <img src="data:image/png;base64,{{ $item->image_facultatif }}"
                                                    width="320" height="220">
                                            </div>
                                        @endif
                                    @endif

                                </div>
                            </div>
                        @empty
                            <div class="text-center">
                                <h1><i class="uil-times-circle"></i></h1>
                                <h4>Il n'y a pas encore de Feedback.</h4>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


</div>
