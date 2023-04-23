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

        $usuarios_totales = usuariosTotales()+1; 

        // Insertar el usuario en la base de datos
        $query1 = "INSERT INTO Personas ( Nombre, Apellido1, Apellido2) VALUES ('$nombre', '$apellido1', '$apellido2')";
        $result1 = mysqli_query($conn, $query1);

        if($conn->query($query1)) {
            echo "<p>Usuario insertado con éxito</p>";
        } else {
            echo "<p>Hubo un error al ejecutar la sentencia de inserción: {$conn->error}</p>";
        }


        $query2 = "INSERT INTO Usuarios (Username, Password)   VALUES ('$username', '$password')";
        
        if($conn->query($query2)) {
            echo "<p>Registro insertado con éxito</p>";
        } else {
            echo "<p>Hubo un error al ejecutar la sentencia de inserción: {$conn->error}</p>";
        }

    } else {
        // Las contraseñas no coinciden
        header('Location: register.php?error=2');
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrando</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
<div class="header">
            <div>
                <h3 style="color:cadetblue;"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
                <button class="boton inicio" onclick="window.location.href='index.php'"> Home </button>
            </div>
            
            <div class="botones"> 
                <button class="boton registro" onclick="window.location.href='registro.php'"> Registro </button> 
                <button class="boton acceso" onclick="window.location.href='login.php'"> Acceso </button> 
            </div>
        </div>
<div class="registrando">
    <p> Accede a tu panel desde acceso </p> 
</div>
</body>
</html>
