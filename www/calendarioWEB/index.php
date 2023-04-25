<!doctype html>
<html lang="en">

<head>
  <title>Calendario de Eventos</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title></title>

  <!-- Scripts CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables.min.css">
    <link rel="stylesheet" href="css/bootstrap-clockpicker.css">

  <!-- Scripts JS -->
    <script src="js/jquery-3.6.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/datatables.min.js"></script>
    <script src="js/bootstrap-clockpicker.js"></script>
    <script src="js/moment-with-locales.min.js"></script>
    <script src="fullcalendar/index.global.js"></script>

</head>
<body>
    <div class="col-md-8 offset-md-2" id="Calendario1" style="border: 1px solid #000; padding:2px"></div>

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
                    <!-- <input type="hidden" id="Id"> no sé si esto es necesario-->
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
            events: 'datoseventos.php?accion=listar',
            headerToolbar: {
                left:'prev,next today',
                center: 'title',
                right:'dayGridMonth,timeGridWeek,timeGridDay'
            },
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
</body>
</html>