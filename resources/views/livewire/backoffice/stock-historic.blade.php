<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Historique de stock</h4>
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
                            <h5 class="text-muted fw-bold mt-0" title="Routeur">Routeur</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['routeur'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Cable Outdoor">Cable Outdoor</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['cable_outdoor'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Cable Indoor">Cable Indoor</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['cable_indoor'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Splitter">Splitter</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['splitter'] }}</h3>
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
                            <h3 class="mt-3 mb-1 text-primary">{{ $stock['jarretier'] }}</h3>
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
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
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
                                <th class="text-center">PTO</th>
                                <th class="text-center">Routeur</th>
                                <th class="text-center">Jarrtier</th>
                                <th class="text-center">Splitter</th>
                                <th class="text-center">Cable Outdoor</th>
                                <th class="text-center">Cable Indoor</th>
                                <th class="text-center">Telephone Fix</th>
                                <th class="text-center">Dernier Mise a jour</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stockHistoric as $item)
                                <tr>
                                    <td class="text-center">{{ $item->pto }}</td>
                                    <td class="text-center">{{ $item->routeur }}</td>
                                    <td class="text-center">{{ $item->jarretier }}</td>
                                    <td class="text-center">{{ $item->splitter }}</td>
                                    <td class="text-center">{{ $item->cable_outdoor }}</td>
                                    <td class="text-center">{{ $item->cable_indoor }}</td>
                                    <td class="text-center">{{ $item->fix }}</td>
                                    <td class="text-center">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="9"> Aucun Historique trouve </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
