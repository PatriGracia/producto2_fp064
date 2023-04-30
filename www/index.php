<?php //creo que no es necesario llamar a la bbdd
      require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

      $conn = conexion();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to LAMP Infrastructure</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/css/index.css">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row align-items-center header">
                <div class="col">
                    <h3 class="text-primary"> <strong>Grupo PSMD </strong></h3>
                    <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
                </div>
                <div class="col-auto d-flex">
                    <button class="btn btn-primary registro" onclick="location.href='registro.php'"> Registro </button> 
                    <button class="btn btn-primary acceso" onclick="location.href='login.php'"> Acceso </button>
                </div>
            </div>
            <div class="row image-row">
                <div class="col-md-4 col-sm-12 conferencias image-container">
                    <div class="content-wrapper">
                        <h3 class="text-info text-justified text-aligned"> Conferencias de tu especialidad con los mejores profesionales a escala global. Idiomas: español, inglés, alemán, chino y árabe. </h3>
                        <img class="img-fluid" src="/assets/conferencia.jpg">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 seminarios image-container">
                    <div class="content-wrapper">
                        <h3 class="text-warning text-justified text-aligned"> Los mejores seminarios de tu especialidad 100% online. Se un profesional imparable. </h3>
                        <img class="img-fluid" src="/assets/seminario.jpg">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 mesa-redonda image-container">
                    <div class="content-wrapper">
                        <h3 class="text-success text-justified text-aligned"> Participa en alguna mesa redonda de debate presencialmente o desde casa.</h3>
                        <img class="img-fluid" src="/assets/mesa-redonda.jpg">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h1 class="text-danger"> <strong>Regístrate ya para poder participar en todos estos eventos que harán que despegues en tu carrera profesional </strong></h1>
                </div>
            </div>
        </div>
        <div class="footer">
        </div>
        <div class="container-fluid">
        </div>
    </body>
</html>