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
                <h2>Administración de eventos</h2>
                <p>Aquí puedes gestionar los eventos, ponentes, tipos de eventos y asistentes.</p>
                <div class="menu-admin">
                    <a href="eventos.php" class="btn btn-secondary boton-admin">Gestionar eventos</a>
                    <a href="ponentes.php" class="btn btn-primary boton-admin">Gestionar ponentes</a>
                    <a href="tipos_eventos.php" class="btn btn-primary boton-admin">Gestionar tipos de eventos</a>
                    <a href="asistentes.php" class="btn btn-primary boton-admin">Gestionar asistentes</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 offset-md-2" id="Calendario1" style="margin-top: 5px"></div>
    <!-- Formulario de eventos -->
    <div class="modal fade" id="FormularioEventos" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span araia-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Titulo del evento: </label>
                            <input type="text" id="Titulo" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="">Tipo de Acto (Ponencia, Seminario, Debate, Otro) :</label>
                            <select id="Id_tipo_acto" class="form-control">
                                <?php
                                $tipo_acto_query = $conn->prepare("SELECT Id_tipo_acto, Descripcion FROM Tipo_acto");
                                $tipo_acto_query->execute();
                                $result_tipo_acto = $tipo_acto_query->get_result();
                                while ($tipo_acto = $result_tipo_acto->fetch_assoc()) {
                                    echo '<option value="' . $tipo_acto['Id_tipo_acto'] . '">' . $tipo_acto['Descripcion'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Fecha:</label>
                            <div class="input-group" data-autoclose="true">
                                <input type="date" id="Fecha" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group col-md-6" id="TituloHoraInicio">
                            <label for="">Hora de inicio:</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" id="HoraInicio" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Breve descripcion:</label>
                            <div class="input-group" data-autoclose="true">
                                <input type="text" id="Descripcion_corta" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Descripcion larga:</label>
                            <div class="input-group" data-autoclose="true">
                                <textarea id="Descripcion_larga" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Numero de asistentes:</label>
                            <div class="input-group" data-autoclose="true">
                                <input type="number" id="Num_asistentes" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="BotonAgregar" class="btn btn-sucess">Agregar</button>
                    <button type="button" id="BotonModificar" class="btn btn-sucess">Modificar</button>
                    <button type="button" id="BotonBorrar" class="btn btn-sucess">Borrar</button>
                    <button type="button" class="btn btn-sucess" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmación modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas realizar esta acción?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Continuar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('.clockpicker').clockpicker();

        let calendario1 = new FullCalendar.Calendar(document.getElementById('Calendario1'), {
            locale: 'es',
            defaultTimedEventDuration: '01:00:00',
            eventSources: [{
                url: 'datoseventos.php?accion=listar',
                color: '#FFFFFF',
                textColor: '#000000'
            },
            {
                url: 'datoseventos.php?accion=listarActosInscrito',
                color: '#8BE4EE',
                textColor: '#000000'
            },
            {
                url: 'datoseventos.php?accion=listarActosPonente',
                color: '#FEB776',
                textColor: '#000000'
            }],
            headerToolbar: {
                left:'prev,next today',
                center: 'title',
                right:'dayGridMonth,timeGridWeek,timeGridDay'
            },
            height: 700,
            dateClick: function(info){
                limpiarFormulario();
                $('#BotonAgregar').show();
                $('#BotonModificar').hide();
                $('#BotonBorrar').hide();

                if(info.allDay){
                    $('#Fecha').val(info.dateStr);
                }else{
                    /*let fechaHora = info.dateStr.split("T");
                    $('#Fecha').val(fechaHora[0]);
                    $('#HoraInicio').val(fechaHora[1].substring(0,5));*/
                }

                $("#FormularioEventos").modal('show');
            }

        });

        calendario1.render();

        //Eventos de botones de la aplicacion
        $('#BotonAgregar').click(function(){
            let registro = recuperarDatosFormulario();
            agregarRegistro(registro);
            $('#FormularioEventos').modal('hide');
        });

        //Funciones que interactual con el servidor AJAX!
        function agregarRegistro(registro) {
            $.ajax({
                type: 'POST',
                url: 'datoseventos.php?accion=agregar',
                data: registro,
                success: function (msg) {
                    calendario1.refetchEvents();
                    // Mostrar un mensaje de éxito
                    alert('El evento se ha creado correctamente.');
                },
                error: function (error) {
                    alert("Error al agregar evento: " + error);
                },
            });
        }


        //funciones que interactuan con el forulario Eventos

        function limpiarFormulario(){
            $('#Titulo').val('');
            $('#Descripcion').val('');
            $('#Fecha').val('');
            $('#HoraInicio').val('');
            $('#Descripcion_corta').val('');
            $('#Descripcion_larga').val('');
            $('#Num_asistentes').val('');
        }

        function recuperarDatosFormulario(){
            let registro = {
                id: eventoSeleccionado.id,
                Titulo: $('#Titulo').val(),
                Fecha: $('#Fecha').val(),
                HoraInicio: $('#HoraInicio').val(),
                Descripcion_corta: $('#Descripcion_corta').val(),
                Descripcion_larga: $('#Descripcion_larga').val(),
                Num_asistentes: $('#Num_asistentes').val(),
                Id_tipo_acto: $('#Id_tipo_acto').val()
            }
            return registro;
        }

        let eventoSeleccionado;
        let eventoInfo;

        calendario1.on('eventClick', function(info) {
            info.jsEvent.preventDefault();
            let evento = info.event;
            eventoInfo = info;
            eventoSeleccionado = info.event;

            $('#Titulo').val(evento.title);
            $('#Fecha').val(moment(evento.start).format('YYYY-MM-DD'));
            $('#HoraInicio').val(moment(evento.start).format('HH:mm'));
            $('#BotonAgregar').hide();
            $('#BotonModificar').show();
            $('#BotonBorrar').show();

            $("#FormularioEventos").modal('show');
        });

        $('#BotonModificar').click(function () {
            $("#FormularioEventos").modal('hide');
            $("#confirmModal").modal('show');
            $('#confirmButton').data('action', 'modify');
        });

        $('#BotonBorrar').click(function () {
            $("#FormularioEventos").modal('hide');
            $("#confirmModal").modal('show');
            $('#confirmButton').data('action', 'delete');
        });

        $('#confirmButton').click(function () {
            let action = $(this).data('action');
            if (action == 'modify') {
                let registro = recuperarDatosFormulario();
                modificarRegistro(registro);
            } else if (action == 'delete') {
                let eventId = eventoInfo.event.id;
                borrarRegistro(eventId);
            }
            $("#confirmModal").modal('hide');
        });

        function modificarRegistro(registro) {
            $.ajax({
                type: 'POST',
                url: 'datoseventos.php?accion=modificar',
                data: registro,
                success: function(msg) {
                    calendario1.refetchEvents();
                    alert('El evento se ha modificado correctamente.');
                },
                error: function(error) {
                    alert("Error al modificar evento: " + error);
                },
            });
        }

        function borrarRegistro(eventId) {
            $.ajax({
                type: 'POST',
                url: 'datoseventos.php?accion=borrar',
                data: { id: eventId },
                success: function(msg) {
                    calendario1.refetchEvents();
                    alert('El evento se ha eliminado correctamente.');
                },
                error: function(error) {
                    alert("Error al eliminar evento: " + error);
                },
            });
        }
    </script>
    <script>
        document.getElementById("logoutButton").addEventListener("click", function() {
            window.location.href = "/logout.php";
        });
    </script>
    <script>
        document.getElementById("perfil").addEventListener("click", function() {
            window.location.href = "../perfil.php";
        });
    </script>
    <script>
        document.getElementById("perfil").addEventListener("click", function() {
            window.location.href = "../perfil.php";
        });
    </script>

</body>
</html>
