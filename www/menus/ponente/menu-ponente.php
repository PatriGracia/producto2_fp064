<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu Ponente</title>
        <link rel="stylesheet" href="../propiedades-comundes.css">
        <link rel="stylesheet" href="menu-ponente.css">
    </head>
    <body>
        <header>

        </header>
        <div class="menu-izquierdo">

        </div>
        <div class="contenido">
            
        </div>
    </body>
    </html>