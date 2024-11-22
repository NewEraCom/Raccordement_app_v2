<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Techniciens</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations du jour">Total Techniciens</h5>
                    <h3 class="mt-3 mb-1">12</h3>
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

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Amine Bachiri" wire:model="filtrage_name" />
                                <label for="floatingInput">Nom de technicien</label>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-xl-4">
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


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-centered table-responsive mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Technicien</th>
                                <th class="text-center">Affectation</th>
                                <th class="text-center">Declaration</th>
                                <th class="text-center">Blocage</th>
                                <th class="text-center">Créé à</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($techniciens as $item)
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">{{ $item->user->getFullname() }}
                                            {!! $item->user->status
                                                ? '<i class="uil-check-circle text-success font-16"></i>'
                                                : '<i class="uil-times-circle text-danger font-16"></i>' !!} </h5>
                                        <span class="text-muted font-13">{{ $item->city->name }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-warning-lighten rounded-pill p-2 font-12">{{ $item->affectations_count }}
                                            Affectation</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-success-lighten rounded-pill p-2 font-12">{{ $item->declarations_count }}
                                            Declaration</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-danger-lighten rounded-pill p-2 font-12">{{ $item->blocages_count }}
                                            Blocage</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->created_at->format('d-m-Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Aucun technicien trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $techniciens->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
