<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Plaque : {{ $plaque->code_plaque }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-map-pin-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Ville">Ville</h5>
                    <h3 class="mt-3 mb-1">{{ $plaque->city->name }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="uil-users-alt widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-bold mt-0" title="Techniciens">Techniciens</h5>
                    <h3 class="mt-3 mb-1">{{ $plaque->techniciens->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <a href="{{ route('admin.clients') }}?plaque={{ $plaque->id }}" class="text-decoration-none">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="uil-users-alt widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-bold mt-0" title="Clients">Clients</h5>
                        <h3 class="mt-3 mb-1">{{ $plaque->clients->count() }}</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div id="map" style="height:550px"></div>
        </div>
    </div>
    <style>
    .card.widget-flat:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
</style>

    @push('scripts')
        <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>
        <script>
            let map, markers = [];
            /* ----------------------------- Initialize Map ----------------------------- */
            function initMap() {
                map = L.map('map', {
                    center: {
                        lat: 33.954993,
                        lng: -6.873693,
                    },
                    zoom: 14
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© Neweraconnect'
                }).addTo(map);

                var marker = L.marker([33.954993, -6.873693]).addTo(map);

                map.on('click', mapClicked);
                initMarkers();
            }
            initMap();
        </script>
    @endpush

</div>
