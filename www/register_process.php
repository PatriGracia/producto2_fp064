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

        if($conn->query($query1)) {
            echo "<p>Registro insertado con éxito</p>";
        } else {
            echo "<p>Hubo un error al ejecutar la sentencia de inserción: {$conn->error}</p>";
        }


        $query2 = "INSERT INTO Usuarios (Username, Password) VALUES ('$username', '$password')";
        
        if($conn->query($query2)) {
            echo "<p>Registro insertado con éxito</p>";
        } else {
            echo "<p>Hubo un error al ejecutar la sentencia de inserción: {$conn->error}</p>";
        }

    } else {
        // Las contraseñas no coinciden
        header('Location: register.php?error=2');
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrando</title>
</head>
<style>
    .registrando{
        display:flex;
        justify-content: center;
        font-size:40px;
        padding: 50px;
    }
</style>
<body>
<div class="registrando">
    Registrando... 
</div>
</body>
</html>
