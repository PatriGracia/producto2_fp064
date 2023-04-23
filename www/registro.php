<?php

?> 

<style>
.contenedor-registro{
    display:flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

body {
    margin:0;
    padding:0 0;
}

.header {
    background-color: beige;
    padding: 10px 50px; 

    display:flex;
    justify-content: space-between;
    align-items: center;
}

.boton{
    border-radius: 10px;
    padding: 5px 5px;
    border-width: 2px;
    border-color: rgb(228, 197, 159);
    font-size:medium;
}

.acceso{
    background-color: rgba(218, 125, 25, 0.73);
    color: white;
}

.form-group{
    padding: 5px;
    
}
input{
    border-radius:10px;
    border-size:1px;
    padding: 5px 7px;
}
.button-registro{
    align-item: center;
}

</style>  
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrate</title>
        <link rel="stylesheet" href="index.css">
        
    </head>
    <body>
        <div class="header">
            <div>
                <h3 style="color:cadetblue;"> <strong>Grupo PSMD </strong></h3>
                <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
                <button class="boton inicio" onclick="window.location.href='index.php'"> Home </button>
            </div>
            
            <div class="botones"> 
                <button class="boton acceso"> Acceso </button> 
            </div>
        </div>

        <div class="contenedor-registro">
            <form action="register_process.php" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Apellido 1:</label>
                    <input type="text" class="form-control" id="apellido1" name="apellido1" required >
                </div>
                <div class="form-group">
                    <label for="nombre">Apellido 2:</label>
                    <input type="text" class="form-control" id="apellido2" name="apellido2" required >
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required >
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>
                <div class="form-group button-registro">
                    <button type="submit" class="btn btn-default">Registrarme</button>
                </div>
                
            </form>
        </div>
    </body>
    </html>
