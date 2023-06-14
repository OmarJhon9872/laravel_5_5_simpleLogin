@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 mx-auto mt-5">

            <div class="card">
                <div class="card-header">
                    Iniciar sesión
                </div>
                <div class="card-body">
                    @if ($errors->has('session_back'))
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('nombre') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="mb-3{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre de usuario:</label>


                            <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required autofocus>

                            @if ($errors->has('nombre'))
                                <div class="form-text text-danger">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>


                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <div class="form-text text-danger">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="form-check">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar sesión
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
