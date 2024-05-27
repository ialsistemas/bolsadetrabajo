@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/home/index.css') }}">
@endsection

@section('content')
    <div id="main">
        <div class="banner-header">
            <img src="{{ asset('app/img/banner-header.jpg') }}" class="img-fluid" alt="Bolsa Laboral">
        </div>
        <div class="auth-forms">
            <div class="container">
                <div class="row">
                    <div class="card col-lg-8 col-md-8 col-sm-12 m-auto">
                        <form action="{{ route('empresa.login.post') }}" method="post" class="publish">
                            @csrf
                            <h5>Publicar una oferta</h5>
                            <div class="form-group">
                                <input type="text" id="usuario_empresa" name="usuario_empresa" class="form-input {{ $errors->has('usuario_empresa') ? ' is-invalid' : '' }}" value="{{ old('usuario_empresa') }}" required>
                                <label for="usuario_empresa">Usuario</label>
                                @if ($errors->has('usuario_empresa'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('usuario_empresa') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" id="password_empresa" name="password" class="form-input {{ $errors->has('password_empresa') ? ' is-invalid' : '' }}" required>
                                <label for="password_empresa">Contraseña</label>
                                @if ($errors->has('password_empresa'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_empresa') }}</strong>
                                </span>
                                @endif
                            </div>
                            <button type="submit">Ingresar</button>
                            <a href="{{ route('empresa.crear_empresa') }}" class="text-uppercase">Crear una cuenta</a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div></div>
    </div>
@endsection
