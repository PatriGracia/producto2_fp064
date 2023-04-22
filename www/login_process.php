<?php
    // Conexión a la base de datos
    require_once 'db_connection.php';

    // Recuperar y validar los datos del formulario
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $tipo_usuario; 

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