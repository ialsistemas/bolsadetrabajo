<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://www.ial.edu.pe/isotipo.png">
    <meta name="title" content="Instituto Arzobispo Loayza" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="Instituto Arzobispo Loayza">
    <meta property="og:type" content="website">
    <meta name="author" content="MAJML" />
    <meta name="Resource-type" content="Document" />
    <link rel="shortcut icon" href="{{ asset('app/img/logo_ial.png') }}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=5; IE=6; IE=7; IE=8; IE=9; IE=10">
    <title>Bolsa de Trabajo</title>
    <link rel="stylesheet" href="{{ asset('app/plugins/bootstrap4/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/toastr/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/estilossebas.css') }}">
    @yield('styles')
</head>

<body>

    <div id="loading">
        <i class="fa fa-refresh fa-spin" aria-hidden="true"></i>
    </div>

    @if (Auth::guard('alumnos')->check() || Auth::guard('empresasw')->check())
        <header class="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <a class="navbar-brand" href="{{ route('index') }}">
                                @if ($configuracion->logo)
                                    <img src="{{ asset($configuracion->logo) }}" alt="Instituto Arzobispo Loayza"
                                        class="logo" style="width: 60%">
                                @endif
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu"
                                aria-controls="mainmenu" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="mainmenu">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle d-flex align-items-center custom-dropdown"
                                            href="#" id="userMenu" role="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"
                                            style="justify-content: space-around !important;">
                                            @if (Auth::guard('alumnos')->check() && Auth::guard('alumnos')->user()->foto)
                                                <img src="{{ asset('uploads/alumnos/fotos/' . Auth::guard('alumnos')->user()->foto) }}"
                                                    alt="Imagen del Alumno" class="user-avatar">
                                            @else
                                                <img src="{{ asset('auth/image/icon/iconoempresa.png') }}"
                                                    class="user-avatar" alt="User Image">
                                            @endif
                                            <span class="ms-2 small">
                                                Hola, <br>
                                                {{ Auth::guard('alumnos')->check() ? Auth::guard('alumnos')->user()->nombres : Auth::guard('empresasw')->user()->nombre_comercial }}
                                            </span>
                                        </a>


                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                                            @if (Auth::guard('alumnos')->check() || Auth::guard('empresasw')->check())
                                                <a class="dropdown-item"
                                                    href="{{ Auth::guard('alumnos')->check() ? route('alumno.perfil') : route('empresa.perfil') }}">
                                                    <i class="fa fa-user"></i> Perfil
                                                </a>
                                                <div class="divider"></div> <!-- División -->
                                                @if (Auth::guard('alumnos')->check())
                                                    <a class="dropdown-item"
                                                        href="{{ route('alumno.postulaciones') }}">
                                                        <i class="fa fa-bell"></i> Mis Postulaciones
                                                    </a>
                                                @endif
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="event.preventDefault(); localStorage.setItem('cliente_id', ''); document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-power-off"></i> {{ __('Cerrar Sesión') }}
                                                </a>

                                                <form id="logout-form"
                                                    action="{{ Auth::guard('alumnos')->check() ? route('alumno.logout') : route('empresa.logout') }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="validacion"
                                                        value="{{ Auth::guard('alumnos')->check() ? Auth::guard('alumnos')->user()->usuario_alumno : Auth::guard('empresasw')->user()->usuario_empresa }}">
                                                </form>
                                            @else
                                                <a class="dropdown-item" href="{{ route('auth.login') }}">
                                                    <i class="fa fa-user"></i> Administrador
                                                </a>
                                            @endif
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
    @endif


    @yield('content')
    <style>
        #whatsapp-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            /* Cambiado de 'right' a 'left' */
            z-index: 1000;
            text-decoration: none;
        }

        .whatsapp-btn {
            background-color: #25d366;
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 16px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .whatsapp-btn:hover {
            background-color: #128c7e;
            text-decoration: none;
            /* Elimina la subrayado en hover */
        }


        .whatsapp-btn i {
            font-size: 24px;
            margin-right: 10px;
        }
    </style>
    <a href="https://wa.me/{{ $configuracion->tel }}?text=Hola,%20vengo%20de%20la%20Bolsa%20de%20trabajo%20y%20quiero%20conocer%20más%20sobre%20los%20programas%20de%20empleabilidad.%20Información%20por%20favor."
        target="_blank" id="whatsapp-btn">
        <div class="whatsapp-btn">
            <i class="fa fa-whatsapp"></i> <!-- Ícono de WhatsApp -->
            ¿Necesitas ayuda?
        </div>
    </a>





    @if (Auth::guard('alumnos')->check() || Auth::guard('empresasw')->check())
        <footer style="color: #ecf0f1; padding: 20px 0;">
            <div class="container">
                <div class="row">
                    <!-- Información de Contacto -->
                    <div class="col-lg-4 col-md-6 mb-3">
                        <h5 class="text-uppercase"><b>Licenciados por Minedu</b></h5>
                        <div
                            style="border-left: 5px solid orange; border-right: 5px solid orange; border-bottom: 2px solid orange; margin-top: 10px;">
                        </div>
                        <br>
                        <p>
                            <span>Informes:</span> (01) 330-9090 <br>
                            <a href="mailto:bolsadetrabajo@arzobispoloayza.edu.pe"
                                style="color: #ecf0f1; text-decoration: none;">
                                bolsadetrabajo@arzobispoloayza.edu.pe
                            </a>
                        </p>
                    </div>

                    <!-- Sección de Bolsa Laboral -->
                    <div class="col-lg-4 col-md-6 mb-3">
                        <h5 class="text-uppercase"><b>Bolsa Laboral</b></h5>
                        <div
                            style="border-left: 5px solid orange; border-right: 5px solid orange; border-bottom: 2px solid orange; margin-top: 10px;">
                        </div><br>
                        <p>Consulta las oportunidades laborales en nuestro instituto.</p>
                    </div>

                    <!-- Redes Sociales -->
                    <div class="col-lg-4 col-md-12">
                        <h5 class="text-uppercase"><b>Más Información</b></h5>
                        <div
                            style="border-left: 5px solid orange; border-right: 5px solid orange; border-bottom: 2px solid orange; margin-top: 10px;">
                        </div><br>
                        <ul style="list-style: none; padding: 0; display: flex; gap: 10px;">
                            <!-- Instagram -->
                            @if ($configuracion->instagram)
                                <li>
                                    <a href="{{ $configuracion->instagram }}" target="_blank"
                                        style="color: #ecf0f1; font-size: 20px;">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- LinkedIn -->
                            @if ($configuracion->linkedin)
                                <li>
                                    <a href="{{ $configuracion->linkedin }}" target="_blank"
                                        style="color: #ecf0f1; font-size: 20px;">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- Facebook -->
                            @if ($configuracion->facebook)
                                <li>
                                    <a href="{{ $configuracion->facebook }}" target="_blank"
                                        style="color: #ecf0f1; font-size: 20px;">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Línea Divisoria -->
                <hr style="border-top: 1px solid #7f8c8d; margin: 20px 0;">

                <!-- Derechos Reservados -->
                <div class="row">
                    <div class="col-12 text-center">
                        <p style="margin: 0;">MAJML - Todos los derechos reservados para Instituto Arzobispo Loayza
                            &copy;
                            <?php echo date('Y'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

    @endif
    {{--  <script>
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
    </script>
 --}}

    <script type="text/javascript" src="{{ asset('app/plugins/jquery/3.5.1/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/bootstrap4/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/toastr/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/js/_Layout.js') }}"></script>
    @yield('scripts')
</body>

</html>
