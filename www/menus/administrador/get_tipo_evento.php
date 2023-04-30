<?php
require_once '../../db_connection.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $sql = "SELECT * FROM Tipo_acto WHERE Id_tipo_acto = ?";
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
?>
