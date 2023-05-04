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
                    <a href="eventos.php" class="btn btn-primary boton-admin">Gestionar eventos</a>
                    <a href="ponentes.php" class="btn btn-primary boton-admin">Gestionar ponentes</a>
                    <a href="tipos_eventos.php" class="btn btn-primary boton-admin">Gestionar tipos de eventos</a>
                    <a href="asistentes.php" class="btn btn-secondary boton-admin">Gestionar asistentes</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 offset-md-2" id="Calendario1" style="margin-top: 5px"></div>

    <!-- Asistentes modal -->
    <div class="modal fade" id="AsistentesModal" tabindex="-1" role="dialog" aria-labelledby="AsistentesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AsistentesModalLabel">Asistentes</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Listado Asistentes</h3>
                    <table class="table" id="tablaAsistentes">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido1</th>
                                <th scope="col">Apellido2</th>
                                <!--<th scope="col">Acciones</th>-->
                            </tr>
                        </thead>
                        <tbody id="asistentesList">
                            <!-- Contenido generado dinámicamente -->
                        </tbody>
                    </table>
                    <h3>Listado no inscritos</h3>
                    <table class="table" id="tablaUsuarios">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido1</th>
                                <th scope="col">Apellido2</th>
                                <!--<th scope="col">Acciones</th>-->
                            </tr>
                        </thead>
                        <tbody id="usuariosList">
                            <!-- Contenido generado dinámicamente -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" id="addAsistente">Añadir asistente</button>
                </div>
                <div class="modal-footer">
                    <label for="numAsistentes">Número de asistentes:</label>
                    <input type="number" id="numAsistentes" min="0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="updateAsistentes">Actualizar</button>
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
                url: 'datosasistentes.php?accion=listarActosInscrito',
                color: '#8BE4EE',
                textColor: '#000000'
            },
            {
                url: 'datosasistentes.php?accion=listarActosPonente',
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
            //info.jsEvent.preventDefault();
            let evento = info.event;
            eventoInfo = info;
            eventoSeleccionado = info.event;
            

            // Cargar asistentes del evento
            cargarAsistentes(eventoSeleccionado.id);
            cargarUsuarios(eventoSeleccionado.id);

            $("#AsistentesModal").modal('show');
        });

        // Funciones para cargar, agregar y eliminar asistentes
        function cargarAsistentes(eventoId) {
            $.ajax({
                type: 'POST',
                url: 'datosasistentes.php?accion=listar_asistentes',
                data: { eventoId: eventoId },
                success: function (data) {
                    //let asistentes = JSON.parse(data);
                    //let asistentesList = document.getElementById('asistentesList');
                    //asistentesList.innerHTML = '';
                    console.log(data);
                    $.each(data, function(index, item){
                        $('#asistentesList').append('<tr><td>' +item.Id_persona + '</td><td>' + item.Nombre + '</td><td>' + item.Apellido1 + '</td><td>' + item.Apellido2 + '</td></tr>');
                    });
                    /*asistentes.forEach(asistente => {
                        let tr = document.createElement('tr');
                        let tdNombre = document.createElement('td');
                        let tdEmail = document.createElement('td');
                        let tdAcciones = document.createElement('td');
                        let btnEliminar = document.createElement('button');

                        tdNombre.textContent = asistente.Nombre;
                        tdEmail.textContent = asistente.Email;
                        btnEliminar.textContent = 'Eliminar';
                        btnEliminar.className = 'btn btn-danger btn-sm';
                        btnEliminar.addEventListener('click', function() {
                            eliminarAsistente(asistente.Id, eventoSeleccionado.id);
                        });

                        tdAcciones.appendChild(btnEliminar);
                        tr.appendChild(tdNombre);
                        tr.appendChild(tdEmail);
                        tr.appendChild(tdAcciones);
                        asistentesList.appendChild(tr);

                    });*/

                    document.getElementById('numAsistentes').value = asistentes.length;
                },
                error: function(error) {
                    alert("Error al cargar asistentes: " + error);
                },
            });
        }

        function cargarUsuarios(eventoId) {
            $.ajax({
                type: 'POST',
                url: 'datosasistentes.php?accion=listar_usuarios',
                data: { eventoId: eventoId },
                success: function (data) {
                    //let asistentes = JSON.parse(data);
                    //let asistentesList = document.getElementById('asistentesList');
                    //asistentesList.innerHTML = '';
                    console.log(data);
                    $.each(data, function(index, item){
                        $('#usuariosList').append('<tr><td>' +item.Id_persona + '</td><td>' + item.Nombre + '</td><td>' + item.Apellido1 + '</td><td>' + item.Apellido2 + '</td></tr>');
                    });
                    /*asistentes.forEach(asistente => {
                        let tr = document.createElement('tr');
                        let tdNombre = document.createElement('td');
                        let tdEmail = document.createElement('td');
                        let tdAcciones = document.createElement('td');
                        let btnEliminar = document.createElement('button');

                        tdNombre.textContent = asistente.Nombre;
                        tdEmail.textContent = asistente.Email;
                        btnEliminar.textContent = 'Eliminar';
                        btnEliminar.className = 'btn btn-danger btn-sm';
                        btnEliminar.addEventListener('click', function() {
                            eliminarAsistente(asistente.Id, eventoSeleccionado.id);
                        });

                        tdAcciones.appendChild(btnEliminar);
                        tr.appendChild(tdNombre);
                        tr.appendChild(tdEmail);
                        tr.appendChild(tdAcciones);
                        asistentesList.appendChild(tr);

                    });*/

                    //document.getElementById('numAsistentes').value = asistentes.length;
                },
                error: function(error) {
                    alert("Error al cargar asistentes: " + error);
                },
            });
        }

        function agregarAsistente(asistenteId, eventoId) {
            $.ajax({
                type: 'POST',
                url: 'datosasistentes.php?accion=agregar_inscrito',
                data: { asistenteId: asistenteId, eventoId: eventoId },
                success: function(msg) {
                    //cargarAsistentes(eventoId);
                    alert('El asistente se ha añadido correctamente.');
                    window.location='asistentes.php';
                },
                error: function(error) {
                    alert("Error al agregar asistente: " + error);
                },
            });
        }

        function eliminarAsistente(asistenteId, eventoId) {
            $.ajax({
                type: 'POST',
                url: 'datosasistentes.php?accion=eliminar_inscrito',
                data: { asistenteId: asistenteId, eventoId: eventoId },
                success: function(msg) {
                    //cargarAsistentes(eventoId);
                    alert('El asistente se ha eliminado correctamente.');
                },
                error: function(error) {
                    alert("Error al eliminar asistente: " + error);
                },
            });
        }

        document.getElementById('addAsistente').addEventListener('click', function() {
            let asistenteId = prompt('Introduce el ID del asistente que quieres añadir:');
            if (asistenteId) {
                agregarAsistente(asistenteId, eventoSeleccionado.id);
            }
        });

        document.getElementById('updateAsistentes').addEventListener('click', function() {
            let numAsistentes = document.getElementById('numAsistentes').value;
            actualizarNumAsistentes(numAsistentes, eventoSeleccionado.id);
        });

        function actualizarNumAsistentes(numAsistentes, eventoId) {
            $.ajax({
                type: 'POST',
                url: 'datosasistentes.php?accion=modificar_asistentes',
                data: { numAsistentes: numAsistentes, eventoId: eventoId },
                success: function(msg) {
                    alert('El número de asistentes se ha actualizado correctamente.');
                },
                error: function(error) {
                    alert("Error al actualizar número de asistentes: " + error);
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