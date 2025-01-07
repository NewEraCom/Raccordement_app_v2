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
                    <h3 class="mt-3 mb-1">{{ $kpis['totalTickets'] }}</h3>

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
                    <h3 class="mt-3 mb-1">{{ $kpis['totalConnecté'] }}</h3>
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
                    <h3 class="mt-3 mb-1">{{ $kpis['totalBlockages'] }}</h3>
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
                    <h3 class="mt-3 mb-1">{{ $kpis['clientsPlanned'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="d-flex justify-content-between">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput"
                                        placeholder="Ex : Ville, Téléphone,SIP, " wire:model="searchTerm" />
                                    <label for="floatingInput">Rechercher par ID Case, Ville, Nom Client ou SIP</label>
                                </div>
                            </div>
                        <div>
                            <h4 class="header-title">Tickets Assignés</h4>
                        </div>
                        
                    </div>
                         
                       
                        <!-- Add more elements here if needed -->
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-centered table-nowrap mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">ID Case</th>
                                    <th class="text-center">Client</th>
                                    <th class="text-center">Sip</th>
                                    <th class="text-center">Activités de service</th>
                                    <th class="text-center">Adresse</th>
                                    <th class="text-center">Soustraitant</th>
                                    <th class="text-center">Accès réseau</th>
                                    <th class="text-center">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $ticket->client->n_case ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $ticket->client->client_name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $ticket->client->sip ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $ticket->service_activity ?? '-' }}</td>
                                        <td class="text-center">{{ $ticket->client->address ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $ticket->sousTraitant->name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $ticket->client->login ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $ticket->getStatusColor() }}">
                                                {{ $ticket->status }}
                                            </span>
                                        </td>
                                        {{--   <td>
                                          <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary btn-sm">
                                                Voir
                                            </a> 
                                        </td>--}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Aucun ticket trouvé pour ce technicien.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $tickets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

