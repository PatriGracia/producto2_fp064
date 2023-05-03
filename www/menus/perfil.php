<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

    $conn = conexion();

    // Obtener el nombre del usuario
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT u.Id_usuario as id, u.Username as username, u.Password as contrasena, p.Nombre as nombre, p.Apellido1 as apellido1, p.Apellido2 as apellido2 
    FROM Usuarios u 
    INNER JOIN Personas p ON u.Id_Persona = p.Id_persona 
    WHERE u.Id_usuario = $user_id";

    $result = $conn->query($sql);
    
    if (!$result) {
        printf("Error en la consulta: %s\n", mysqli_error($conn));
        exit;
    }
    $user = mysqli_fetch_assoc($result);
    $password = $user["contrasena"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/perfil.css">
</head>

<body>
    <!-- HEADER --> 
    <div class="container-fluid">
        <div class="row align-items-center header">
            <div class="col">
                <h3 style="color:cadetblue;"><strong>Grupo PSMD</strong></h3>
                <h4 class="nombre-proyecto">Gestión de Eventos - Perfil de Usuario</h4>
            </div>
            <div class="col-auto d-flex">
                <button class="btn btn-danger" id="volver">Volver</button>
                <button class="btn btn-primary log-out" id="logoutButton">Log Out</button>
            </div>
        </div>
    </div>

    <!-- Cuerpo --> 
    <div class="perfil-usuario">
    <table class="table table-bordered table-striped col-md-3" >
        <tr>
            <th>Id suario</th>
            <td>
                <?php
                    print $user_id;
                ?> 
            </td>
        </tr>
        <tr>
            <th>Nombre </th>
            <td>
                <?php
                    echo $user["nombre"];
                ?> 
            </td>
        </tr>
        <tr>
            <th>Apellido 1 </th>
            <td>
                <?php
                    echo $user["apellido1"];
                ?> 
            </td>
        </tr>
        <tr>
            <th>Apellido 2 </th>
            <td>
                <?php
                    echo $user["apellido2"];
                ?> 
            </td>
        </tr>
        <tr>
            <th>Usuername </th>
            <td>
                <?php
                    echo $user["username"];
                ?> 
            </td>
        </tr>
        <tr>
            <th>Contraseña</th>
            <td>
                <?php
                    echo $hashed_password;
                ?>

            </td>
        </tr>
    </table>
    <div class="botones" >
        <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modificarUsuario">
                Modificar Usuario
            </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Modificar Contraseña</button>
    </div>

    

    <!-- Modal ModificarUsuario-->
    <div class="modal fade" id="modificarUsuario" tabindex="-1" aria-labelledby="modificarUsuarioModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modificarUsuarioModal">Modificar Usuario</h1>
            </div>
            <div class="modal-body">
                    <form action="modificar_usuario.php" method="POST">
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <label for="modify_username">Username:</label>
                            <input type="text" class="form-control" id="modify_username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="modify_nombre">Nombre:</label>
                            <input type="text" class="form-control" id="modify_nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="modify_apellido1">Apellido 1:</label>
                            <input type="text" class="form-control" id="modify_apellido1" name="apellido1" required>
                        </div>
                        <div class="form-group">
                            <label for="modify_apellido2">Apellido 2:</label>
                            <input type="text" class="form-control" id="modify_apellido2" name="apellido2" required>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-warning">Modificar Usuario</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>










    <script>
        document.getElementById("logoutButton").addEventListener("click", function() {
            window.location.href = "/logout.php";
        });
    </script>

    <script>
        document.getElementById("volver").addEventListener("click", function() {
            window.history.back();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>