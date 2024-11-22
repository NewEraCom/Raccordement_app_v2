<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard ({{ $soustraitant->name }})</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-constructor widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Technicines">Techniciens</h5>
                    <h3 class="mt-3 mb-1">{{ $techniciens->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-link-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations Du jour">Affectations Du jour</h5>
                    <h3 class="mt-3 mb-1">{{ $daily_affectations }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-link-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations Du Mois">Affectations Du Mois</h5>
                    <h3 class="mt-3 mb-1">{{ $affectations }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-clock widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="RDV du jour">RDV du jour</h5>
                    <h3 class="mt-3 mb-1">{{ $daily_rdv_clients }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-check-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Terminé du jour">Client Terminé du jour</h5>
                    <h3 class="mt-3 mb-1">{{ $total_client_done }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Blocages du jour">Blocages du jour</h5>
                    <h3 class="mt-3 mb-1">{{ $daily_blocages_clients }}</h3>
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
                                <th class="text-center">Status</thc>
                                <th class="text-center">Affectation</th>
                                <th class="text-center">Client Terminé</th>
                                <th class="text-center">Blocage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($techniciens as $item)
                            <tr>
                                <td>
                                    <h5 class="font-14 my-1">{{ $item->user->getFullname() }}</h5>
                                    <span class="text-muted font-13">
                                        @foreach($item->cities as $city)
                                        {{ $city->name }}
                                        @if(!$loop->last)
                                        ,
                                        @endif
                                        @endforeach
                                    </span>
                                </td>
                                <td class="text-center">
                                    {!! $item->user->device_key
                                    ? '<i class="uil-check-circle text-success font-16"></i> Appareil connecté'
                                    : '<i class="uil-times-circle text-danger font-16"></i> Appareil déconnecté' !!}
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-warning-lighten rounded-pill p-2 font-12">{{
                                        $item->affectations_count }}
                                        Affectation</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success-lighten rounded-pill p-2 font-12">{{
                                        $item->declarations_count }}
                                        Client</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-danger-lighten rounded-pill p-2 font-12">{{
                                        $item->blocages_count }}
                                        Blocage</span>
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

                </div>
            </div>
        </div>
    </div>

</div>