<?php
require_once("../../db_connection.php");

// Recuperar valores del formulario
$descripcion = $_POST['descripcion'];

// Insertar en la tabla Tipo_acto
$sql = "INSERT INTO Tipo_acto (Descripcion) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $descripcion);

if ($stmt->execute()) {
  // Redirigir a la página de eventos
  header("Location: tipos_eventos.php?success=Tipo de evento creado con éxito");
} else {
  // Redirigir a la página de eventos con un mensaje de error
  header("Location: tipos_eventos.php?error=Error al crear el tipo de evento");
}

// Cerrar las conexiones
$stmt->close();
$conn->close();
?>
