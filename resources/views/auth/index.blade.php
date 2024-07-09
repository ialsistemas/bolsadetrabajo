<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="MAJML">
    @yield('titulo')
    <link rel="stylesheet" href="{{ asset('auth/plugins/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/bootstrap/css/bootstrap-extend.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/toastr/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/layout/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/index.css') }}">
    @yield('styles')
</head>

<body>

<style>
/* CAMBIAR THEME DE SISTEMA */
.content-wrapper:before {
    background: radial-gradient(circle, rgba(0,114,191,1) 37%, rgba(0,195,244,1) 100%);
}
.main-nav {
    background: radial-gradient(circle, rgba(0,114,191,1) 37%, rgba(0,195,244,1) 100%);
}
.active-item-here{
    color: #0072bf;
}
.table thead {
    background-color: #0072bf;
}
.btn-secondary {
    color: #fff;
    background-color: #2ecc71;
    border-color: #2ecc71;
}
.btn-secondary:hover {
    color: #fff;
    background-color: #1cb65c;
    border-color: #1cb65c;
}
div.dataTables_wrapper div.dataTables_filter input{
    width: 400px !important;
}
@media screen and (max-width:503px){
    div.dataTables_wrapper div.dataTables_filter input{
        width: 100% !important;
}
}
.modal.modal-fill .modal-dialog .modal-header{
    background-color: #0072bf;
}
.modal.modal-fill{
    background: rgba(135, 189, 236, 0.305); !important;
}
header{
    padding-top: 5px;
}
.li_notifi{
    background: rgb(215, 215, 215);
    cursor: pointer;
    padding: 5px 10px !important;
    border: 0px 0px 2px 0px solid rgb(104, 104, 104) !important;
}
.li_notifi:hover{
    background: rgb(231, 229, 229) !important;
}
</style>
<div class="wrapper">

    <div id="loading">
        <i class="fa fa-refresh fa-spin" aria-hidden="true"></i>
    </div>

    <header class="main-header">
        <div class="inside-header">
            <a href="/" class="logo">
               <span class="logo-lg">
                  <img src="{{ asset('app/img/logo.png') }}" alt="logo" class="light-logo">
                  <img src="{{ asset('app/img/logo.png') }}" alt="logo" class="dark-logo">
              </span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle d-block d-lg-none" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav mt-5">
                        <li id="notifications" class="dropdown notifications-menu">
                            <button type="button" class="mt-3 dropdown-toggle btn btn-light" data-toggle="dropdown">
                                <i class="mdi mdi-bell faa-ring animated"></i>
                                <span class="badge badge-danger pt-3 pb-0" id="number_notify"></span>
                            </button>
                            <ul class="dropdown-menu scale-up" id="list_notification">
                                <li class="header">Tienes <span id="counNotificacion"></span> notificaciones</li>
                            </ul>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('auth/image/icon/usuario.jpg') }}" class="user-image" alt="User Image">
                            </a>
                            <ul class="dropdown-menu scale-up">
                                <li class="user-header">
                                    <img src="{{ asset('auth/image/icon/usuario.jpg') }}" class="float-left" alt="User Image">
                                    <p>
                                        {{ Auth::guard('web')->user()->nombres }}
                                        <small class="mb-5">{{ Auth::guard('web')->user()->email }}</small>
                                        <a href="#" class="btn btn-danger btn-sm btn-rounded">Administrador</a>
                                    </p>
                                </li>
                                <li class="user-body">
                                    <div class="row no-gutters">
                                        <div class="col-12 text-left">
                                            <a id="ModalCambiarPassword" href="javascript:void(0)">
                                                <i class="fa fa-key"></i> Cambiar Contraseña
                                            </a>
                                            <a onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                <i class="fa fa-power-off"></i> {{ __('Cerrar Sesión') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <div class="main-nav">
        <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item {{ Route::currentRouteName() == 'auth.inicio' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('auth.inicio') }}"><span class="active-item-here"></span>
                            <i class="fa fa-home mr-5"></i> <span>Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteName() == 'auth.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('auth.index') }}"><span class="active-item-here"></span>
                            <i class="fa fa-male mr-5"></i> <span>Empleador</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteName() == 'auth.alumno' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('auth.alumno') }}"><span class="active-item-here"></span>
                            <i class="fa fa-users mr-5"></i> <span>Estudiantes</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown {{ Route::currentRouteName() == 'auth.aviso' || Route::currentRouteName() == 'auth.avisoPostulacion'  ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="active-item-here"></span><i class="fa fa-archive mr-5"></i> <span>Avisos</span></a>
                        <ul class="dropdown-menu multilevel scale-up-left">
                            <li class="nav-item"><a class="nav-link" href="{{ route('auth.aviso') }}">Listado Avisos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('auth.avisoPostulacion') }}">Avisos por Alumno Postulado</a></li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Route::currentRouteName() == 'auth.anuncio' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('auth.anuncio') }}"><span class="active-item-here"></span>
                            <i class="fa fa-photo mr-5"></i> <span>Anuncios</span>
                        </a>
                    </li>
{{--                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="active-item-here"></span> <i class="fa fa-cog mr-5"></i> <span>Ajustes</span></a>
                        <ul class="dropdown-menu multilevel scale-up-left">
                            <li class="nav-item"><a class="nav-link" href="{{ route('auth.area') }}">Áreas</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('auth.horario') }}">Horarios</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('auth.modalidad') }}">Modalidades</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('auth.habilidad') }}">Habilidades Personales</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('auth.habilidad_profesional') }}">Habilidades Profesionales</a></li>
                        </ul>
                    </li> --}}

                </ul>
            </div>
        </nav>
    </div>

    @yield('contenido')

    <footer class="main-footer">
        &copy; <?php echo date('Y') ?> Powered by <a href="#" target="_blank">AgencyDesing</a>. Actualizado por Marco Antonio.
    </footer>

</div>
<script type="text/javascript" src="{{ asset('auth/plugins/popper.min.js') }}"></script>
{{-- <script type="" src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> --}}
<script type="text/javascript" src="{{ asset('auth/plugins/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/toggle-sidebar/index.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/toastr/js/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/plugins/moment/es.js') }}"></script>
<script type="text/javascript" src="{{ asset('auth/js/_Layout.js') }}"></script>
<script type="text/javascript">
    const usuarioLoggin = {
        user_id: {{ \Illuminate\Support\Facades\Auth::guard('web')->user()->id  }},
    }
</script>

@yield('scripts')

</body>
</html>
