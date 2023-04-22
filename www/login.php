<?php
    // Conexión a la base de datos
    require_once 'db_connection.php';

    // Recuperar y validar los datos del formulario
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Consultar el usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Iniciar sesión y redirigir al panel de usuario
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: user_panel.php');
        } else {
            // Contraseña incorrecta
            header('Location: login.php?error=1');
        }
    } else {
        // El correo electrónico no existe
        header('Location: login.php?error=2');
    }

    mysqli_close($conn);
?>
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
                    <div class="form-group" action="login_process.php">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email;?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required value="<?php echo $password;?>">
                    </div>
                    <button type="submit" class="btn btn-default">Iniciar sesión</button>
                </form>
            </div>
        </body>
    </html>
