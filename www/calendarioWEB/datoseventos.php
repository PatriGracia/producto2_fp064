<?php
header('Content-Type: application/json');

require("../db_connection.php");

switch($_GET['accion']){
    case 'listar':
        $datos = mysqli_query($conn, "SELECT Id_acto,
                Fecha as start,
                Hora,
                Titulo as title,
                Descripcion_corta,
                Descripcion_larga,
                Num_asistentes,
                Id_tipo_acto
                FROM Actos");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);

        break;

    case 'agregar';
        /*"INSERT INTO Tipo_acto (Descripcion) VALUES ('$_POST[Descripcion]')";
        $descripcion = "SELECT Id_tipo_acto FROM Tipo_acto WHERE Descripcion = '$_POST[Descripcion]'";
        "INSERT INTO Actos (Fecha, Hora, Titulo, Descripcion_corta, Descripcion_larga, Num_asistentes, Id_tipo_acto) VALUES
            ('$_POST[Fecha]', '$_POST[Hora]', '$_POST[Titulo]', '$_POST[Descripcion_corta]', '$_POST[Descripcion_larga]',
            '$_POST[Num_asistentes]',  '$descripcion')";*/
        break;
       
    case 'modificar';
        echo "modificar!";
        break;
        
    case 'borrar':
        echo "borrar!";
        break;
}

?>