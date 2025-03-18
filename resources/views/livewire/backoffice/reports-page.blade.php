

<div class="container-fluid">   

   

    
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Récu">Rapport Blocage</h5>
                    <h3 class="mt-3 mb-1">{{$data->total()}}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-check-circle widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Client Réalise">Rapport Declaration</h5>
                    <h3 class="mt-3 mb-1">{{$declarations->total()}}</h3>
                </div>
            </div>
        </div>
        
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex">
        <h5 class="text-muted fw-bold d-none d-sm-none d-md-none d-lg-none d-xl-inline d-xxl-inline">
                        Rapport Blockage</h5>
                    <div class="ms-auto">
                        <div class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline d-xxl-inline">
                        @if(count($selectedItems) > 0)
                        <button wire:click="downloadSelectedReports" class="btn btn-primary">
                            <i class="uil-download-alt"></i> Télécharger les rapports sélectionnés ({{ count($selectedItems) }})
                        </button>
                        @endif    
                        </div>
                        
                    </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-4 mb-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput"
                                            placeholder="Ex : Nom, Ville, Téléphone, SIP Ou Code Plaque " wire:model="search_term" />
                                        <label for="floatingInput">Rechercher par nom ou note</label>
                                    </div>
                                </div>
                                
                                
                                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-2 mb-1">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="floatingInput" placeholder=""
                                            wire:model="start_date" />
                                        <label for="floatingInput">Du</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-2 mb-1">
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
            <div class="table-responsive">
                <table class="table table-hover table-centered table-nowrap mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th ></th>
                            <th class="text-start">Client</th>
                            <th class="text-start">Technicien</th>
                            <th class="text-center">Cause</th>
                            <th class="text-center">Justification</th>
                            <th class="text-center">Créer á</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input" value="{{ $item->id }}"
                                    wire:model="selectedItems">
                            </td>
                            <td>
                                <h5 class="font-14 my-1">{{ $item->affectation->client->name }}</h5>
                                <span class="text-muted font-13">{{ $item->affectation->client->returnPhoneNumber() }} <small
                                        class="badge bg-info">{{ $item->affectation->client->offre }}</small> </span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1">{{ $item->affectation->technicien->user->getFullname() }}</h5>
                                <span class="text-muted font-13">({{ $item->affectation->technicien->soustraitant->name }}) </span>
                            </td>
                            <td class="text-center">
                                {{$item->cause}}
                            </td>
                            <td class="text-center">
                                {{$item->justification ?? '-'}}
                            </td>
                            <td class="text-center">
                                {{$item->created_at}}
                            </td>
                            

                            
                            
                            
                            <td class="text-end">
                                <a class="btn btn-primary btn-sm shadow-none" target="_blank"
                                href="{{ route('admin.client.blocage.report', $item) }}"><i class="uil-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <h5>Aucun Rapport trouvé</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $data->links() }}
            </div>
        </div>
        
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex">
        <h5 class="text-muted fw-bold d-none d-sm-none d-md-none d-lg-none d-xl-inline d-xxl-inline">
                        Rapport Declarations</h5>
                    <div class="ms-auto">
                        <div class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline d-xxl-inline">
                        @if(count($selectedItems_dec) > 0)
                        <button wire:click="downloadSelectedReportsDec" class="btn btn-primary">
                            <i class="uil-download-alt"></i> Télécharger les rapports sélectionnés ({{ count($selectedItems_dec) }})
                        </button>
                        @endif    
                        </div>
                        
                    </div>
        </div>
        <div class="card-body">
        <div class="row">
        <div class="col-12">
            
                   
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-4 mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Nom, Ville, Téléphone, SIP Ou Code Plaque " wire:model="search_term_dec" />
                                <label for="floatingInput">Rechercher par nom, gpon ou mac</label>
                            </div>
                        </div>
                        
                        
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="start_date_dec" />
                                <label for="floatingInput">Du</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-6 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="floatingInput" placeholder=""
                                    wire:model="end_date_dec" />
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
            <div class="table-responsive">
                <table class="table table-hover table-centered table-nowrap mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th ></th>
                            <th class="text-start">Client</th>
                            <th class="text-start">Technicien</th>
                            <th class="text-center">Routeur</th>
                            <th class="text-center">Créer á</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($declarations as $item)
                        <tr>
                            <td class="text-center">
                            @if ($item->affectation->client->validations->count() != 0)
                                <input type="checkbox" class="form-check-input" value="{{ $item->id }}"
                                    wire:model="selectedItems_dec">
                            @endif
                            </td>
                            <td>
                                <h5 class="font-14 my-1">{{ $item->affectation->client->name }}</h5>
                                <span class="text-muted font-13">{{ $item->affectation->client->returnPhoneNumber() }} <small
                                        class="badge bg-info">{{ $item->affectation->client->offre }}</small> </span>
                            </td>
                            <td>
                                <h5 class="font-14 my-1">{{ $item->affectation->technicien->user->getFullname() }}</h5>
                                <span class="text-muted font-13">({{ $item->affectation->technicien->soustraitant->name }}) </span>
                            </td>
                            <td class="text-center">
                                Gpon:
                                <span class="text-muted font-13"> {{$item->routeur->sn_gpon}} </span> <br>
                                Mac:
                                <span class="text-muted font-13"> {{$item->routeur->sn_mac}} </span>
                            </td>
                            
                            <td class="text-center">
                                {{$item->created_at}}
                            </td>
                            

                            
                            
                            {{--@role('controller')--}}
                            <td class="text-end">
                                <a class="btn btn-primary btn-sm shadow-none" target="_blank"
                                href="{{ route('controller.client.report', $item) }}"><i class="uil-eye"></i>
                                </a>
                            </td>
                           {{--@endrole --}} 
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <h5>Aucun Rapport trouvé</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $data->links() }}
            </div>
        </div>
        
    </div>

   
    


    


   

</div>