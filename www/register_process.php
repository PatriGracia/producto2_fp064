<?php
    // Conexión a la base de datos
    include "db_connection.php";
    $conn = conexion();

    // Recuperar y validar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellido1 = trim($_POST['apellido1']);
    $apellido2 = trim($_POST['apellido2']);
    $password = trim($_POST['password']);
    $username = trim ($_POST['username']);
    $password_confirm = trim($_POST['password_confirm']);

    if ($password === $password_confirm) {
        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el usuario en la base de datos
        $query1 = "INSERT INTO Personas (Nombre, Apellido1, Apellido2) VALUES ('$nombre', '$apellido1', '$apellido2')";
        $result1 = mysqli_query($conn, $query1);

        if($result1) {
            $last_person_id = mysqli_insert_id($conn);
        } else {
            header('Location: register.php?error=1');
        }

        // Asignar el tipo de usuario por defecto (en este caso, 2)
        $default_user_type = 2;

        $query2 = "INSERT INTO Usuarios (Id_persona, Username, Password, Id_tipo_usuario) VALUES ('$last_person_id', '$username', '$hashed_password', '$default_user_type')";
        
        if($conn->query($query2)) {
            header('Location: index.php');
        } else {
            header('Location: register.php?error=3');
        }

    } else {
        // Las contraseñas no coinciden
        header('Location: register.php?error=2');
    }

    $conn->close();
?>