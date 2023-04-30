<?php
session_start();
require_once '../../db_connection.php';

if (isset($_POST['id']) && isset($_POST['descripcion'])) {
  $id = $_POST['id'];
  $descripcion = $_POST['descripcion'];

  $sql = "UPDATE Tipo_acto SET Descripcion = ? WHERE Id_tipo_acto = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $descripcion, $id);

  if ($stmt->execute()) {
    $_SESSION['message'] = "Tipo de evento actualizado exitosamente.";
    $_SESSION['message_type'] = 'success';
  } else {
    $_SESSION['message'] = "Error al actualizar el tipo de evento.";
    $_SESSION['message_type'] = 'danger';
  }
} else {
  $_SESSION['message'] = "Todos los campos son obligatorios.";
  $_SESSION['message_type'] = 'danger';
}

header("Location: tipos_eventos.php");
?>