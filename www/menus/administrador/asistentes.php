<?php
require_once '../../db_connection.php';

$conn = conexion();


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
<link rel="stylesheet" href="/css/propiedades-comundes.css">
    <link rel="stylesheet" href="../propiedades-comundes.css">
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

        $('#modifyPonenteModal').on('show.bs.modal', function (event) {
            const id = $('#id_persona').val();
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
            }
        });
    });
</script>
</head>
<body>
   <!-- HEADER --> 
   <div class="container-fluid">
        <div class="row align-items-center header">
            <div class="col">
                <h3 style="color:cadetblue;"><strong>Grupo PSMD</strong></h3>
                <h4 class="nombre-proyecto">Gestión de Eventos - Panel de Administración</h4>
            </div>
            <div class="col-auto d-flex">
                <button class="btn btn-danger log-out" id="perfil">Perfil</button>
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

    <!-- CUERPO -->
            
</body>
</html>