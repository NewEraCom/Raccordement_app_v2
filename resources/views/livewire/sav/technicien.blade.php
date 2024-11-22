<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">{{ $technicien->user->getFullname() }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <div class="badge-primary-lighten rounded p-2">
                            <img src="{{ asset('assets/images/green-icon.png') }}" height="24" alt="" srcset="">
                        </div>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total d'affectations">Total des Tickets</h5>

            </div>
        </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <div class="badge-primary-lighten rounded p-2">
                            <img src="{{ asset('assets/images/blue-icon.png') }}" height="24" alt="" srcset="">
                        </div>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total connexion">Total connexion</h5>
                    <h3 class="mt-3 mb-1"></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <div class="badge-primary-lighten rounded p-2">
                            <img src="{{ asset('assets/images/red-icon.png') }}" height="24" alt="" srcset="">
                        </div>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Total Blocage">Total Blocage</h5>
                    <h3 class="mt-3 mb-1"></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <div class="badge-primary-lighten rounded p-2">
                            <img src="{{ asset('assets/images/orange-icon.png') }}" height="24" alt="" srcset="">
                        </div>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Planifié">Clients Planifié</h5>
                    <h3 class="mt-3 mb-1"></h3>
                </div>
            </div>
        </div>
    </div>

