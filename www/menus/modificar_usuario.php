<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

$conn = conexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    if ($password === $password_confirm) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql1 = "UPDATE Personas SET Nombre = '$nombre', Apellido1 = '$apellido1', Apellido2 = '$apellido2' WHERE Id_persona = $user_id";
        $result1 = $conn->query($sql1);

        $sql2 = "UPDATE Usuarios SET Username = '$username', Password = '$hashed_password' WHERE Id_persona = $user_id";
        $result2 = $conn->query($sql2);

        if($result1 && $result2){
            header('Location: perfil.php');
            exit;
        }else{
            echo '<script language="javascript">alert("Usuario no se ha podido modificar");</script>';
        }
        
        $conn->close();
    }else {
        printf("Password no confirmada");
    }    
} else {
    printf("No se ha podido modificar datos de usuario");
    header('Location: login.php');
    exit;
}

?>