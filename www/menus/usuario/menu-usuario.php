<?php
?>
    require_once 'db_connection.php';
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu Usuario</title>
        <link rel="stylesheet" href="../propiedades-comundes.css">
    </head>
    <body>
        <div class="header">
            <div>
                <h3 style="color:cadetblue;"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
            </div>
            <div> 
                <h1 style="color:rgb(136, 136, 183);">¡Bienvenido/a *nombre_usuario*! </h1>
            </div>
            
            <div class="botones"> 
                <button class="boton perfil"> Perfil </button> 
                <button class="boton salir" > Salir </button> 
            </div>
        </div>
        <div class="menu-izquierdo">
            <a href=""> Calendario de actos </a>
            <a href=""> Mis Actos </a>

        </div>
        <div class="contenido">
            
        </div>
    </body>
    </html>