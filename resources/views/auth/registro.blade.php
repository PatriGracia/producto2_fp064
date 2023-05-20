@extends('layouts.plantilla')

@section('title', 'Registrate')
            
@section('css')
<link rel="stylesheet" href="{{ asset('css/registro.css')}}">
@endsection
            
@section('content')
            <div class="col-auto d-flex">
                <button class="btn btn-primary acceso" onclick="location.href='{{route('login')}}'"> Login </button>
                <button class="btn btn-primary volver" onclick="location.href='{{route('home')}}'"> Volver </button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Registrarse</h2>
                <div class="contenedor-registro">
                    <form method="POST" action="{{route('validar-registro')}}" >
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-4">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group col-md-6 mb-4">
                                <label for="apellido1">Apellido 1:</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="apellido2">Apellido 2:</label>
                            <input type="text" class="form-control" id="apellido2" name="apellido2" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="username">Nombre de usuario:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-4">
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group col-md-6 mb-4">
                                <label for="password_confirm">Confirmar contraseña:</label>
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
@endsection
   