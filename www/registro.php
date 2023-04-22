<?php
require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrate</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row align-items-center header">
            <div class="col">
                <h3 class="text-primary"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
            </div>
            <div class="col-auto d-flex">
                <button class="btn btn-primary acceso" onclick="location.href='login.php'"> Acceso </button>
                <button class="btn btn-primary volver" onclick="location.href='index.php'"> Volver </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="contenedor-registro">
                    <!-- Contenido del registro aquí -->
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
    </div>
    <div class="container-fluid">
    </div>
</body>
</html>
