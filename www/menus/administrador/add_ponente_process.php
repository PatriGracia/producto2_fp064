<?php
require_once("../../db_connection.php");
$conn = conexion();

// Recuperar valores del formulario
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$username = $_POST['username'];
$password = $_POST['password'];
$id_tipo_usuario = $_POST['id_tipo_usuario'];

// Insertar en la tabla Personas
$sql = "INSERT INTO Personas (Nombre, Apellido1, Apellido2) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nombre, $apellido1, $apellido2);

if ($stmt->execute()) {
  $id_persona = $conn->insert_id; // Obtener el ID generado
// Insertar en la tabla Usuarios
$sql2 = "INSERT INTO Usuarios (Username, Password, Id_Persona, Id_tipo_usuario) VALUES (?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
$password_hashed = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña antes de guardarla
$stmt2->bind_param("ssii", $username, $password_hashed, $id_persona, $id_tipo_usuario);

if ($stmt2->execute()) {
  // Redirigir a la página de ponentes
  header("Location: ponentes.php?success=Ponente creado con éxito");
} else {
  // Redirigir a la página de ponentes con un mensaje de error
  header("Location: ponentes.php?error=Error al crear el usuario del ponente");
}
} else {
// Redirigir a la página de ponentes con un mensaje de error
header("Location: ponentes.php?error=Error al crear el ponente");
}

// Cerrar las conexiones
$stmt->close();
$stmt2->close();
$conn->close();