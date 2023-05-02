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

    //coger nombre de acto donde soy ponente
    $sql = "SELECT Id_presentacion as id_presentacion, Id_acto as id_acto, Localizacion_documentacion as localizacion, Orden as orden, 
            Id_persona as id_persona, Titulo_documento as titulo FROM Documentacion WHERE Id_persona = $user_id";
    $result = $conn->query($sql);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Ponente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../propiedades-comundes.css">
     <!-- Scripts CSS -->
    <link rel="stylesheet" href="../../calendarioWEB/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../calendarioWEB/css/datatables.min.css">
    <link rel="stylesheet" href="../../calendarioWEB/css/bootstrap-clockpicker.css">
    <link rel="stylesheet" href="menu-ponente.css">

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

    <div class="row">
        <div class="col-6 offset-md-1">
            <div id="Calendario1" style="margin-top: 5px"></div>
        </div>
        <div class="col-4">
            <div id="Documentacion" style="margin-bottom:1em; height:500px; border: 1px solid #000; overflow: auto; padding: 1em; margin-top: 70px">
                <h5>Resumen documentacion de mis actos como ponente:</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#Presentacion</th>
                            <th>#Acto</th>
                            <th>Localizacion doc</th>
                            <th>Orden</th>
                            <th>#Persona</th>
                            <th>Titulo doc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id_presentacion"] . "</td>";
                                    echo "<td>" . $row["id_acto"] . "</td>";
                                    echo "<td>" . $row["localizacion"] . "</td>";
                                    echo "<td>" . $row["orden"] . "</td>";
                                    echo "<td>" . $row["id_persona"] . "</td>";
                                    echo "<td>" . $row["titulo"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No eres ponente</td></tr>";
                            } 
                        ?>
                    </tbody>
                </table>
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
                window.open('infoActo.php?info='+info.event.id, '_self');
            }

        });

        calendario1.render();
        
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
</body>
</html>
