<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Routeur F680">Routeur F680</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['f680'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Routeur F6600">Routeur F6600</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['f6600'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="PTO">PTO</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['pto'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Cable">Cable</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['cable'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Telephone Fix">Telephone Fix</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['fix'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Jarretier">Jarretier</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['jarretiere'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold">Filtrage</h5>
                    <div class="ms-auto">
                        @role('admin')
                            <button class="btn btn-primary btn-sm shadow-none" data-bs-toggle="modal"
                                data-bs-target="#add-modal">
                                <i class="uil-plus me-2"></i> Demande de stock
                            </button>
                        @endrole
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="soustraitant_id">
                                    <option value="" selected>Tous</option>
                                    @foreach ($soustraitants as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Soustraitant</label>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="status">
                                    <option value="" selected>Tous</option>
                                    <option value="0">En cours</option>
                                    <option value="1">Validé</option>
                                </select>
                                <label for="floatingSelect">Statut de demande</label>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-xl-3">
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
                                <th>Soustraitant</th>
                                <th class="text-center">Routeur F680</th>
                                <th class="text-center">Routeur F6600</th>
                                <th class="text-center">PTO</th>
                                <th class="text-center">Jarretiere</th>
                                <th class="text-center">Cable</th>
                                <th class="text-center">Telephone Fix</th>
                                <th class="text-center">Splitter</th>
                                <th class="text-center">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($demandes as $item)
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">{{ $item->soustraitant->name }}</h5>
                                        <span class="text-muted font-13">Demande le :
                                            {{ $item->created_at->format('d-m-Y H:i') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-primary-lighten fw-bold font-13 ps-4 pe-4 p-2 rounded-pill">{{ $item->f680 }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-primary-lighten fw-bold font-13 ps-4 pe-4 p-2 rounded-pill">{{ $item->f6600 }}</span>
                                    </td>

                                    <td class="text-center">
                                        <span
                                            class="badge badge-primary-lighten fw-bold font-13 ps-4 pe-4 p-2 rounded-pill">{{ $item->pto }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-primary-lighten fw-bold font-13 ps-4 pe-4 p-2 rounded-pill">{{ $item->jarretiere }}</span>
                                    </td>

                                    <td class="text-center">
                                        <span
                                            class="badge badge-primary-lighten fw-bold font-13 ps-4 pe-4 p-2 rounded-pill">{{ $item->cable }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-primary-lighten fw-bold font-13 ps-4 pe-4 p-2 rounded-pill">{{ $item->fix }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-primary-lighten fw-bold font-13 ps-4 pe-4 p-2 rounded-pill">{{ $item->splitter }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge font-12 fw-bold p-2 badge-{{ $item->status ? 'success' : 'warning' }}-lighten">{{ $item->status ? 'Validé' : 'En cours' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @role('admin')
                                            @if (!$item->status)
                                                <button class="btn btn-warning btn-sm shadow-none"
                                                    wire:click='setDemande({{ $item }})' data-bs-toggle="modal"
                                                    data-bs-target="#edit-modal">
                                                    <i class="uil-edit"></i>
                                                </button>                                           
                                            @endif
                                        @endrole
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-3">Aucune demande</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <div class="py-3 px-4">
                        {{ $demandes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>