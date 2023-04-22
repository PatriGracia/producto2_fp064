<?php
    // Configuración de la conexión a la base de datos
    $servername = "db";
    $username = "root";
    $password = "test";
    $dbname = "Eventos";
    $port = "3306";

    function conexion() {
        $conn = new mysqli('db', "root", "test", "Eventos", 3306);
        if ($conn->connect_errno) {
            echo "Error de conexión con la base de datos: " . $conn->connect_errno;
            exit;
        }
        return $conn;
    }

    $usuarios_totales; 
    


?>