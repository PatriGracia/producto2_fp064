<?php
    // Configuración de la conexión a la base de datos
    $servername = "localhost";
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
?>