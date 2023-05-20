@extends('layouts.plantilla')

@section('title', 'Iniciar sesión')
                            
@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css')}}">
@endsection
                            
@section('content')
                <div class="col-auto d-flex">
                    <button class="btn btn-primary registro" onclick="location.href='{{route('registro')}}'"> Registro </button> 
                    <button class="btn btn-primary volver ml-2" onclick="location.href='{{route('home')}}'"> Volver </button> 
                </div>
            </div>
        </div>
        <div class="container">
            <div class="login-container">
                <h2>Iniciar sesión</h2>
                <form method="POST" action="{{route('inicia-sesion')}}">
                    @csrf
                    <div class="form-group">
                        <label for="username">Nombre de usuario:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </form>
            </div>
        </div>
@endsection
