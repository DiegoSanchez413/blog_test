@extends('layout.app')
@section('content')
<div class="p-5">
    <div class="col-md-4 offset-md-4">
        <form method="GET" action="{{route('validate.login')}}">
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Correo</label>
                <input type="email" id="form2Example1" class="form-control" name="email" placeholder="Ingresa tu correo" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">Contraseña</label>
                <input type="password" id="form2Example2" class="form-control" name="password" placeholder="Ingresa tu contraseña" />
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-4">Iniciar sesión</button>
            @if ($errors != '[]')
            <div class="alert alert-danger">
                <ul>
                    {{$errors}}
                </ul>
            </div>
            @endif
        </form>
    </div>

</div>
@endsection