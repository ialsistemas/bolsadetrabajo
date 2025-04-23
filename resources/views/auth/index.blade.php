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
    <link rel="stylesheet" href="{{ asset('auth/css/indexauth/style.css') }}">
    @yield('styles')
</head>

<body>

    <div class="wrapper" id="contenido">
        <div id="loading">
            <i class="fa fa-refresh fa-spin" aria-hidden="true"></i>
        </div>
        <header class="main-header">
            <div class="inside-header">
                @if ($configuracion->logo)
                    <a href="{{ route('auth.inicio') }}" class="logo">
                        <span class="logo-lg">
                            <img src="{{ asset($configuracion->logo) }}" alt="Logo de la Empresa" class="logo1"
                                style="max-width: 150px; max-height: 150px;">
                            <img src="{{ asset('app/img/logo_ial.png') }}" alt="logo" class="logo2">
                        </span>
                    </a>
                @endif
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle d-block d-lg-none" data-toggle="push-menu" role="button"
                        style="color: #363d4a">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav mt-5">
                            @if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR ||
                                    Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_ADMINISTRADOR)
                                <li id="notifications" class="dropdown notifications-menu">
                                    <button type="button" class="btn btn-light" id="expandImage"
                                        style="margin-right: 10px; margin-top: 10px;" title="Ampliar pantalla">
                                        <i class="mdi mdi-fullscreen" style="width:500px !important;"></i>
                                    </button>

                                    <script>
                                        document.getElementById('expandImage').addEventListener('click', function() {
                                            const content = document.getElementById('contenido');
                                            if (!document.fullscreenElement) {
                                                content.requestFullscreen().catch(err => {});
                                            } else {
                                                document.exitFullscreen();
                                            }
                                        });
                                    </script>
                                    <button type="button" class="mt-3 dropdown-toggle btn btn-light"
                                        data-toggle="dropdown" style ="margin-top:10px !important;">
                                        <i class="mdi mdi-bell faa-ring animated"></i>
                                        <span class="badge badge-danger pt-3 pb-0" id="number_notify"></span>
                                    </button>
                                    <ul class="dropdown-menu scale-up" id="list_notification">
                                        <li class="header">Tienes <span id="counNotificacion"></span> notificaciones
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <div class="user-image-wrapper">
                                        <img src="{{ asset('auth/image/icon/usuario.jpg') }}" class="user-image"
                                            alt="User Image">
                                        <span class="status-indicator active"></span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu scale-up">
                                    <li class="user-header">
                                        <div class="user-image-wrapper">
                                            <img src="{{ asset('auth/image/icon/usuario.jpg') }}" class="float-left"
                                                alt="User Image">

                                        </div>
                                        <p>
                                            {{ Auth::guard('web')->user()->nombres }}
                                            <small class="mb-5">{{ Auth::guard('web')->user()->email }}</small>
                                            <a href="#" class="btn btn-danger btn-sm btn-rounded"> <i
                                                    class="fa fa-user"></i>
                                                {{ Auth::guard('web')->user()->profile->name }}</a>
                                        </p>
                                    </li>
                                    <li class="user-body">
                                        <div class="row no-gutters">
                                            <div class="col-12 text-left">
                                                <a href="javascript:void(0)">
                                                    <b class="text-success">●</b> En Línea
                                                </a>
                                                <a id="ModalCambiarPassword" href="javascript:void(0)">
                                                    <i class="fa fa-key"></i> Cambiar Contraseña
                                                </a>
                                                <a
                                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-power-off"></i> {{ __('Cerrar Sesión') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('auth.logout') }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="text" name="validacion"
                                                        value="{{ Auth::guard('web')->user()->email }}">
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
                        @if (Auth::user()->id == 28 || Auth::user()->id == 29)
                            <li class="nav-item {{ Route::currentRouteName() == 'auth.index' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('auth.index') }}"><span
                                        class="active-item-here"></span>
                                    <i class="fa fa-male mr-5"></i> <span>Empleador</span>
                                </a>
                            </li>
                            <li
                                class="nav-item dropdown {{ Route::currentRouteName() == 'auth.anuncio' || Route::currentRouteName() == 'auth.anuncioempresa' ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="active-item-here"></span><i class="fa fa-photo mr-5"></i>
                                    <span>Anuncios</span></a>
                                <ul class="dropdown-menu multilevel scale-up-left">
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('auth.anuncio') }}">Anuncios
                                            Alumnos</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('auth.anuncioempresa') }}">Anuncios Empresas</a></li>
                                </ul>
                            </li>
                            <li class="nav-item {{ Route::currentRouteName() == 'auth.programa' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('auth.programa') }}"><span
                                        class="active-item-here"></span>
                                    <i class="fa fa-bolt mr-5"></i> <span>Programas de Inserción rápida</span>
                                </a>
                            </li>
                            <li
                                class="nav-item dropdown {{ Route::currentRouteName() == 'auth.eventos' || Route::currentRouteName() == 'auth.eventosasistencia' ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="active-item-here"> <i class="fa fa-calendar-alt mr-5"></i></span>
                                    <i class="fa fa-calendar mr-5"></i>
                                    <span>Gestión de Eventos</span>
                                </a>
                                <ul class="dropdown-menu multilevel scale-up-left">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('auth.eventos') }}">
                                            <i class="fa fa-calendar mr-5"></i>
                                            <!-- Ícono de calendario para "Listado de Eventos" -->
                                            Listado de Eventos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('auth.eventosasistencia') }}">
                                            <i class="fa fa-check-circle mr-5"></i>
                                            <!-- Ícono de verificación para "Asistencia" -->
                                            Registrar Asistencia
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            @if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR ||
                                    Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_ADMINISTRADOR)
                                <li class="nav-item {{ Route::currentRouteName() == 'auth.inicio' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('auth.inicio') }}"><span
                                            class="active-item-here"></span>
                                        <i class="fa fa-home mr-5"></i> <span>Inicio</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'auth.index' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('auth.index') }}"><span
                                            class="active-item-here"></span>
                                        <i class="fa fa-male mr-5"></i> <span>Empleador</span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item dropdown {{ Route::currentRouteName() == 'auth.alumno' || Route::currentRouteName() == 'auth.alumnosancionado' ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="active-item-here"></span><i class="fa fa-users mr-5"></i>
                                        <span>Estudiantes</span></a>
                                    <ul class="dropdown-menu multilevel scale-up-left">
                                        <li class="nav-item"><a class="nav-link" href="{{ route('auth.alumno') }}"><i
                                                    class="fa fa-users mr-5"></i> Gestión de Estudiantes</a></li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('auth.alumnosancionado') }}"><i
                                                    class="fa fa-gavel mr-5"></i>Estudiantes Sancionados</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('auth.certificados') }}"><i class="fa fa-id-card"></i>
                                                Estudiantes Certificados</a>
                                        </li>
                                    </ul>
                                </li>
                                {{-- <li class="nav-item {{ Route::currentRouteName() == 'auth.alumno' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('auth.alumno') }}"><span
                                            class="active-item-here"></span>
                                        <i class="fa fa-users mr-5"></i> <span>Estudiantes</span>
                                    </a>
                                </li> --}}
                                <li
                                    class="nav-item dropdown {{ Route::currentRouteName() == 'auth.aviso' || Route::currentRouteName() == 'auth.avisoPostulacion' ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="active-item-here"></span><i class="fa fa-archive mr-5"></i>
                                        <span>Avisos</span></a>
                                    <ul class="dropdown-menu multilevel scale-up-left">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('auth.aviso') }}">Listado
                                                Avisos</a></li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('auth.avisoPostulacion') }}">Avisos por Alumno
                                                Postulado</a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item dropdown {{ Route::currentRouteName() == 'auth.anuncio' || Route::currentRouteName() == 'auth.anuncioempresa' ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="active-item-here"></span><i class="fa fa-photo mr-5"></i>
                                        <span>Anuncios</span></a>
                                    <ul class="dropdown-menu multilevel scale-up-left">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('auth.anuncio') }}">Anuncios
                                                Alumnos</a></li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('auth.anuncioempresa') }}">Anuncios Empresas</a></li>
                                    </ul>
                                </li>

                                <li
                                    class="nav-item dropdown {{ Route::currentRouteName() == 'auth.programa' || Route::currentRouteName() == 'auth.programa-empleavilidad' ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="active-item-here"></span><i class="fa fa-bolt mr-5"></i>
                                        <span>Programas</span></a>
                                    <ul class="dropdown-menu multilevel scale-up-left">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('auth.programa') }}">Inserción rápida</a></li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('auth.programa-empleabilidad') }}">Empleabilidad</a></li>
                                    </ul>
                                </li>
                            @endif
                            {{-- Fin --}}
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="active-item-here"></span> <i class="fa fa-cog mr-5"></i>
                                    <span>Ajustes</span></a>
                                <ul class="dropdown-menu multilevel scale-up-left">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('auth.area') }}">Áreas</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('auth.horario') }}">Horarios</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('auth.modalidad') }}">Modalidades</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('auth.habilidad') }}">Habilidades Personales</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('auth.habilidad_profesional') }}">Habilidades Profesionales</a>
                                    </li>
                                </ul>
                            </li> --}}
                            @if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR ||
                                    Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_ADMINISTRADOR)
                                <li
                                    class="nav-item dropdown {{ Route::currentRouteName() == 'auth.eventos' || Route::currentRouteName() == 'auth.eventosasistencia' ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="active-item-here"> <i class="fa fa-calendar-alt mr-5"></i></span>
                                        <i class="fa fa-calendar mr-5"></i>
                                        <span>Gestión de Eventos</span>
                                    </a>
                                    <ul class="dropdown-menu multilevel scale-up-left">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('auth.eventos') }}">
                                                <i class="fa fa-calendar mr-5"></i>
                                                <!-- Ícono de calendario para "Listado de Eventos" -->
                                                Listado de Eventos
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('auth.eventosasistencia') }}">
                                                <i class="fa fa-check-circle mr-5"></i>
                                                <!-- Ícono de verificación para "Asistencia" -->
                                                Registrar Asistencia
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endif
                            @if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR ||
                                    Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_ADMINISTRADOR)
                                <li
                                    class="nav-item dropdown {{ Route::currentRouteName() == 'auth.usuarios' ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="active-item-here"></span> {{-- <i class="fa fa-cog mr-5"></i> --}}
                                        <span>Ver más</span></a>
                                    <ul class="dropdown-menu multilevel scale-up-left">
                                        <li class="nav-item"><a class="nav-link" href="{{ route('auth.usuarios') }}"><i
                                                    class="fa fa-user mr-5"></i> Gestión de
                                                Usuarios</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('auth.configuracion') }}">
                                                <i class="fa fa-cog mr-5"></i> Configuración
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
        @yield('contenido')
        <div class="conta mt-15" style=" padding-right: 0px !important; padding-left: 0px !important;">
            <footer class="text-center text-white" style="background-color: #004991 !important">
                <!-- Grid container -->
                <div class="container p-4 pb-0">
                    <!-- Section: Social media -->
                    <section class="mb-4">
                        <!-- Facebook -->
                        @if ($configuracion->facebook)
                            <a class="btn btn-outline-light btn-floating m-1" href="{{ $configuracion->facebook }}"
                                target="_blank" role="button"><i class="fa fa-facebook-f"></i></a>
                        @endif

                        <!-- Instagram -->
                        @if ($configuracion->instagram)
                            <a class="btn btn-outline-light btn-floating m-1" href="{{ $configuracion->instagram }}"
                                target="_blank" role="button"><i class="fa fa-instagram"></i></a>
                        @endif

                        <!-- LinkedIn -->
                        @if ($configuracion->linkedin)
                            <a class="btn btn-outline-light btn-floating m-1" href="{{ $configuracion->linkedin }}"
                                target="_blank" role="button"><i class="fa fa-linkedin"></i></a>
                        @endif

                        <!-- WhatsApp -->
                        @if ($configuracion->tel)
                            <a class="btn btn-outline-light btn-floating m-1"
                                href="https://wa.me/{{ $configuracion->tel }}" target="_blank" role="button"><i
                                    class="fa fa-whatsapp"></i></a>
                        @endif
                    </section>
                    <!-- Section: Social media -->
                </div>

                <!-- Grid container -->
                <!-- Copyright -->
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                    © 2024 Todos los derechos reservados para
                    <a class="text-white" href="https://www.ial.edu.pe/" target="_blank">Instituto Arzobispo
                        Loayza</a>
                </div>
                <!-- Copyright -->
            </footer>
        </div>


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
    {{-- Para bloquear el F12 y otras funciones --}}
    {{-- <script>
        document.addEventListener("keydown", function(e) {
            // Deshabilitar F12
            if (e.keyCode === 123) {
                e.preventDefault();
                return false;
            }

            // Deshabilitar Ctrl+Shift+I (DevTools)
            if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
                e.preventDefault();
                return false;
            }

            // Deshabilitar Ctrl+U (Ver fuente)
            if (e.ctrlKey && e.keyCode === 85) {
                e.preventDefault();
                return false;
            }
        });

        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        });
    </script> --}}
    <script type="text/javascript">
        const usuarioLoggin = {
            user_id: {{ \Illuminate\Support\Facades\Auth::guard('web')->user()->id }},
            profile_id: {{ \Illuminate\Support\Facades\Auth::guard('web')->user()->profile_id }}
        }
    </script>

    @yield('scripts')

</body>

</html>
