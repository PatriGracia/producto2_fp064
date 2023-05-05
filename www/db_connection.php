<?php
    // Configuración de la conexión a la base de datos
    $servername = "db";
    $username = "root";
    $password = "test";
    $dbname = "Eventos";
    $port = "3306";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("La conexión a la base de datos ha fallado: " . $conn->connect_error);
    }
    function conexion() {
        $conn = new mysqli('db', "root", "test", "Eventos", 3306);
        if ($conn->connect_errno) {
            echo "Error de conexión con la base de datos: " . $conn->connect_errno;
            exit;
        }
        return $conn;
    }
    
?>