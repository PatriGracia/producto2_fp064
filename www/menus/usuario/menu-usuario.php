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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                <h3 style="color:cadetblue;"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
            </div>
            <div class="col-auto d-flex">
                <h1 style="color:rgb(136, 136, 183);">¡Bienvenido/a <?php echo $user_name; ?>! </h1>
            </div>
            <div class="col-auto d-flex">
                <button class="btn btn-primary perfil"> Perfil </button> 
                <button id="logoutButton" class="btn btn-primary log-out"> Log Out </button>
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
                            <div class="input-group" data-autoclose="true">
                                <input type="text" id="Descripcion" class="form-control">
                            </div>
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

    <script>
        $('.clockpicker').clockpicker();

        let calendario1 = new FullCalendar.Calendar(document.getElementById('Calendario1'), {
            lang: 'es',
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
        function agregarRegistro(registro){
            alert(registro);
            $.ajax({
                type: 'POST',
                url: 'datoseventos.php?accion=agregar',
                data: registro,
                success: function(msg){
                    calendario1.refetchEvents();
                },
                error: function(error) {
                    alert("Error al agregar evento: " + error);
                }
            })
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
                Titulo: $('#Titulo').val(),
                Descripcion: $('#Descripcion').val(),
                Fecha: $('#Fecha').val(),
                HoraInicio: $('#HoraInicio').val(),
                Descripcion_corta: $('#Descripcion_corta').val(),
                Descripcion_larga: $('#Descripcion_larga').val(),
                Num_asistentes: $('#Num_asistentes').val()
            }
            return registro;
        }
    </script>
    <script>
        document.getElementById("logoutButton").addEventListener("click", function() {
            window.location.href = "/logout.php";
        });
    </script>
</body>
</html>
