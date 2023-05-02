<?php
header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

$conn = conexion();

function get_all_tipo_acto($conn) {
    $stmt = $conn->prepare("SELECT Id_tipo_acto, Descripcion FROM Tipo_acto");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

switch ($_GET['accion']) {
    case 'listar':
        $stmt = $conn->prepare("SELECT Id_acto,
                Fecha as start,
                Hora,
                Titulo as title,
                Descripcion_corta,
                Descripcion_larga,
                Num_asistentes,
                Id_tipo_acto
                FROM Actos");
        $stmt->execute();
        $result = $stmt->get_result();
        $resultado = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;

    case 'agregar':
        $stmt = $conn->prepare("INSERT INTO Actos (Fecha, Hora, Titulo, Descripcion_corta, Descripcion_larga, Num_asistentes, Id_tipo_acto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssii", $_POST['Fecha'], $_POST['HoraInicio'], $_POST['Titulo'], $_POST['Descripcion_corta'], $_POST['Descripcion_larga'], $_POST['Num_asistentes'], $_POST['Id_tipo_acto']);
        $respuesta = $stmt->execute();
        
        echo json_encode(['success' => $respuesta]);
        break;

    case 'modificar':
        $stmt = $conn->prepare("UPDATE Actos SET Fecha = ?, Hora = ?, Titulo = ?, Descripcion_corta = ?, Descripcion_larga = ?, Num_asistentes = ?, Id_tipo_acto = ? WHERE Id_acto = ?");
        $stmt->bind_param("sssssiii", $_POST['Fecha'], $_POST['HoraInicio'], $_POST['Titulo'], $_POST['Descripcion_corta'], $_POST['Descripcion_larga'], $_POST['Num_asistentes'], $_POST['Id_tipo_acto'], $_POST['id']);
        $result = $stmt->execute();

        echo json_encode(['success' => $result]);
        break;

    case 'borrar':
        $stmt = $conn->prepare("DELETE FROM Actos WHERE Id_acto = ?");
        $stmt->bind_param("i", $_POST['id']);
        $result = $stmt->execute();

        echo json_encode(['success' => $result]);
        break;
}
?>