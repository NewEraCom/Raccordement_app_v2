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
                <a href="{{ route('sav.clientsav') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-envelope-add widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Total SAV du jour">Total client SAV</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['Sav_Client'] }}</h3>
                    </div>
                </a>
            </div>
        </div>





        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('sav.clientsav') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-envelope-add widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Total Demande du jour">Total Blocage</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['Total_Down'] }}</h3>
                    </div>
                </a>
            </div>
        </div>



        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('sav.savaffectation') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-link-alt widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Affectations">Affectations Techniciens</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['Ticket_technicien'] }}</h3>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('sav.savaffectation') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-link-alt widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Affectations">Affectations Sous Traitant</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['Ticket_soustraitant'] }}</h3>
                    </div>
                </a>
            </div>
        </div>


        
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('sav.savaffectation') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-times-circle widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Blocages du jour">Blocages du jour</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['total_blocages_for_today'] }}</h3>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-6 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('sav.savaffectation') }}">
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
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
            <div class="card widget-flat">
                <a href="{{ route('sav.clientsav') }}">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-check-circle widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Validations">Clients Connectés</h5>
                        <h3 class="mt-3 mb-1">{{ $kpisData['Client_Connecté'] }}</h3>
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
                <h4 class="fw-bold">Blocage par type</h4>
            </div>
            <div class="card-body mb-2">
                {!! $chart2->container() !!}
            </div>
        </div>
    </div>
</div>

 {{-- <div class="col-12 col-xl-12 col-xxl-6">
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
           
        </div> --}}

        @push('scripts')
            <script src="{{ $chart->cdn() }}"></script>
            {{ $chart->script() }}
            <script src="{{ $chart2->cdn() }}"></script>
            {{ $chart2->script() }}
            
        @endpush
</div>
