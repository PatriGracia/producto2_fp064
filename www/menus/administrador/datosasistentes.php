<?php
header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

$conn = conexion();

switch ($_GET['accion']) {
    case 'agregar_inscrito':
        $stmt = $conn->prepare("INSERT INTO Inscritos (Id_persona, id_acto, Fecha_inscripcion) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $_POST['Id_persona'], $_POST['id_acto'], $_POST['Fecha_inscripcion']);
        $respuesta = $stmt->execute();

        echo json_encode(['success' => $respuesta]);
        break;

    case 'eliminar_inscrito':
        $stmt = $conn->prepare("DELETE FROM Inscritos WHERE Id_inscripcion = ?");
        $stmt->bind_param("i", $_POST['Id_inscripcion']);
        $respuesta = $stmt->execute();

        echo json_encode(['success' => $respuesta]);
        break;

    case 'modificar_asistentes':
        $stmt = $conn->prepare("UPDATE Actos SET Num_asistentes = ? WHERE Id_acto = ?");
        $stmt->bind_param("ii", $_POST['Num_asistentes'], $_POST['Id_acto']);
        $respuesta = $stmt->execute();

        echo json_encode(['success' => $respuesta]);
        break;
    
    case 'listar_asistentes': 
        $stmt = $conn->prepare("SELECT p.Id_persona, p.Nombre, p.Apellido1, p.Apellido2 FROM Personas p JOIN Inscritos i ON p.Id_persona = i.Id_persona WHERE i.id_acto = ?");
        $stmt->bind_param('i', $_POST['eventoId']);
        $stmt->execute();
        $result = $stmt->get_result();
        $asistentes = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($asistentes);
        break;

    
    case 'listar_usuarios':
        $stmt = $conn->prepare("SELECT * FROM Usuarios");
        $stmt->execute();
        $result = $stmt->get_result();
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode(['success' => true, 'usuarios' => $usuarios]);
        break;
}
?>
