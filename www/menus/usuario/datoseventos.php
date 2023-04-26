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

// Obtener id de usuario


switch($_GET['accion']){
    case 'listar':
        $datos = mysqli_query($conn, "SELECT Id_acto, Fecha as start, Hora, Titulo as title, Descripcion_corta, Descripcion_larga,
                                    Num_asistentes, Id_tipo_acto FROM Actos WHERE Id_acto NOT IN (SELECT b.id_acto 
                                    FROM Inscritos b, Personas c WHERE b.Id_persona = c.Id_persona) AND Id_acto NOT IN 
                                    (SELECT d.Id_acto FROM Lista_Ponentes d, Personas c WHERE d.Id_persona = c.Id_persona);");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        //SELECT * FROM Actos WHERE Id_acto NOT IN (SELECT b.id_acto FROM Inscritos b, Personas c WHERE b.Id_persona = c.Id_persona);

        break;

    case 'agregar';
        $res = mysqli_query($conn, "INSERT INTO Tipo_acto (Descripcion) VALUES ('$_POST[Descripcion]')");
        $id_tipo_acto_query = mysqli_query($conn, "SELECT Id_tipo_acto FROM Tipo_acto WHERE Descripcion = '$_POST[Descripcion]'");
        $id_tipo_acto = mysqli_fetch_assoc($id_tipo_acto_query);
        $id = $id_tipo_acto["Id_tipo_acto"];
        $respuesta = mysqli_query($conn, "INSERT INTO Actos (Fecha, Hora, Titulo, Descripcion_corta, Descripcion_larga, Num_asistentes, Id_tipo_acto) VALUES
            ('$_POST[Fecha]', '$_POST[HoraInicio]', '$_POST[Titulo]', '$_POST[Descripcion_corta]', '$_POST[Descripcion_larga]',
            '$_POST[Num_asistentes]',  '$id')");
        
        echo json_encode($respuesta);
        break;
       
    case 'modificar';
        echo "modificar!";
        break;
        
    case 'borrar':
        echo "borrar!";
        break;

    case 'listarActosInscrito':
        $datos = mysqli_query($conn, "SELECT Id_acto, Fecha as start, Hora, Titulo as title, Descripcion_corta, 
                                        Descripcion_larga, Num_asistentes, Id_tipo_acto FROM Actos WHERE Id_acto IN 
                                        (SELECT b.id_acto FROM Inscritos b, Personas c WHERE b.Id_persona = c.Id_persona);");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;
    
    case 'listarActosPonente':
        $datos = mysqli_query($conn, "SELECT Id_acto, Fecha as start, Hora, Titulo as title, Descripcion_corta, 
                                        Descripcion_larga, Num_asistentes, Id_tipo_acto FROM Actos WHERE Id_acto IN 
                                        (SELECT d.Id_acto FROM Lista_Ponentes d, Personas c WHERE d.Id_persona = c.Id_persona);");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;
}

?>