<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('admin.clients') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-envelope-add widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Total Demande du jour">Total Demande du jour</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_new_importations'] }}</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('admin.clients') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-users-alt widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Clients">Clients</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_clients'] }}</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('admin.affectations') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-link-alt widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Affectations">Affectations du jour</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_affectations'] }}</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('admin.affectations') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-link widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Affectations du nouveau client">Affectations du
                            nouveau client</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_affectations_new_client'] }}</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('admin.clients') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-check-circle widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Validations">Validations</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_validations'] }}</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('admin.affectations') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-times-circle widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Blocages du jour">Blocages du jour</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_blocages'] }}</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-6 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('admin.affectations') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-schedule widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Planification du jour">Planification du jour</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_planification_for_today'] }}</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-6 col-xxl-3">
            <div class="card widget-flat">
                <a href="">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-refresh widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Pipe">Pipe</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_pipe'] }}</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold">Clients par ville</h4>
                </div>
                <div class="card-body mb-2">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-12 col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold">Blocage par type ({{ now()->month . '-' . now()->year }}) </h4>
                </div>
                <div class="card-body">
                    {!! $chart2->container() !!}
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="fw-bold">
                                <span>{{ $kpisData['blocage_technique'] }}</span>
                            </h4>
                            <p class="text-muted mb-0 fw-bold">Blocage Technique</p>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-bold">
                                <span>{{ $kpisData['blocage_client'] }}</span>
                            </h4>
                            <p class="text-muted mb-0 fw-bold">Blocage Client</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold">Statistique par soustraitant ({{ now()->month . '-' . now()->year }})</h4>
                </div>
                <div class="card-body">
                    {!! $chart3->container() !!}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ $chart->cdn() }}"></script>
        {{ $chart->script() }}
        <script src="{{ $chart2->cdn() }}"></script>
        {{ $chart2->script() }}
        <script src="{{ $chart3->cdn() }}"></script>
        {{ $chart3->script() }}
    @endpush
</div>
