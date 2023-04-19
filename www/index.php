<?php
    require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to LAMP Infrastructure</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <div class="header">
            <div>
                <h3 style="color:cadetblue;"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
            </div>
            
            <div class="botones"> 
                <button class="boton registro"> Registro </button> 
                <button class="boton acceso" > Acceso </button> 
            </div>
        </div>
        <div class="cuerpo">
            <div class="superior-cuerpo">
                <div class="conferencias">
                    <h3 style="color:rgb(31, 36, 171);"> Conferencias de tu especialidad con los mejores profesionales a escala global. Idiomas: español, inglés, alemán, chino y árabe. </h3>
                    <img class="imagen" src="../assets/conferencia.jpg"> 
                </div>
                <div class="seminarios">
                    <h3 style="color:darkorange;"> Los mejores seminarios de tu especialidad 100% online. Se un profesional imparable. </h3>
                    <img class="imagen" src="../assets/seminario.jpg"> 
                </div>
                <div class="mesa-redonda">
                    <h3 style="color:rgb(11, 151, 11);"> Participa en alguna mesa redonda de debate presencialmente o desde casa.</h3>
                    <img class="imagen" src="../assets/mesa-redonda.jpg"> 
                </div>
            </div>
            <div>
                <h1 style="color:brown;"> <strong>Regístrate ya para poder participar en todos estos eventos que harán que despegues en tu carrera profesional </strong></h1>
            </div>
        </div>
        <div class="footer">

        </div>
    
        <!-- 
        <div class="container-fluid">
            <?php
                echo "<h1>¡Hola, grupo PSMD te da la bienvenida!</h1>";

                //$conn = mysqli_connect('db', 'root', 'test', "dbname");
                
                $conn = mysqli_connect('db', 'root', 'test', "Eventos");

                /*$query = 'SELECT * From Person';
                $result = mysqli_query($conn, $query);

                echo '<table class="table table-striped">';
                echo '<thead><tr><th></th><th>id</th><th>name</th></tr></thead>';
                while($value = $result->fetch_array(MYSQLI_ASSOC)){
                    echo '<tr>';
                    echo '<td><a href="#"><span class="glyphicon glyphicon-search"></span></a></td>';
                    foreach($value as $element){
                        echo '<td>' . $element . '</td>';
                    }

                    echo '</tr>';
                }
                echo
                '</table>';

                $result->close();*/
                mysqli_close($conn);
            ?>
        </div>
        -->
    </body>
</html>