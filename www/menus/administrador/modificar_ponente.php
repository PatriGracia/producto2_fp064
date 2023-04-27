<?php
require_once("../../db_connection.php");
$conn = conexion();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_persona = $_POST['id_persona'];

    $sql = "SELECT * FROM Usuarios INNER JOIN Personas ON Usuarios.Id_Persona = Personas.Id_persona WHERE Usuarios.Id_Persona = $id_persona AND Usuarios.Id_tipo_usuario = 3";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        header('Location: ponentes.php?message=No se encontró el ponente');
        exit;
    }

    $conn->close();
} else {
    header('Location: ponentes.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Ponente</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
    <div class="container">
        <h2>Modificar Ponente</h2>
        <form action="update_ponente_process.php" method="POST">
            <input type="hidden" name="id_persona" value="<?php echo $row['Id_persona']; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['Nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido1">Apellido1:</label>
                <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo $row['Apellido1']; ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido2">Apellido2:</label>
                <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo $row['Apellido2']; ?>" required>
            </div>
            <!-- Agrega otros campos según sea necesario -->
            <button type="submit" class="btn btn-primary">Actualizar Ponente</button>
        </form>
    </div>
</body>
</html>
