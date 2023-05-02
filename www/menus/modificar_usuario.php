
<?php
require_once '../../db_connection.php';
header('Content-Type: application/json');
session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
$user_id = $_SESSION['user_id'];

// Recuperar y validar los datos del formulario
$nombre= trim($_POST['nombre']);
$apellido1 = trim($_POST['apellido1']);
$apellido2 = trim($_POST['apellido2']);
$username = trim($_POST['username']);

    $sql1 = "UPDATE Personas SET Nombre = '$nombre', Apellido1 = '$apellido1', Apellido2 = '$apellido2' WHERE Id_persona = $user_id";
    $result1 = $conn->query($sql1);

    if ($result1) {
        // Redirigir a la página de inicio de sesión con éxito
        $sql2 = "UPDATE Usuarios SET Username = '$username' WHERE Id_persona = $user_id";
        $result2 = $conn->query($sql);
        if ($result2) {
            // Redirigir a la página de inicio de sesión con éxito
            header('Location: perfil.php?success=1');
        }
    }

    $conn->close();


?>