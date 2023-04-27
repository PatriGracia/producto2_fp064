<?php
require_once '../../db_connection.php';

$id = $_POST['id'];

$sql = "DELETE FROM Usuarios WHERE Id_usuario = $id AND Id_tipo_usuario = 3";
$result = $conn->query($sql);

if ($result) {
    header('Location: ponentes.php?message=Ponente eliminado exitosamente');
} else {
    header('Location: ponentes.php?message=Error al eliminar el ponente');
}

$conn->close();
?>