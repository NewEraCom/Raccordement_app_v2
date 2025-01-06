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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Tickets Assignés</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Sip</th>
                                    <th>Activités de service</th>
                                    <th>Adresse</th>
                                    <th>Soustraitant</th>
                                    <th>Accès réseau</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ticket->client->client_name ?? 'N/A' }}</td>
                                        <td>{{ $ticket->client->sip ?? 'N/A' }}</td>
                                        <td>{{ $ticket->service_activity ?? '-' }}</td>
                                        <td>{{ $ticket->client->address ?? 'N/A' }}</td>
                                        <td>{{ $ticket->sousTraitant->name ?? 'N/A' }}</td>
                                        <td>{{ $ticket->client->login}}</td>
                                        <td>
                                            <span class="badge bg-{{ $ticket->getStatusColor() }}">
                                                {{ $ticket->status }}
                                            </span>
                                        </td>
                                        <td>
                                            {{-- <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary btn-sm">
                                                Voir
                                            </a> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Aucun ticket trouvé pour ce technicien.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

