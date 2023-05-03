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
    $query = "SELECT Personas.Nombre FROM Usuarios INNER JOIN Personas ON Usuarios.Id_Persona = Personas.Id_persona WHERE Usuarios.Id_usuario = $user_id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        printf("Error en la consulta: %s\n", mysqli_error($conn));
        exit;
    }
    $user = mysqli_fetch_assoc($result);
    $user_name = $user['Nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/propiedades-comundes.css">
    <link rel="stylesheet" href="../propiedades-comundes.css">
    <!-- Scripts CSS -->
    <link rel="stylesheet" href="../../calendarioWEB/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../calendarioWEB/css/datatables.min.css">
    <link rel="stylesheet" href="../../calendarioWEB/css/bootstrap-clockpicker.css">

    <!-- Scripts JS -->
    <script src="../../calendarioWEB/js/jquery-3.6.4.min.js"></script>
    <script src="../../calendarioWEB/js/popper.min.js"></script>
    <script src="../../calendarioWEB/js/bootstrap.min.js"></script>
    <script src="../../calendarioWEB/js/datatables.min.js"></script>
    <script src="../../calendarioWEB/js/bootstrap-clockpicker.js"></script>
    <script src="../../calendarioWEB/js/moment-with-locales.min.js"></script>
    <script src="../../calendarioWEB/fullcalendar/index.global.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row align-items-center header">
            <div class="col">
                <h3 style="color:cadetblue;"><strong>Grupo PSMD</strong></h3>
                <h4 class="nombre-proyecto">Gestión de Eventos - Panel de Administración</h4>
            </div>
            <div class="col-auto d-flex">
                <button class="btn btn-danger" id="perfil">Perfil</button>
                <button class="btn btn-primary log-out" id="logoutButton">Log Out</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Administración de ponentes</h2>
                <p>Aquí puedes gestionar los ponentes de los eventos.</p>
                <div class="menu-admin">
                    <a href="eventos.php" class="btn btn-primary boton-admin">Gestionar eventos</a>
                    <a href="ponentes.php" class="btn btn-secondary boton-admin">Gestionar ponentes</a>
                    <a href="tipos_eventos.php" class="btn btn-primary boton-admin">Gestionar tipos de eventos</a>
                    <a href="asistentes.php" class="btn btn-primary boton-admin">Gestionar asistentes</a>
                </div>
            </div>
        </div>
        <div id="calendario"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablaPonentes">
                        <thead>
                            <tr>
                                <th>ID Asistente</th>
                                <th>Nombre</th>
                                <th>Apellido1</th>
                                <th>Apellido2</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT P.Id_persona, P.Nombre, P.Apellido1, P.Apellido2 FROM Personas P INNER JOIN Inscritos ON P.Id_persona = Inscritos.Id_persona ORDER BY P.Id_persona";
                            $result = mysqli_query($conn, $query);
                            if (!$result) {
                                printf("Error en la consulta: %s\n", mysqli_error($conn));
                                exit;
                            }
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['Id_persona'] . "</td>";
                                echo "<td>" . $row['Nombre'] . "</td>";
                                echo "<td>" . $row['Apellido1'] . "</td>";
                                echo "<td>" . $row['Apellido2'] . "</td>";
                                echo "<td>
                                        <button class='btn btn-primary btn-sm editarPonente' data-id='" . $row['Id_persona'] . "'>Editar</button>
                                        <button class='btn btn-danger btn-sm eliminarPonente' data-id='" . $row['Id_persona'] . "'>Eliminar</button>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar/editar ponente -->
    <div class="modal fade" id="ponenteModal" tabindex="-1" role="dialog" aria-labelledby="ponenteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ponenteModalLabel">Agregar Ponente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ponenteForm">
                        <input type="hidden" id="ponente_id" value="">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido1">Apellido1:</label>
                            <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                        </div>
                        <div class="form-group">
                        <label for="apellido2">Apellido2:</label>
                            <input type="text" class="form-control" id="apellido2" name="apellido2" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Código para inicializar DataTable
            $('#tablaPonentes').DataTable();
            
            // Código para agregar un asistente
            function agregarAsistente(id_persona, id_acto) {
                $.ajax({
                    url: 'acciones_asistentes.php?accion=agregar',
                    type: 'POST',
                    data: {
                        Id_persona: id_persona,
                        id_acto: id_acto
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Asistente agregado correctamente.');
                            location.reload();
                        } else {
                            alert('Error al agregar el asistente.');
                        }
                    }
                });
            }

            // Código para eliminar un asistente
            function eliminarAsistente(id_inscripcion, id_acto) {
                $.ajax({
                    url: 'acciones_asistentes.php?accion=eliminar',
                    type: 'POST',
                    data: {
                        Id_inscripcion: id_inscripcion,
                        id_acto: id_acto
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Asistente eliminado correctamente.');
                            location.reload();
                        } else {
                            alert('Error al eliminar el asistente.');
                        }
                    }
                });
            }

            // Código para actualizar el número de asistentes en un acto
            function actualizarNumAsistentes(id_acto, num_asistentes) {
                $.ajax({
                    url: 'acciones_asistentes.php?accion=actualizar_cantidad',
                    type: 'POST',
                    data: {
                        id_acto: id_acto,
                        Num_asistentes: num_asistentes
                    },
                    dataType: 'json',
                    success: function(response) {
                    if (response.success) {
                        alert('Número de asistentes actualizado correctamente.');
                        location.reload();
                    } else {
                        alert('Error al actualizar el número de asistentes.');
                    }
                    }
                });
            }
            // Código para listar asistentes
            function listarAsistentes() {
                $.ajax({
                    url: 'acciones_asistentes.php?accion=listar',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                    }
                });
            }

            // Llamar a la función listarAsistentes al cargar la página
            listarAsistentes();

            // Código para agregar un ponente
            $("#ponenteForm").submit(function(e) {
                e.preventDefault();
                // Aquí va el código para agregar un ponente
            });

            // Código para editar un ponente
            $(".editarPonente").click(function() {
                var id = $(this).data("id");
                // Aquí va el código para editar un ponente
                $("#ponenteModal").modal("show");
            });

            // Código para eliminar un ponente
            $(".eliminarPonente").click(function() {
                var id = $(this).data("id");
                // Aquí va el código para eliminar un ponente
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        // Configuración del calendario
        $('#calendario').fullCalendar({
            // Opciones y configuraciones del calendario
        });

        // Cerrar sesión
        $("#logoutButton").click(function () {
            window.location.href = "logout.php";
        });

        // Ir al perfil
        $("#perfil").click(function () {
            window.location.href = "perfil.php";
        });
    });
</script>
</body>
</html>