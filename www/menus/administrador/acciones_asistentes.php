<?php
header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

$conn = conexion();

switch ($_GET['accion']) {
    case 'listar':
        $stmt = $conn->prepare("SELECT I.Id_inscripcion, P.Nombre, P.Apellido1, P.Apellido2, A.Titulo FROM Inscritos I INNER JOIN Personas P ON I.Id_persona = P.Id_persona INNER JOIN Actos A ON I.id_acto = A.Id_acto");
        $stmt->execute();
        $result = $stmt->get_result();
        $asistentes = $result->fetch_all(MYSQLI_ASSOC);
        
        echo json_encode($asistentes);
        break;

    case 'agregar':
        $stmt = $conn->prepare("INSERT INTO Inscritos (Id_persona, id_acto, Fecha_inscripcion) VALUES (?, ?, ?)");
        $fecha_inscripcion = date('Y-m-d H:i:s');
        $stmt->bind_param("iis", $_POST['Id_persona'], $_POST['id_acto'], $fecha_inscripcion);
        $respuesta = $stmt->execute();
        
        if ($respuesta) {
            $stmt = $conn->prepare("UPDATE Actos SET Num_asistentes = Num_asistentes + 1 WHERE Id_acto = ?");
            $stmt->bind_param("i", $_POST['id_acto']);
            $stmt->execute();
        }

        echo json_encode(['success' => $respuesta]);
        break;

    case 'eliminar':
        $stmt = $conn->prepare("DELETE FROM Inscritos WHERE Id_inscripcion = ?");
        $stmt->bind_param("i", $_POST['Id_inscripcion']);
        $result = $stmt->execute();

        if ($result) {
            $stmt = $conn->prepare("UPDATE Actos SET Num_asistentes = Num_asistentes - 1 WHERE Id_acto = ?");
            $stmt->bind_param("i", $_POST['id_acto']);
            $stmt->execute();
        }

        echo json_encode(['success' => $result]);
        break;

        case 'actualizar_cantidad':
            $stmt = $conn->prepare("UPDATE Actos SET Num_asistentes = ? WHERE Id_acto = ?");
            $stmt->bind_param("ii", $_POST['Num_asistentes'], $_POST['id_acto']);
            $result = $stmt->execute();
        
            echo json_encode(['success' => $result]);
            break;
    }
?>