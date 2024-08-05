<!doctype html>
<html lang="en">


<!-- Mirrored from themesbrand.com/lexa/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jun 2024 17:25:05 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Lexa - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <style>
        .modal-right .modal-dialog {
            position: fixed;
            right: 0;
            height: 90%;
            width: 25%;
            margin-top: 2%;
            margin-right: 10px;
        }

        .modal-content {
            height: 100%;
            overflow-y: auto;
        }

        .profile-picture-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }

        .profile-picture-container img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .edit-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #fff;
            border-radius: 50%;
            padding: 5px;
        }

        .edit-icon i {
            font-size: 25px;
            color: #000;
        }
    </style>

</head>


<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="colored"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="/" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="" height="17">
                            </span>
                        </a>

                        <a href="/" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="" height="18">
                            </span>
                        </a>
                    </div>

                    <button type="button"
                        class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <div class="d-none d-sm-block">
                        <div class="dropdown dropdown-topbar pt-3 mt-1 d-inline-block">
                            <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Create <i class="mdi mdi-chevron-down"></i>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Separated link</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex">

                    <!-- App Search -->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" id="search-input" class="form-control" placeholder="Search..."
                                oninput="filterResults()">
                            <span class="fa fa-search"></span>
                            <ul id="search-results" class="list-group position-absolute mt-1 w-100"
                                style="display: none;">
                                <!-- Resultados de búsqueda -->
                            </ul>
                        </div>
                    </form>

                    <script>
                        // Lista de vistas y rutas con organización por menús
                        const menuStructure = {
                            Productos: [
                                { name: 'Agregar Producto', route: '/agregar' },
                                { name: 'Operaciones Producto', route: '/productos' },
                            ],
                            Marca: [
                                { name: 'Agregar Marca', route: '/marca' },
                            ],
                            Usuarios: [
                                { name: 'Usuarios', route: '/usuarios' },
                            ],
                            Accesos: [
                                { name: 'Roles y Accesos', route: '/crear-rol-acceso' },
                                { name: 'Gestionar Roles/Accesos', route: '/gestion-rol-acceso' },
                                { name: 'Asignar Roles', route: '/asignar-rol' },
                            ],
                            Stock: [
                                { name: 'Stock Productos', route: '/stock' },
                            ],
                            Movimientos: [
                                { name: 'Realizar Ventas', route: '/realizaventas' },
                                { name: 'Realizar Compras', route: '/realizacompras' },
                            ],
                            'Interfaz Ventas': [
                                { name: 'Historial de Ventas', route: '/historial' },
                                { name: 'Reporte de Ventas', route: '/reportesventas' },
                            ],
                            Sucursales: [
                                { name: 'Agregar Sucursal', route: '/sucursales' },
                                { name: 'Operaciones Sucursales', route: '/ver-sucursales' },
                            ],
                        };
                    
                        // Función para obtener los permisos del usuario (ejemplo)
                        function userHasPermission(route) {
                            // Implementa la lógica para verificar los permisos del usuario
                            return true;
                        }
                    
                        function filterResults() {
                            const input = document.getElementById('search-input').value.toLowerCase();
                            const results = document.getElementById('search-results');
                            results.innerHTML = ''; // Limpiar resultados previos
                    
                            if (input.length >= 3) { // Iniciar búsqueda solo con 3 o más caracteres
                                results.style.display = 'block';
                    
                                // Iterar sobre los menús
                                Object.keys(menuStructure).forEach(menu => {
                                    let menuMatch = false;
                                    const subMenuList = document.createElement('ul');
                                    subMenuList.className = 'list-group position-absolute bg-dark text-white p-0 mt-1';
                                    subMenuList.style.display = 'none';
                    
                                    // Iterar sobre los submenús
                                    menuStructure[menu].forEach(view => {
                                        if (view.name.toLowerCase().includes(input) && userHasPermission(view.route)) {
                                            menuMatch = true;
                                            const li = document.createElement('li');
                                            li.className = 'list-group-item list-group-item-action bg-dark text-white';
                                            li.textContent = view.name;
                                            li.onclick = () => window.location.href = view.route;
                                            subMenuList.appendChild(li);
                                        }
                                    });
                    
                                    if (menuMatch) {
                                        const li = document.createElement('li');
                                        li.className = 'list-group-item list-group-item-action bg-white text-dark d-flex justify-content-between align-items-center border-bottom';

                                        li.innerHTML = `${menu} <span class="fa fa-chevron-right"></span>`;
                                        li.onmouseover = () => {
                                            subMenuList.style.display = 'block';
                                            subMenuList.style.left = `${li.offsetWidth}px`;
                                            subMenuList.style.top = `${li.offsetTop}px`;
                                        };
                                        li.onmouseleave = () => {
                                            subMenuList.style.display = 'none';
                                        };
                                        li.appendChild(subMenuList);
                                        results.appendChild(li);
                                    }
                                });
                            } else {
                                results.style.display = 'none';
                            }
                        }
                    </script>
                    
                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Recipient's username">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="dropdown d-none d-md-block ms-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img class="me-2" src="assets/images/flags/us_flag.jpg" alt="Header Language"
                                height="16"> English <span class="mdi mdi-chevron-down"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/germany_flag.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle"> German </span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/italy_flag.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle"> Italian </span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/french_flag.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle"> French </span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/spain_flag.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle"> Spanish </span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <img src="assets/images/flags/russia_flag.jpg" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle"> Russian </span>
                            </a>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            data-toggle="fullscreen">
                            <i class="mdi mdi-fullscreen font-size-24"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ti-bell"></i>
                            <span class="badge text-bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0"> Notifications (258) </h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="javascript:void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <span class="avatar-title border-success rounded-circle ">
                                                    <i class="mdi mdi-cart-outline"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Your order is placed</h6>
                                            <div class="text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="javascript:void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <span class="avatar-title border-warning rounded-circle ">
                                                    <i class="mdi mdi-message"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">New Message received</h6>
                                            <div class="text-muted">
                                                <p class="mb-1">You have 87 unread messages</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="javascript:void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <span class="avatar-title border-info rounded-circle ">
                                                    <i class="mdi mdi-glass-cocktail"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Your item is shipped</h6>
                                            <div class="text-muted">
                                                <p class="mb-1">It is a long established fact that a reader will</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="javascript:void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <span class="avatar-title border-primary rounded-circle ">
                                                    <i class="mdi mdi-cart-outline"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Your order is placed</h6>
                                            <div class="text-muted">
                                                <p class="mb-1">Dummy text of the printing and typesetting industry.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="javascript:void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <span class="avatar-title border-warning rounded-circle ">
                                                    <i class="mdi mdi-message"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">New Message received</h6>
                                            <div class="text-muted">
                                                <p class="mb-1">You have 87 unread messages</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top">
                                <a class="btn btn-sm btn-link font-size-14 w-100 text-center"
                                    href="javascript:void(0)">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (Auth::user()->foto)
                                <img class="rounded-circle header-profile-user"
                                    src="{{ Storage::url(Auth::user()->foto) }}" alt="Header Avatar">
                            @else
                                <img class="rounded-circle header-profile-user"
                                    src="assets/images/users/default-user.jpg" alt="Header Avatar">
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#profileModal">
                                <i class="mdi mdi-account-circle font-size-17 text-muted align-middle me-1"></i>
                                Profile
                            </a>

                            <a class="dropdown-item" href="{{ route('billetera.index') }}"><i
                                    class="mdi mdi-wallet font-size-17 text-muted align-middle me-1"></i> My Wallet</a>
                            <a class="dropdown-item d-flex align-items-center" href="{{route('configuracion.index')}}"><i
                                    class="mdi mdi-cog font-size-17 text-muted align-middle me-1"></i> Settings<span
                                    class="badge bg-success ms-auto">11</span></a>
                            <a class="dropdown-item" href="#"><i
                                    class="mdi mdi-lock-open-outline font-size-17 text-muted align-middle me-1"></i>
                                Lock screen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i
                                    class="mdi mdi-power font-size-17 text-muted align-middle me-1 text-danger"></i>
                                Logout</a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="mdi mdi-spin mdi-cog"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Modal -->
        <div class="modal fade modal-right" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="profileModalLabel">Editar Perfil</h5>
                        <button type="button" class="btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="profileForm" method="POST" action="{{ route('profile.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="profile-picture-container">
                                <img src="{{ Storage::url(Auth::user()->foto) }}" alt="Foto de Perfil"
                                    id="profilePhotoPreview">
                                <label for="profile_photo" class="edit-icon">
                                    <i class="mdi mdi-pencil"></i>
                                </label>
                                <input type="file" id="profile_photo" name="foto" style="display: none;"
                                    onchange="previewProfilePhoto(event)">
                            </div>
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="first_name" name="nombre"
                                    value="{{ Auth::user()->nombre }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="last_name" name="apellido"
                                    value="{{ Auth::user()->apellido }}" required>
                            </div>
                            <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function previewProfilePhoto(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const profilePhoto = document.getElementById('profilePhotoPreview');
                        profilePhoto.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">

                        {{-- @php
                            $id_usersession = Auth::user()->id;

                            // Obtener el ID del rol del usuario
                            $userRole = DB::table('users')->where('id', $id_usersession)->value('id_rol');

                            // Obtener los permisos de acceso para el rol del usuario
                            $permisos = DB::table('permiso_acceso')->where('id_rol', $userRole)->pluck('id_acceso');

                            // Obtener accesos permitidos
                            $accesos = DB::table('accesos')->whereIn('id', $permisos)->where('tipo', 'acceso')->get();
                        @endphp
                        @foreach ($accesos as $value)
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-email-outline"></i>
                                <span>{{ $value->nombre }}</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @php
                                    // Obtener subaccesos permitidos para el acceso actual
                                    $subaccesos = DB::table('accesos')
                                        ->where('tipo', 'subacceso')
                                        ->where('idacceso', $value->id)
                                        ->whereIn('id', $permisos)
                                        ->get();
                                @endphp
                                @foreach ($subaccesos as $s_value)
                                    <li><a href="{{ route($s_value->controlador) }}">{{ $s_value->nombre }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach --}}



                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-email-outline"></i>
                                <span>Productos</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('agregar') }}">Agregar producto</a></li>
                                <li><a href="{{ route('producto') }}">Visualizar producto</a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-buffer"></i>
                                <span>Marcas</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('marca') }}">Agregar marca</a></li>
                                <li><a href="{{ route('visualizarmarca') }}">Visualizar marca</a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-account-box"></i>
                                <span>Usuarios</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('usuarios.index') }}">Añadir Usuario</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-shield-account"></i> <!-- Icono para Accesos -->
                                <span>Accesos</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('rol-accesos.index') }}">Crear Rol/Acceso</a></li>
                                <li><a href="{{ route('gestion-rol-acceso.index') }}">Gestionar</a></li>
                                <li><a href="{{ route('asignar-rol.index') }}">Asignar Rol
                                    </a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-cube-send"></i>
                                <span>Stock</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('operacionesstock.index') }}">Operaciones Stock</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-cart-outline"></i>
                                <span>Movimientos</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('realizaventas') }}">Vender</a></li>
                                <li><a href="{{ route('realizacompras.index') }}">Comprar</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-shopping"></i>
                                <span>Interfaz Ventas</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('historial.index') }}">Historial de Ventas</a></li>
                                <li><a href="{{ route('reporteventas') }}">Reporte de Ventas</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-store"></i>
                                <span>Sucursales</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="{{ route('sucursales.index') }}">
                                        <i class="mdi mdi-store-plus"></i>
                                        <span>Agregar Tienda</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('versucursales') }}">
                                        <i class="mdi mdi-file-chart"></i>
                                        <span>Ver sucursales</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        {{-- este es la seccion que varia en cada vista, aqui en la parte inferior derecha debes de generar la burbuja de chat ia --}}
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">

            <div class="rightbar-title d-flex align-items-center px-3 py-4">

                <h5 class="m-0 me-2">Settings</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />


            <div class="px-4 py-2">
                <h6 class="mb-3">Select Custome Colors</h6>
                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-default"
                        value="default" onchange="document.documentElement.setAttribute('data-theme-mode', 'default')"
                        checked>
                    <label class="form-check-label" for="theme-default">Default</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-red"
                        value="red" onchange="document.documentElement.setAttribute('data-theme-mode', 'red')">
                    <label class="form-check-label" for="theme-red">Red</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-teal"
                        value="teal" onchange="document.documentElement.setAttribute('data-theme-mode', 'teal')">
                    <label class="form-check-label" for="theme-teal">Teal</label>
                </div>
            </div>


            <h6 class="text-center mb-0 mt-3">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="">
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="">
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch"
                        data-bsStyle="assets/css/bootstrap-dark.min.css"
                        data-appStyle="assets/css/app-dark.min.html" />
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="">
                </div>
                <div class="form-check form-switch mb-5">
                    <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch"
                        data-appStyle="assets/css/app-rtl.min.css" />
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    {{-- <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!--Morris Chart-->
    <script src="assets/libs/morris.js/morris.min.js"></script>
    <script src="assets/libs/raphael/raphael.min.js"></script>

    <script src="assets/js/pages/dashboard.init.js"></script>

    <script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from themesbrand.com/lexa/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jun 2024 17:25:05 GMT -->

</html>
