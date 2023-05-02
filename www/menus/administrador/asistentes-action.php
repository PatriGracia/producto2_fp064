<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';
$conn = conexion();

$action = isset($_POST['action']) ? $_POST['action'] : '';
$evento_id = isset($_POST['evento_id']) ? $_POST['evento_id'] : '';
$num_asistentes = isset($_POST['num_asistentes']) ? $_POST['num_asistentes'] : '';

if ($action == 'add') {
    $sql = "UPDATE eventos SET num_asistentes = num_asistentes + ? WHERE id = ?";
} elseif ($action == 'remove') {
    $sql = "UPDATE eventos SET num_asistentes = num_asistentes - ? WHERE id = ?";
} else {
    echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
    exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $num_asistentes, $evento_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Asistentes actualizados correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar asistentes']);
}

$stmt->close();
$conn->close();
