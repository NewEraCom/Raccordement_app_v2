<div class="container-fluid">
<div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Position des Techniciens</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 ">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-bolt-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Affectations En cours">Total Techniciens</h5>
                    <h3 class="mt-3 mb-1">{{ $technicien_count }} </h3>
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
                        <div class="col-xl-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Amine Bachiri" wire:model="search" />
                                <label for="floatingInput">Recherche Techniciens...</label>
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
                            <th>Technicien</th>
                            <th class="text-center">Action</th>
                            <th class="text-center">Position</th>
                            <th class="text-center">Date de creation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($techniciens as $item)
                            <tr>                                
                                <td>{{ $item->technicien->user->first_name .' '. $item->technicien->user->last_name }}</td>
                                <td class="text-center">{{ $item->action }}</td>
                                <td class="text-center">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $item->lat }},{{ $item->lng }}" target="_blank" class="btn btn-primary">
                                        Ouvrir dans Maps
                                    </a>
                                </td>
                                <td class="text-center">{{ $item->created_at }}</td>
                                                          
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <h5>Aucun Technicien trouvé</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $techniciens->links() }}
            </div>
        </div>
    </div>
</div>