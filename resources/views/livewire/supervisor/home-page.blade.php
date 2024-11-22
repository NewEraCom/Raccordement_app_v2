<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard ({{ $this->date }})</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-envelope-add widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Récu / Mois">Client Récu / Mois</h5>
                    <h3 class="mt-3 mb-1">{{ $data['monthlyClient'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Réalisation du mois">Réalisation du mois</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientDone'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-chart-line widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Taux du chut">Taux du chut</h5>
                    <h3 class="mt-3 mb-1">{{ $data['chut'] }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Resultat Jour ({{ $this->end_date }})</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-refresh widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Pipe">Pipe</h5>
                    <h3 class="mt-3 mb-1">{{ $pipe ? $pipe->total : 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Récu">Client Récu</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientOfTheDay'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-check-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Taux du chut">Client Réalise</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientDoneOfTheDay'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-clock widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="RDV">RDV</h5>
                    <h3 class="mt-3 mb-1">{{ $data['clientPlanifier'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Problème technique">Problème technique</h5>
                    <h3 class="mt-3 mb-1">{{ $data['prTech'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-times-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Problème client">Problème client</h5>
                    <h3 class="mt-3 mb-1">{{ $data['prClient'] }}</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ $chart->cdn() }}"></script>
        {{ $chart->script() }}
    @endpush
</div>
