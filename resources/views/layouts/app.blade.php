<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Neweraconnect - {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Ayoub chahid - Hamza El Jaouani - Mourad Arejdal" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/NEWERACONNECT.png') }}">
    @stack('styles')

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/hyper-config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' />
    @livewireStyles
</head>

<body>
    

    <!-- Begin page -->
    <div class="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-lg-2 gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="{{ route('admin.dashboard') }}" class="logo-light">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/NEWERACONNECT_LOGO.png') }}"
                                    style="height:40px !important" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="{{ route('admin.dashboard') }}" class="logo-dark">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/NEWERACONNECT_LOGO.png') }}"
                                    style="height:40px !important" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-dark-sm.png') }}" height="120px"
                                    alt="small logo">
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="button-toggle-menu">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">

                    <li class="d-none d-sm-inline-block">
                        <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Theme Mode">
                            <i class="ri-moon-line font-22"></i>
                        </div>
                    </li>


                    <li class="d-none d-md-inline-block">
                        <a class="nav-link" href="" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line font-22"></i>
                        </a>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="{{ asset('assets/images/users/' . Auth::user()->profile_picture) }}"
                                    alt="user-image" width="32" class="rounded-circle">
                            </span>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <h5 class="my-0">{{ Auth::user()->getFullname() }}</h5>
                                <h6 class="my-0 fw-normal">{{ Auth::user()->getUserRole() }}</h6>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Bienvenu !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="uil-user me-1"></i>
                                <span>Profil</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('logout') }}" class="dropdown-item">
                                <i class="uil-exit me-1"></i>
                                <span>Se deconnecter</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Topbar End -->

        <!-- Left Sidebar Start -->
        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/NEWERACONNECT_LOGO.png') }}" style="height:50px !important"
                        alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo-sm.png') }}" style="height:30px !important"
                        alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/NEWERACONNECT_LOGO.png') }}" style="height:50px !important"
                        alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo-dark-sm.png') }}" style="height:30px !important"
                        alt="small logo">
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right"
                title="Show Full Sidebar">
                <i class="ri-checkbox-blank-circle-line align-middle"></i>
            </div>

            <!-- Full Sidebar Menu Close Button -->
            <div class="button-close-fullsidebar">
                <i class="ri-close-fill align-middle"></i>
            </div>

            <!-- Sidebar -left -->
            <div class="h-100" id="leftside-menu-container" data-simplebar>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title">Navigation</li>
                    @role('admin')
                        <li class="side-nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="side-nav-link fw-bold">
                                <i class="uil-home-alt"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.clients') }}" class="side-nav-link fw-bold">
                                <i class="uil-users-alt"></i>
                                <span> Clients </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.affectations') }}" class="side-nav-link fw-bold">
                                <i class="uil-clipboard-alt"></i>
                                <span> Affectations </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('techpos') }}" class="side-nav-link fw-bold">
                                <i class="uil-location-point"></i>
                                <span> Technicien Logs </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.routeurs') }}" class="side-nav-link fw-bold">
                                <i class="uil-technology"></i>
                                <span> Routeurs </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.soustraitant') }}" class="side-nav-link fw-bold">
                                <i class="uil-package"></i>
                                <span> Soustraitant </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.techniciens') }}" class="side-nav-link fw-bold">
                                <i class="uil-constructor"></i>
                                <span> Techniciens </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.cities') }}" class="side-nav-link fw-bold">
                                <i class="uil-map-pin-alt"></i>
                                <span> Villes </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.plaques') }}" class="side-nav-link fw-bold">
                                <i class="uil-label"></i>
                                <span> Plaques </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarStcok" aria-expanded="false"
                                aria-controls="sidebarStcok" class="side-nav-link fw-bold">
                                <i class="uil-clipboard-alt"></i>
                                <span> Stock </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarStcok">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('admin.stock') }}">Stock</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.stock.demande') }}">Demande de stock</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.stock.historic') }}">Historique de stock</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.logs') }}" class="side-nav-link fw-bold">
                                <i class="uil-bookmark"></i>
                                <span> Logs </span>
                            </a>
                        </li>
                    @endrole()

                    @role('sav')
                    <li class="side-nav-item">
                        <a href="{{ route('sav.dashboard') }}" class="side-nav-link fw-bold">
                            <i class="uil-home-alt"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('sav.clientsav') }}" class="side-nav-link fw-bold">
                            <i class="uil-user"></i>
                            <span> Client </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('sav.savaffectation') }}" class="side-nav-link fw-bold">
                            <i class="uil-clipboard-alt"></i>
                            <span> Affectation </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('techpos') }}" class="side-nav-link fw-bold">
                            <i class="uil-location-point"></i>
                            <span> Technicien Logs </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('sav.techniciens') }}" class="side-nav-link fw-bold">
                            <i class="uil-constructor"></i>
                            <span> Technicien </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('sav.soustraitant') }}" class="side-nav-link fw-bold">
                            <i class="uil-package"></i>
                            <span> Sous-traitants </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('sav.stock') }}" class="side-nav-link fw-bold">
                            <i class="uil-box"></i>
                            <span> Stock </span>
                        </a>
                    </li>
                @endrole

                    @role('supervisor')
                        <li class="side-nav-item">
                            <a href="{{ route('supervisor.dashboard') }}" class="side-nav-link fw-bold">
                                <i class="uil-home-alt"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('supervisor.clients') }}" class="side-nav-link fw-bold">
                                <i class="uil-users-alt"></i>
                                <span> Clients </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('supervisor.soustraitant') }}" class="side-nav-link fw-bold">
                                <i class="uil-package"></i>
                                <span> Soustraitant </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('supervisor.cities') }}" class="side-nav-link fw-bold">
                                <i class="uil-map-pin-alt"></i>
                                <span> Villes </span>
                            </a>
                        </li>


                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarStcok" aria-expanded="false"
                                aria-controls="sidebarStcok" class="side-nav-link fw-bold">
                                <i class="uil-clipboard-alt"></i>
                                <span> Stock </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarStcok">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('supervisor.stock') }}">Stock</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('supervisor.stock.demande') }}">Demande de stock</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('supervisor.stock.historic') }}">Historique de stock</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endrole

                    @role('controller')
                        <li class="side-nav-item">
                            <a href="{{ route('controller.dashboard') }}" class="side-nav-link fw-bold">
                                <i class="uil-home-alt"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('controller.affectations') }}" class="side-nav-link fw-bold">
                                <i class="uil-users-alt"></i>
                                <span> Clients </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('controller.planification') }}" class="side-nav-link fw-bold">
                                <i class="uil-calendar-alt"></i>
                                <span> Planification </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('controller.reports') }}" class="side-nav-link fw-bold">
                                <i class="uil-file-question-alt"></i>
                                <span> Rapports </span>
                            </a>
                        </li>
                    @endrole

                    @role('soustraitant')
                        <li class="side-nav-item">
                            <a href="{{ route('soustraitant.dashboard') }}" class="side-nav-link fw-bold">
                                <i class="uil-home-alt"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('soustraitant.affectations') }}" class="side-nav-link fw-bold">
                                <i class="uil-users-alt"></i>
                                <span> Clients </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('soustraitant.stock') }}" class="side-nav-link fw-bold">
                                <i class="uil-clipboard-alt"></i>
                                <span> Stock </span>
                            </a>
                        </li>
                    @endrole

                    @role('responsable')
                        <li class="side-nav-item">
                            <a href="{{ route('admin.clients.controle') }}" class="side-nav-link fw-bold">
                                <i class="uil-bolt"></i>
                                <span> Controle Qualité </span>
                            </a>
                        </li> 
                        <li class="side-nav-item">
                            <a href="{{ route('admin.clients.reports') }}" class="side-nav-link fw-bold">
                                <i class="uil-folder"></i>
                                <span> Rapports </span>
                            </a>
                        </li>                
                    @endrole

                    @role('storekeeper')
                        <li class="side-nav-item">
                            <a href="{{ route('storekeeper.dashboard') }}" class="side-nav-link fw-bold">
                                <i class="uil-home-alt"></i>
                                <span> Dashboard </span>
                            </a>
                        </li> 

                        <li class="side-nav-item">
                            <a href="{{ route('storekeeper.demandes') }}" class="side-nav-link fw-bold">
                                <i class="uil-fast-mail"></i>
                                <span> Demandes </span>
                            </a>
                        </li> 

                        <li class="side-nav-item">
                            <a href="{{ route('storekeeper.stock') }}" class="side-nav-link fw-bold">
                                <i class="uil-clipboard-alt"></i>
                                <span> Stock </span>
                            </a>
                        </li>             
                    @endrole

                    @role('sales')
                        <li class="side-nav-item">
                            <a href="{{ route('sales.dashboard') }}" class="side-nav-link fw-bold">
                                <i class="uil-home-alt"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>             
                    @endrole
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        <!--  Left Sidebar End  -->

        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">
                {{ $slot }}
                <div wire:offline>
                    You are now offline.
                </div>
            </div>
        </div>
    </div>
    <!-- END wrapper -->

    @stack('scripts')
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "9d7161b3-0c5e-4dd0-93fa-67e6b57fe2dd",
            });
        });
    </script>
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.livewire.on('success', () => {
            $('#add-modal').modal('hide');
            $('#deblocage-modal').modal('hide');
            $('#relance-modal').modal('hide');
            $('#edit-modal').modal('hide');
            $('#associer-modal').modal('hide');
            $('#refresh-modal').modal('hide');
            $('#desactive-modal').modal('hide');
            $('#delete-all-modal').modal('hide');
            $('#delete-modal').modal('hide');
            $('#exportation-modal').modal('hide');
            $('#affecter-modal').modal('hide');
            $('#sync-modal').modal('hide');
            $('#planifier-modal').modal('hide');
            $('#feedback-modal').modal('hide');
            $('#planifier-modal').modal('hide');
            $('#feedback-modal').modal('hide');
            $('#valider-modal').modal('hide');
            $('#refuser-modal').modal('hide');
            $('#get-localisation-modal').modal('hide');
            $('#livre-modal').modal('hide');
        });
        window.addEventListener('contentChanged', e => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 15000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: event.detail.item === 'Une erreur est survenue.' ? 'error' : 'success',
                title: event.detail.item,
            })
        })
        
    </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>


    

</body>

</html>
