<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Didicão ADMINISTRADOR</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!--Chartist Chart CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/chartist/css/chartist.min.css') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">

    @yield('styles')
    <link href="{{ asset('assets/css/admin-estrutura-style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body>

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="{{ route('admin') }}" class="logo">
                        <span>
                                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="30">
                            </span>
                <i>
                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                </i>
            </a>
        </div>
        <!-- END LOGO -->

        <nav class="navbar-custom">
            <ul class="navbar-right list-inline float-right mb-0">
                <!-- full screen -->
                <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                    <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                        <i class="mdi mdi-fullscreen noti-icon"></i>
                    </a>
                </li>

                <li class="dropdown notification-list list-inline-item">
                    <div class="dropdown notification-list nav-pro-img">
                        <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('assets/images/users/user-0.jpg') }}" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-power text-danger"></i> Sair
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>

            </ul>

            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
            </ul>

        </nav>

    </div>
    <!-- Top Bar End -->

    <!-- ========== MENU ========== -->
    <div class="left side-menu">
        <div class="slimscroll-menu" id="remove-scroll">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu" id="side-menu">
                    <li class="menu-title">Menu</li>
                    <li>
                        <a href="{{ route('admin') }}" class="waves-effect">
                            <i class="ti-home"></i> <span> Painel </span>
                        </a>
                    </li>

                    <li class="menu-title">Gerenciamento</li>

                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-package"></i> <span>Produtos<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.produtos.index') }}">Listar</a></li>
                            <li><a href="{{ route('admin.produtos.criar') }}">Cadastrar</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-package"></i> <span>Insumos<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.insumos.index') }}">Listar</a></li>
                            <li><a href="{{ route('admin.insumos.criar') }}">Cadastrar</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-package"></i> <span>Categorias<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.categorias.index') }}">Listar</a></li>
                            <li><a href="{{ route('admin.categorias.criar') }}">Cadastrar</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- MENU END -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                @yield('conteudo')
            </div>
            <!-- container-fluid -->

        </div>
        <!-- content -->

        <footer class="footer">
            © 2020 Didicão - V1.2 <span class="d-none d-sm-inline-block"> - by MichaelCosta</span>.
        </footer>

    </div>

    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/waves.min.js') }}"></script>

<!--Chartist Chart-->
<script src="{{ asset('plugins/chartist/js/chartist.min.js') }}"></script>
<script src="{{ asset('plugins/chartist/js/chartist-plugin-tooltip.min.js') }}"></script>

<!-- peity JS -->
<script src="{{ asset('plugins/peity-chart/jquery.peity.min.js') }}"></script>

<script src="{{ asset('assets/pages/dashboard.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

@yield('scripts')

<script>
    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })();
</script>
</body>

</html>