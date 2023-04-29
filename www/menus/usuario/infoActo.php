<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';
$conn = conexion();


$count = 0;

$inscribir = true;
$desinscribir = false;

$id = $_GET['info'];
if (isset($_GET['info'])) {
    $id = $_GET['info'];

    //Query para mostrar la informacion del acto seleccionado
    $sql = "SELECT Id_acto as id, Fecha as fecha, Hora as hora, Titulo as titulo, Descripcion_corta as descripcion_corta,
    Descripcion_larga as descripcion_larga, Num_asistentes as num_asistentes FROM Actos WHERE Id_acto = $id";

    $result = $conn->query($sql); 

    //Query para mostrar lista de ponentes
    $sql2 = "SELECT p.Nombre as nombre, p.Apellido1 as apellido1, p.Apellido2 as apellido2 FROM Personas p WHERE p.Id_persona IN (SELECT l.Id_persona FROM Lista_Ponentes l, Actos a WHERE l.Id_acto = $id);";

    $result2 = $conn->query($sql2);

    //Query comprobar inscrito en acto
    $sql3 = "SELECT Id_acto as id FROM Actos WHERE Id_acto IN (SELECT b.id_acto FROM Inscritos b, Personas c WHERE b.Id_persona = $user_id);";

    $result3 = $conn->query($sql3);
    

}else{
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Info_Acto</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../propiedades-comundes.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <script> 
        function inscribir(info){
            const id_a = <?php echo $id; ?>;
            $.ajax({
                    url: 'inscribirActo.php',
                    method: 'POST',
                    data: { id: id_a },
                    dataType: 'json',
                    success: function (msg) {
                        alert('Te has inscrito correctamente.');
                        window.location='menu-usuario.php';
                    },
                    error: function () {
                        alert('Error al inscribir.');
                    }
                });
            
        };
        function desinscribir(){
            const id_a = <?php echo $id; ?>;
            $.ajax({
                    url: 'desinscribirActo.php',
                    method: 'POST',
                    data: { id: id_a },
                    dataType: 'json',
                    success: function (msg) {
                        alert('Ya no estás inscrito en este acto');
                        window.location='menu-usuario.php';
                    },
                    error: function () {
                        alert('Error al desinscribir.');
                    }
                });
            
        };

    </script>        

    <div class="container-fluid" id="InfoCompletaActo">
        <div class="row align-items-center header">
            <div class="col">
                <h3 class="text-primary"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
            </div>
            <div class="col-auto d-flex">
                <a href="menu-usuario.php" class="btn btn-secondary mr-2">Volver atrás</a>
                <a href="../../logout.php" class="btn btn-secondary">Cerrar sesión</a>
            </div>
        </div> 
        <div class="container">
            <h1 class="text-center">Información del acto</h1>
            <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titulo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Breve descripcion</th>
                            <th>Descripcion amplia</th>
                            <th>Asistentes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td id='id_a'>" . $row["id"] . "</td>";
                                echo "<td>" . $row["titulo"] . "</td>";
                                echo "<td>" . $row["fecha"] . "</td>";
                                echo "<td>" . $row["hora"] . "</td>";
                                echo "<td>" . $row["descripcion_corta"] . "</td>";
                                echo "<td>" . $row["descripcion_larga"] . "</td>";
                                echo "<td>" . $row["num_asistentes"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Hubo un problema al visualizar la info del evento</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col">
                    <h2 class="text-center">Lista de Ponentes</h2>
                    <ul>
                    <?php 
                        if ($result2->num_rows > 0) {
                            while($row = $result2->fetch_assoc()) {   
                                echo "<li>" . $row["nombre"] . " " . $row["apellido1"]. " " . $row["apellido2"] ."</li>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron ponentes</td></tr>";
                        }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer">
            <?php 
                if ($result3->num_rows > 0) {
                    while($row = mysqli_fetch_all($result3, MYSQLI_ASSOC)) {   
                        for($count = 0; $count < sizeof($row); $count++){
                            if($id == $row[$count]['id']){
                                $desinscribir = true;
                            }       
                        }
                        if($desinscribir){
            ?>
                            <button type='button' class='btn btn-outline-secondary' id='BotonDesinscribir' onclick="desinscribir()">Desinscribirse</button>
            <?php
                        }else{
            ?>
                            <button type='button' class='btn btn-outline-secondary' id="BotonInscribir" onclick="inscribir()">Inscribirse</button>
                            
            <?php
                        }
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron ponentes</td></tr>";
                }
                
            ?>
        </div>
    </div>
</body>
</html>
