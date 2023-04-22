<?php
  require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Iniciar sesión - Gestión de Eventos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="login.css">
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
                    <button class="btn btn-primary volver ml-2" onclick="location.href='index.php'"> Volver </button> 
                </div>
            </div>
        </div>
        <div class="container">
            <div class="login-container">
                <h2>Iniciar sesión</h2>
                <form action="login_process.php" method="post">
                    <div class="form-group">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </body>
</html>