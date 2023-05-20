@extends('layouts.plantilla')

@section('title', 'Welcome')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')

<div class="col-auto d-flex">
                    <button class="btn btn-primary registro" onclick="location.href='registro'"> Registro </button> 
                    <button class="btn btn-primary acceso" onclick="location.href='login'"> Login </button>
                </div>
            </div>
            <div class="row image-row">
                <div class="col-md-4 col-sm-12 conferencias image-container">
                    <div class="content-wrapper">
                        <h3 class="text-info text-justified text-aligned"> Conferencias de tu especialidad con los mejores profesionales a escala global. Idiomas: español, inglés, alemán, chino y árabe. </h3>
                        <img class="img-fluid" src="{{ asset('images/conferencia.jpg')}}">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 seminarios image-container">
                    <div class="content-wrapper">
                        <h3 class="text-warning text-justified text-aligned"> Los mejores seminarios de tu especialidad 100% online. Se un profesional imparable. </h3>
                        <img class="img-fluid" src="{{ asset('images/seminario.jpg')}}">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 mesa-redonda image-container">
                    <div class="content-wrapper">
                        <h3 class="text-success text-justified text-aligned"> Participa en alguna mesa redonda de debate presencialmente o desde casa.</h3>
                        <img class="img-fluid" src="{{ asset('images/mesa-redonda.jpg')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h1 class="text-danger"> <strong>Regístrate ya para poder participar en todos estos eventos que harán que despegues en tu carrera profesional </strong></h1>
                </div>
            </div>

@endsection

