<?php
header('Content-Type: application/json');
session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
$user_id = $_SESSION['user_id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

$conn = conexion();

switch($_GET['accion']){
    case 'listar':
        $datos = mysqli_query($conn, "SELECT Id_acto as id,  Fecha as start, Hora, Fecha, Hora, Titulo as title, Descripcion_corta, Descripcion_larga,
                                    Num_asistentes, Id_tipo_acto FROM Actos WHERE Id_acto NOT IN (SELECT b.id_acto 
                                    FROM Inscritos b, Personas c WHERE b.Id_persona = $user_id) AND Id_acto NOT IN 
                                    (SELECT d.Id_acto FROM Lista_Ponentes d, Personas c WHERE d.Id_persona = $user_id);");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        
        break;

    case 'listarActosInscrito':
        $datos = mysqli_query($conn, "SELECT Id_acto as id, Fecha as start, Hora, Titulo as title, Descripcion_corta, 
                                        Descripcion_larga, Num_asistentes, Id_tipo_acto FROM Actos WHERE Id_acto IN 
                                        (SELECT b.id_acto FROM Inscritos b, Personas c WHERE b.Id_persona = $user_id);");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;
    
    case 'listarActosPonente':
        $datos = mysqli_query($conn, "SELECT Id_acto as id, Fecha as start, Hora, Titulo as title, Descripcion_corta, 
                                        Descripcion_larga, Num_asistentes, Id_tipo_acto FROM Actos WHERE Id_acto IN 
                                        (SELECT d.Id_acto FROM Lista_Ponentes d, Personas c WHERE d.Id_persona = $user_id);");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;
}

?>