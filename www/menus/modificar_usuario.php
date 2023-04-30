
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = conexion();
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];

    $sql1 = "UPDATE Personas SET Nombre = '$nombre', Apellido1 = '$apellido1', Apellido2 = '$apellido2' WHERE Id_persona = $user_id";
    $result1 = $conn->query($sql1);

    $sql2 = "UPDATE Usuarios SET Username = '$username' WHERE Id_persona = $user_id";
    $result2 = $conn->query($sql);

    $sql3 = "SELECT u.Id_usuario as id, u.Username as username, u.Password as contrasena, p.Nombre as nombre, p.Apellido1 as apellido1, p.Apellido2 as apellido2 
    FROM Usuarios u 
    INNER JOIN Personas p ON u.Id_Persona = p.Id_persona 
    WHERE u.Id_usuario = $user_id";

    $result3 = $conn->query($sql3);
    
    if (!$result3) {
        printf("Error en la consulta: %s\n", mysqli_error($conn));
        exit;
    }
    $user = mysqli_fetch_assoc($result3);

    $conn->close();
}

?>