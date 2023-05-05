<?php
require_once '../../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_persona = $_POST['id_persona'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    // Agrega otros campos según sea necesario

    $sql = "UPDATE Personas SET Nombre = '$nombre', Apellido1 = '$apellido1', Apellido2 = '$apellido2' WHERE Id_persona = $id_persona";
    $result = $conn->query($sql);

    if ($result) {
        header('Location: ponentes.php?message=Ponente actualizado exitosamente');
    } else {
        header('Location: ponentes.php?message=Error al actualizar el ponente: ' . $conn->error);
    }} else {
        header('Location: ponentes.php');
        exit;
    }
    
    $conn->close();
