<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    require_once 'db_connection.php';
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <title>Menu Ponente</title>
        <link rel="stylesheet" href="/css/index.css">
        <link rel="stylesheet" href="/css/propiedades-comunes.css">
    </head>
    <body>
        <div class="header">
            <div>
                <h3 style="color:cadetblue;"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
            </div>
            <div> 
            <h1 style="color:rgb(136, 136, 183);">¡Bienvenido/a <?php echo $user_name; ?>! </h1>
            </div>

            <div class="botones"> 
                <button class="boton perfil"> Perfil </button> 
                <button class="boton salir" onclick="location.href='logout.php'"> Salir </button>
            </div>
        
        <div class="menu-izquierdo">
            <a href=""> Calendario de actos </a>
            <a href=""> Mis Actos </a>

        </div>

        </div>
        <div class="contenido">
            
        </div>
    </body>
    </html>