<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        @yield('css')
        
    </head>
    <body>
        <div class="container-fluid">
            <div class="row align-items-center header">
                <div class="col">
                    <h3 class="text-primary"> <strong>Grupo PSMD </strong></h3>
                    <h4 class="nombre-proyecto"> Gestión de Eventos </h4>
                </div>
                @yield('content')



            </div>
            <div class="footer">
            </div>
            <div class="container-fluid">
            </div>
        </div>    
    </body>
</html>