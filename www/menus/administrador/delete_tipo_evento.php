<?php
require_once '../../db_connection.php';

$id = $_POST['id'];

$sql = "DELETE FROM Tipo_acto WHERE Id_tipo_acto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  header('Location: tipos_eventos.php?message=Tipo de evento eliminado exitosamente');
} else {
  header('Location: tipos_eventos.php?message=Error al eliminar el tipo de evento');
}

$conn->close();
?>