<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Stock</h4>
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
                            <h3 class="mt-3 mb-1 text-primary">{{ $stockCount->pto }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Routeur F680">Routeur F680</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stockCount->f680 }}</h3>
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
                            <h3 class="mt-3 mb-1 text-primary">{{ $stockCount->f6600 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Jarretiere">Jarretiere</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stockCount->jarretiere }}</h3>
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
                            <h3 class="mt-3 mb-1 text-primary">{{ $stockCount->cable }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="uil-check-circle widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-bold mt-0" title="Fix">Fix</h5>
                            <h3 class="mt-3 mb-1 text-primary">{{ $stockCount->fix }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Historique de demande</h4>
        </div>
        <div class="card-body p-0">
            <div class="row">
                <div class="col-12">
                    <table class="table table-centered table-responsive mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">PTO</th>
                                <th class="text-center">Routeur F680</th>
                                <th class="text-center">Routeur F6600</th>
                                <th class="text-center">Jarretiere</th>
                                <th class="text-center">Splitter</th>
                                <th class="text-center">Cable</th>
                                <th class="text-center">Telephone Fix</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date de Validation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($soustraitantStockDemand as $item)
                                <tr>
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
                                        {{ $item->validate_date ? $item->validate_date->format('d-m-Y H:i') : '-'  }}
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
