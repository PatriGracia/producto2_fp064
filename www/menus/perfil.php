<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

    $conn = conexion();

    // Obtener el nombre del usuario
    $user_id = $_SESSION['user_id'];
    $query = "SELECT Personas.Nombre FROM Usuarios INNER JOIN Personas ON Usuarios.Id_Persona = Personas.Id_persona WHERE Usuarios.Id_usuario = $user_id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        printf("Error en la consulta: %s\n", mysqli_error($conn));
        exit;
    }
    $user = mysqli_fetch_assoc($result);
    $user_name = $user['Nombre'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/propiedades-comundes.css">
    <link rel="stylesheet" href="propiedades-comundes.css">
</head>
<body>
    <!-- HEADER --> 
    <div class="container-fluid">
        <div class="row align-items-center header">
            <div class="col">
                <h3 style="color:cadetblue;"><strong>Grupo PSMD</strong></h3>
                <h4 class="nombre-proyecto">Gestión de Eventos - Perfil de Usuario</h4>
            </div>
            <div class="col-auto d-flex">
                <button class="btn btn-danger" id="volver">Volver</button>
                <button class="btn btn-primary log-out" id="logoutButton">Log Out</button>
            </div>
        </div>
    </div>

    <!-- Cuerpo --> 
    <div class="perfil"> 
        <p> Usuario: </p> 
        <p> Correo Electrónico: </p>
        <p> Contraseña: </p> 


    </div> 






    <script>
        document.getElementById("logoutButton").addEventListener("click", function() {
            window.location.href = "/logout.php";
        });
    </script>

    <script>
        document.getElementById("volver").addEventListener("click", function() {
            window.history.back();
        });
    </script>

</body>
</html>