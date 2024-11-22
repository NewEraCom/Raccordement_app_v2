<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Rapports</h4>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Right Sidebar -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="app-search">
                        <form>
                            <div class="mb-2 position-relative">
                                <input type="text" class="form-control" placeholder="SIP, Nom de client & ville"
                                    wire:model='search'>
                                <span class="mdi mdi-magnify search-icon"></span>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Client</th>
                                    <th class="border-0 text-center">SIP</th>
                                    <th class="border-0 text-center">Ville</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-center">Date de creation</th>
                                    <th class="border-0 text-end" style="width: 80px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $item)
                                <tr>
                                    <td>
                                        <p class="mb-0">{{ $item->name }}</p>
                                        <span class="font-12">{{ $item->returnPhoneNumber() }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->sip }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->city->name }}
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ $item->phase_two == 0 ? 'warning' : 'success' }}-lighten rounded-pill p-2">{{
                                            $item->phase_two == 0 ? 'En attente' : 'Valide' }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->created_at->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('controller.clients.profile',$item) }}" target="_blank"
                                            class="btn btn-primary btn-sm shadow-none"> <i class="uil-eye"> </i> </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <p class="mb-0">Aucun client trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card-body -->
                <div class="clearfix"></div>
            </div> <!-- end card-box -->
        </div> <!-- end Col -->
    </div><!-- End row -->



</div>