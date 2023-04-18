<?php
    require_once 'db_connection.php';

    <!DOCTYPE html>
    <html>
        <head>
            <title>Iniciar sesión - Gestión de Eventos</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
            <link rel="stylesheet" href="login.css">
        </head>
        <body>
            <div class="container">
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
                    <button type="submit" class="btn btn-default">Iniciar sesión</button>
                </form>
            </div>
        </body>
    </html>
?>