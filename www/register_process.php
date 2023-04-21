<?php
    // Conexión a la base de datos
    require_once 'db_connection.php';

    // Recuperar y validar los datos del formulario
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

    if ($password === $password_confirm) {
        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el usuario en la base de datos
        $query = "INSERT INTO usuarios (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirigir a la página de inicio de sesión con éxito
            header('Location: login.php?success=1');
        } else {
            // Error al insertar el usuario
            header('Location: register.php?error=1');
        }
    } else {
        // Las contraseñas no coinciden
        header('Location: register.php?error=2');
    }

    mysqli_close($conn);
?>