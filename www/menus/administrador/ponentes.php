<?php
    require_once '../../db_connection.php';
    
    $sql = "SELECT u.Id_usuario as id, u.Username as username, p.Nombre as nombre, p.Apellido1 as apellido1, p.Apellido2 as apellido2 
        FROM Usuarios u 
        INNER JOIN Personas p ON u.Id_Persona = p.Id_persona 
        WHERE u.Id_tipo_usuario = 3";

    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ponentes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .container {
            margin-top: 30px;
        }
        h1 {
            margin-bottom: 30px;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#deletePonenteModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const id = $('#id_persona').val();

                const modal = $(this);
                modal.find('#delete_id').val(id);
            });
        });
    </script>

</head>
<body>
    <div class="container-fluid">
        <div class="row align-items-center header">
            <div class="col">
                <h3 class="text-primary"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
            </div>
            <div class="col-auto d-flex">
                <a href="menu-administrador.php" class="btn btn-secondary mr-2">Volver atrás</a>
                <a href="../../logout.php" class="btn btn-secondary">Cerrar sesión</a>
            </div>
        </div>
            <div class="container">
            <h1 class="text-center">Gestión de Ponentes</h1>
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary btn-block mb-3" data-toggle="modal" data-target="#addPonenteModal">Añadir Ponente</button>
                </div>
                <div class="col-md-9">
                    <form action="modificar_ponente.php" method="POST" class="mb-3">
                        <div class="form-group">
                            <label for="id_persona">ID del Ponente:</label>
                            <input type="number" class="form-control" id="id_persona" name="id_persona" required>
                        </div>
                        <button type="submit" class="btn btn-warning" name="action" value="modify">Modificar Ponente</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePonenteModal">Eliminar Ponente</button>
                    </form>
                </div>
            </div>
            <div class="row">
            <div class="col">
                <h2 class="text-center">Lista de Ponentes</h2>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de usuario</th>
                            <th>Nombre</th>
                            <th>Primer apellido</th>
                            <th>Segundo apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["nombre"] . "</td>";
                                echo "<td>" . $row["apellido1"] . "</td>";
                                echo "<td>" . $row["apellido2"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron ponentes</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para añadir ponente -->
    <div class="modal fade" id="addPonenteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Añadir Ponente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_ponente_process.php" method="post">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido1">Primer Apellido:</label>
                            <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido2">Segundo Apellido:</label>
                            <input type="text" class="form-control" id="apellido2" name="apellido2" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Nombre de Usuario:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <input type="hidden" name="id_tipo_usuario" value="3">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Añadir Ponente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar ponente -->
    <div class="modal fade" id="deletePonenteModal" tabindex="-1" role="dialog" aria-labelledby="deletePonenteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePonenteModalLabel">Eliminar Ponente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="delete_ponente_process.php" method="POST">
                        <input type="hidden" name="id" id="delete_id" value="">
                        <p>¿Está seguro de que desea eliminar al ponente seleccionado?</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar Ponente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>