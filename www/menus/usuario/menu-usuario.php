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
    <link rel="stylesheet" href="menu-usuario.css">

  <!-- Scripts JS -->
    <script src="../../calendarioWEB/js/jquery-3.6.4.min.js"></script>
    <script src="../../calendarioWEB/js/popper.min.js"></script>
    <script src="../../calendarioWEB/js/bootstrap.min.js"></script>
    <script src="../../calendarioWEB/js/datatables.min.js"></script>
    <script src="../../calendarioWEB/js/bootstrap-clockpicker.js"></script>
    <script src="../../calendarioWEB/js/moment-with-locales.min.js"></script>
    <script src="../../calendarioWEB/fullcalendar/index.global.js"></script>
    <script src="../../calendarioWEB/fullcalendar/es.global.js"></script>
    
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
                    <input type="hidden" id="Id" class="form-control" placeholder="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Titulo del evento: </label>
                            <input type="text" id="Titulo" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-12">
                            <label for="">ID del acto: </label>
                            <div class="input-group" data-autoclose="true">
                                <input type="number" id="Id_acto" class="form-control">
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
                                <input type="text" id="Num_asistentes" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- Collapse -->
                    <div> 
                        <button class="readMore_btn" id="hideText_btn">Lista de Ponentes</button>
                        <span class="hide" id="hideText">
                            <p id="textPonentes"></p>
                        </span>
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
            locale: 'es',
            eventSources: [{
                url: 'datoseventos.php?accion=listar',
                textColor: '#000000',
                color: '#FFFFFF'
            },
            {
                url: 'datoseventos.php?accion=listarActosInscrito',
                textColor: '#000000',
                color: '#8BE4EE'
            },
            {
                url: 'datoseventos.php?accion=listarActosPonente',
                textColor: '#000000',
                color: '#FEB776'
            }],

            headerToolbar: {
                left:'prev,next today',
                center: 'title',
                right:'dayGridMonth,timeGridWeek,timeGridDay'
            },
            height: 700,
            
            eventClick: function(info) {
                $('#BotonAgregar').hide();
                $('#BotonModificar').hide();
                $('#BotonBorrar').hide();
                $('#hideText_btn').show();
                $('#Id_acto').val(info.event.id);
                $('#Titulo').val(info.event.title);
                //$('#Descripcion').val(info.event.Descripcion);
                //$('#Fecha').val(moment(info.event.start).format("YYYY-MM-DD"));
                $('#Fecha').val(String(info.event.Fecha));
                $('#HoraInicio').val(moment(info.event.start).format("HH:mm"));
                //$('#HoraInicio').val(info.event.extendedProps.HoraInicio);
                $('#Descripcion_corta').val(info.event.extendedProps.Descripcion_corta);
                $('#Descripcion_larga').val(info.event.extendedProps.Descripcion_larga);
                $('#Num_asistentes').val(info.event._def.Num_asistentes);
                
                
                //$("#FormularioEventos").modal('show');
                window.open('infoevento.php?info='+info.event.id, '_self');
            }

        });

        calendario1.render();

       /*$('#FormularioEventos').on('show.bs.modal', function (info) {
            /*const
            const Titulo = $('#Titulo').val();
            const Descripcion_corta = $('#Descripcion_corta').val();
            const Descripcion_larga = $('#Descripcion_larga').val();
            if (!id) {
                event.preventDefault();
                alert('Por favor, ingrese el ID del ponente.');
            } else {
                $.ajax({
                    url: 'get_ponente.php',
                    method: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (data) {
                        if (data) {
                            $('#modify_id').val(data.id);
                            $('#modify_username').val(data.username);
                            $('#modify_nombre').val(data.nombre);
                            $('#modify_apellido1').val(data.apellido1);
                            $('#modify_apellido2').val(data.apellido2);
                        } else {
                            event.preventDefault();
                            alert('No se encontró el ponente con el ID proporcionado.');
                        }
                    },
                    error: function () {
                        event.preventDefault();
                        alert('Error al obtener datos del ponente.');
                    }
                });
            }*/
        //});

        //Eventos de botones de la aplicacion
        /*$('#BotonAgregar').click(function(){
            let registro = recuperarDatosFormulario();
            agregarRegistro(registro);
            $('#FormularioEventos').modal('hide');
        });*/

        let hideText_btn = document.getElementById('hideText_btn');
        let hideText = document.getElementById('hideText');
        hideText_btn.addEventListener('click', toggleText);

        function toggleText() {
            hideText.classList.toggle('show');
            //funcion para mostrar ponentes
        }

        $('#hideText_btn').click(function(){
            let registro = recuperarDatosFormulario();
            listarPonentes(registro);
            $('#FormularioEventos').modal('show');
        });

        //Funciones que interactual con el servidor AJAX!
       /* function listarPonentes(registro){
            //alert(registro);
            $.ajax({
                type: 'POST',
                url: 'datoseventos.php?accion=listarPonentes',
                data: registro,
                success: function(msg){
                    calendario1.refetchEvents();
                },
                error: function(error) {
                    alert("Error al agregar evento: " + error);
                }
            })
        }
        function recogerNum(info){
            //alert(registro);
            $.ajax({
                type: 'POST',
                url: 'datoseventos.php?accion=recogerNumAsistentes',
                data: registro,
                success: function(msg){
                    calendario1.refetchEvents();
                },
                error: function(error) {
                    alert("Error al recoger num evento: " + error);
                }
            })
        }

        /*function infoRegistro(registro){
            //alert(registro);
            $.ajax({
                type: 'POST',
                url: 'datoseventos.php?accion=infoRegistro',
                data: registro,
                success: function(msg){
                    calendario1.refetchEvents();
                },
                error: function(error) {
                    alert("Error al mostrar info evento: " + error);
                }
            })
        }*/

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
                Id: $('#Id').val(),
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
