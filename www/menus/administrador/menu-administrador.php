<?php
    require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrador</title>
    <link rel="stylesheet" href="./propiedades-comundes.css">
    <link rel="stylesheet" href="menu-administrador.css">
</head>
<body>
        <div class="header">
            <div>
                <h3 style="color:cadetblue;"><strong>Grupo PSMD</strong></h3>
                <h4 class="nombre-proyecto">Gestión de Eventos - Panel de Administración</h4>
            </div>
            
            <div class="botones"> 
                <button class="boton logout" > Cerrar sesión </button> 
            </div>
        </div>
        <div class="cuerpo">
            <h2>Administración de eventos</h2>
            <p>Aquí puedes gestionar los eventos, ponentes, tipos de eventos y asistentes.</p>
            <div class="menu-admin">
                <a href="admin/eventos.php" class="boton-admin">Gestionar eventos</a>
                <a href="admin/ponentes.php" class="boton-admin">Gestionar ponentes</a>
                <a href="admin/tipos_eventos.php" class="boton-admin">Gestionar tipos de eventos</a>
                <a href="admin/asistentes.php" class="boton-admin">Gestionar asistentes</a>
            </div>
        </div>
        <div class="footer">

        </div>
    </body>
</html>