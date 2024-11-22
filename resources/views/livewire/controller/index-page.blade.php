<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-phone-slash widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients injoignables">Clients injoignables</h5>
                    <h3 class="mt-3 mb-1">{{ $data['injoignable'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-user-exclamation widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients Indisponibles">Clients Indisponibles</h5>
                    <h3 class="mt-3 mb-1">{{ $data['indisponible'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-user-times widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Clients à annuler sa demande">Clients à annuler sa
                        demande</h5>
                    <h3 class="mt-3 mb-1">{{ $data['cancel_client'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title fw-bold">Clients Planifié</h4>
                </div>
                <div class="card-header bg-light-lighten border-top border-bottom border-light py-1 text-center">
                    <p class="m-0"><b>{{ $planification->count() }}</b> Clients Planifié</p>
                </div>
                <div class="card-body pt-2 m-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover m-0">
                            <tbody>
                                @forelse ($planification as $item)
                                <tr>
                                    <td style="width: 120px;">
                                        <h5 class="font-14 my-1">{{ Str::limit($item->address, 35) }}</h5>
                                        <span class="text-muted font-13">{{ $item->name }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Status</span> <br>
                                        <span class="badge badge-{{ $item->getStatusColor() }}-lighten">{{
                                            $item->status }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Affecter à </span>
                                        <h5 class="font-14 mt-1 fw-normal">{{ $item->technicien_id == 97 ? 'Pas encore
                                            affecté' : $item->technicien->user->getFullname() }}</h5>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Planifier pour</span>
                                        <h5 class="font-14 mt-1 fw-normal">{{
                                            $item->affectations->last()->planification_date }}</h5>
                                    </td>
                                    <td class="table-action" style="width: 90px;">
                                        <a class="btn btn-primary btn-sm shadow-none" target="_blank"
                                            href="{{ route('controller.clients.profile', [$item->id]) }}"><i
                                                class="uil-eye"></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                                @empty
                                <tr colspan="5">
                                    <td class="text-center">Aucun client planifié</td>
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