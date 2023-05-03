<?php
require_once '../../db_connection.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT u.Id_usuario as id, u.Username as username, p.Nombre as nombre, p.Apellido1 as apellido1, p.Apellido2 as apellido2
            FROM Usuarios u
            INNER JOIN Personas p ON u.Id_Persona = p.Id_persona
            WHERE u.Id_tipo_usuario = 3 AND u.Id_usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
}
