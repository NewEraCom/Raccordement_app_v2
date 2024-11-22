<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Logs</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex">
                    <h5 class="text-muted fw-bold d-none d-sm-none d-md-none d-lg-none d-xl-inline d-xxl-inline">
                        Filtrage</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput"
                                    placeholder="Ex : Ville Ou Technicien" wire:model="text" />
                                <label for="floatingInput">Ville Ou Technicien</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-3 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="soustraitant_id">
                                    <option value="" selected>Tous</option>
                                    @foreach ($soustraitants as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Soustraitant</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-4 col-xxl-2 mb-1">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" wire:model="status">
                                    <option value="" selected>Tous</option>
                                    <option value="NaN">0</option>
                                    <option value="1">1 ou plus</option>
                                    <option value="500">GPS</option>
                                </select>
                                <label for="floatingSelect">Status</label>
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
            <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <table class="table table-centered table-responsive mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Technicien</th>
                                    <th class="text-center">Position GPS</th>
                                    <th class="text-center">Nombre d'affectation</th>
                                    <th class="text-center">Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $item)
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">{{ $item->technicien->user->getFullname() }}</h5>
                                        <span class="text-muted font-13">{{ $item->technicien->soustraitant->name }}
                                            <small>(
                                                @foreach($item->technicien->cities as $var)
                                                {{ $var->name }}
                                                @if(!$loop->last)
                                                ,
                                                @endif
                                                @endforeach
                                                )
                                            </small>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="https://www.google.com/maps/search/{{ $item->lat }}+{{ $item->lng }}+maps?sa=X&ved=2ahUKEwii3tm65Iv_AhWM7rsIHfuFD3gQ8gF6BAgIEAI"
                                            target="_blank">
                                            <i class="uil-map-pin-alt me-2"></i>
                                            {{ number_format($item->lat,6).' |
                                            '.number_format($item->lng,6) }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $item->nb_affectation == 500 ? 'GPS' :
                                        $item->nb_affectation }}
                                    </td>
                                    <td class="text-center">{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun Log trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 m-2">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>