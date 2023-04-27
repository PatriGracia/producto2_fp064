<?php
// Conexión a la base de datos
require_once 'db_connection.php';


#include 'db_conection.php';
$conn = conexion();


// Recuperar y validar los datos del formulario
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Consultar el usuario en la base de datos
$query = "SELECT Usuarios.*, Tipos_usuarios.Descripcion as TipoUsuario FROM Usuarios INNER JOIN Tipos_usuarios ON Usuarios.Id_tipo_usuario = Tipos_usuarios.Id_tipo_usuario WHERE Username = '$username'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Verificar la contraseña
    if (password_verify($password, $user['Password'])) {
        // Iniciar sesión y redirigir al panel de usuario
        session_start();
        $_SESSION['user_id'] = $user['Id_usuario'];

        // Verificar el tipo de usuario y redirigir a la página correspondiente
        $tipo_usuario = $user['TipoUsuario'];
        if ($tipo_usuario == 'Administrador') {
            header('Location: menus/administrador/eventos.php');
        } elseif ($tipo_usuario == 'Usuario') {
            header('Location: menus/usuario/menu-usuario.php');
        } elseif ($tipo_usuario == 'Ponente') {
            header('Location: menus/ponente/menu-ponente.php');
        } else {
            // Tipo de usuario desconocido
            header('Location: login.php?error=3');
        }
    } else {
        // Contraseña incorrecta
        header('Location: login.php?error=1');
    }
} else {
    // El nombre de usuario no existe
    header('Location: login.php?error=2');
}

mysqli_close($conn);
?>