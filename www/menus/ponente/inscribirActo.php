<?php
require_once '../../db_connection.php';
header('Content-Type: application/json');
session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
$user_id = $_SESSION['user_id'];

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $resultado = mysqli_query($conn, "INSERT INTO Inscritos (Id_persona, id_acto, Fecha_inscripcion) VALUES ($user_id, $id, NOW())");
        
    echo json_encode($resultado);

} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
}

?>