<?php
require_once '../../db_connection.php';

$sql = "SELECT * FROM Tipo_acto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Tipos de Eventos</title>
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
        $('#modifyTipoEventoModal').on('show.bs.modal', function (event) {
            const id = $('#id_tipo_acto').val();
            if (!id) {
                event.preventDefault();
                alert('Por favor, ingrese el ID del tipo de evento.');
            } else {
                $.ajax({
                    url: 'get_tipo_evento.php',
                    method: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (data) {
                        if (data) {
                            $('#modify_id').val(data.Id_tipo_acto);
                            $('#modify_descripcion').val(data.Descripcion);
                        } else {
                            event.preventDefault();
                            alert('No se encontró el tipo de evento con el ID proporcionado.');
                        }
                    },
                    error: function () {
                        event.preventDefault();
                        alert('Error al obtener datos del tipo de evento.');
                    }
                });
            }
        });

        $('#modifyTipoEventoForm').on('submit', function (event) {
            event.preventDefault();
            const id = $('#modify_id').val();
            const descripcion = $('#modify_descripcion').val();

            $.ajax({
                url: 'modify_tipo_evento.php',
                method: 'POST',
                data: { id: id, descripcion: descripcion },
                success: function (response) {
                    location.reload();
                },
                error: function () {
                    alert('Error al modificar el tipo de evento.');
                }
            });
        });

        $('#deleteTipoEventoModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = $('#id_tipo_acto').val();

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
            <h1 class="text-center">Gestión de Tipos de Eventos</h1>
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary btn-block mb-3" data-toggle="modal" data-target="#addTipoEventoModal">Añadir Tipo de Evento</button>
                </div>
                <div class="col-md-9">
                    <form class="mb-3">
                        <div class="form-group">
                            <label for="id_tipo_acto">ID del Tipo de Evento:</label>
                            <input type="number" class="form-control" id="id_tipo_acto" name="id_tipo_acto">
                        </div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modifyTipoEventoModal">Modificar</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteTipoEventoModal">Eliminar</button>
                    </form>
                </div>
            </div>
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["Id_tipo_acto"] . "</td>";
                            echo "<td>" . $row["Descripcion"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No hay registros disponibles</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
                </table>
            </div>
        </div>
    <!-- Modal para añadir tipo de evento -->
    <div class="modal fade" id="addTipoEventoModal" tabindex="-1" role="dialog" aria-labelledby="addTipoEventoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="add_tipo_evento.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTipoEventoModalLabel">Añadir Tipo de Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Añadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para modificar tipo de evento -->
    <div class="modal fade" id="modifyTipoEventoModal" tabindex="-1" role="dialog" aria-labelledby="modifyTipoEventoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="modifyTipoEventoForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modifyTipoEventoModalLabel">Modificar Tipo de Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="modify_id">ID:</label>
                            <input type="number" class="form-control" id="modify_id" name="modify_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="modify_descripcion">Descripción:</label>
                            <input type="text" class="form-control" id="modify_descripcion" name="modify_descripcion" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar tipo de evento -->
    <div class="modal fade" id="deleteTipoEventoModal" tabindex="-1" role="dialog" aria-labelledby="deleteTipoEventoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="delete_tipo_evento.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteTipoEventoModalLabel">Eliminar Tipo de Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que desea eliminar este tipo de evento?</p>
                        <input type="hidden" id="delete_id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
