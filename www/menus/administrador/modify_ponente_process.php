<?php
session_start();
require_once '../../db_connection.php';
$conn = conexion();

if (
    isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apellido1']) &&
    isset($_POST['apellido2']) && isset($_POST['username'])
) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $username = $_POST['username'];

    $sql = "UPDATE Usuarios u
            JOIN Personas p ON u.Id_Persona = p.Id_persona
            SET u.Username = ?, p.Nombre = ?, p.Apellido1 = ?, p.Apellido2 = ?
            WHERE u.Id_usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $username, $nombre, $apellido1, $apellido2, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Ponente actualizado exitosamente.";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "Error al actualizar el ponente.";
        $_SESSION['message_type'] = 'danger';
    }
} else {
    $_SESSION['message'] = "Todos los campos son obligatorios.";
    $_SESSION['message_type'] = 'danger';
}

header("Location: ponentes.php");