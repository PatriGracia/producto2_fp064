<?php
require_once '../../db_connection.php';
$conn = conexion();
$id = $_POST['id'];

// Obtener el Id_Persona antes de eliminar el registro en Usuarios
$sql = "SELECT Id_Persona FROM Usuarios WHERE Id_usuario = $id AND Id_tipo_usuario = 3";
$result = $conn->query($sql);
$id_persona = -1;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_persona = $row['Id_Persona'];
} else {
    header('Location: ponentes.php?message=Error al encontrar el ponente');
    exit();
}

// Eliminar el registro en la tabla Usuarios
$sql = "DELETE FROM Usuarios WHERE Id_usuario = $id AND Id_tipo_usuario = 3";
$result = $conn->query($sql);

if (!$result) {
    header('Location: ponentes.php?message=Error al eliminar el ponente de la tabla Usuarios');
    exit();
}

// Eliminar el registro en la tabla Personas
$sql = "DELETE FROM Personas WHERE Id_persona = $id_persona";
$result = $conn->query($sql);

if ($result) {
    header('Location: ponentes.php?message=Ponente eliminado exitosamente');
} else {
    header('Location: ponentes.php?message=Error al eliminar el ponente de la tabla Personas');
}

$conn->close();
?>