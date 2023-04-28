<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

// Leer datos de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];
$acto_id = $data['evento_id'];

// Insertar inscripción en la base de datos
$query = "INSERT INTO Inscritos (Id_persona, id_acto, Fecha_inscripcion) VALUES (?, ?, NOW())";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ii', $user_id, $acto_id);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "error";
}
?>