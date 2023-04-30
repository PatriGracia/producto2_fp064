<?php
// Conexión a la base de datos
require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';
$conn = conexion();

// Recuperar y validar los datos del formulario
$name = trim($_POST['name']);
$apellido1 = trim($_POST['apellido1']);
$apellido2 = trim($_POST['apellido2']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$password_confirm = trim($_POST['password_confirm']);

// Asignar el Id_tipo_usuario para el tipo "Usuario"
$id_tipo_usuario = 2; // Reemplaza el 2 por el Id_tipo_usuario correspondiente al tipo "Usuario" en tu tabla Tipos_usuarios

if ($password === $password_confirm) {
    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar la persona en la tabla Personas
    $query = "INSERT INTO Personas (Nombre, Apellido1, Apellido2) VALUES ('$name', '$apellido1', '$apellido2')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Obtener el Id_persona recién creado
        $id_persona = mysqli_insert_id($conn);

        // Insertar el usuario en la base de datos con el tipo de usuario predeterminado
        $query = "INSERT INTO Usuarios (Username, Password, Id_tipo_usuario, Id_persona) VALUES ('$username', '$hashed_password', $id_tipo_usuario, $id_persona)";
        $result = mysqli_query($conn, $query);
        if ($result) {
            // Redirigir a la página de inicio de sesión con éxito
            header('Location: login.php?success=1');
        } else {
            // Error al insertar el usuario
            header('Location: register.php?error=1');
        }
    } else {
        // Error al insertar la persona
        header('Location: register.php?error=3');
    }
    } else {
        // Las contraseñas no coinciden
        header('Location: register.php?error=2');
    }
    
    mysqli_close($conn);
    ?>