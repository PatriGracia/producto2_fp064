<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connection.php';

$user_id = $_SESSION['user_id'];

// Obtener eventos disponibles
$query = "SELECT * FROM Eventos";
$result = mysqli_query($conn, $query);

if (!$result) {
    printf("Error en la consulta: %s\n", mysqli_error($conn));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscribirse en actos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/propiedades-comundes.css">
</head>
<body>
    <!-- Aquí puede agregar el encabezado y la estructura de su menú -->
    <div class="container">
        <h1>Inscribirse en actos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['Nombre']; ?></td>
                    <td><button class="btn btn-primary inscribir" data-evento-id="<?php echo $row['Id_Evento']; ?>">Inscribirse</button></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script>
    document.querySelectorAll(".inscribir").forEach(function (button) {
        button.addEventListener("click", function () {
            const eventoId = this.getAttribute("data-evento-id");

            fetch("inscribir_acto.php", {
                method: "POST",
                body: JSON.stringify({
                    user_id: <?php echo $user_id; ?>,
                    evento_id: eventoId
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(function (response) {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error("Error al inscribirse en el evento");
                }
            })
            .then(function (text) {
                if (text === "success") {
                    alert("Inscrito en el evento con éxito");
                } else {
                    alert("Error al inscribirse en el evento");
                }
            })
            .catch(function (error) {
                console.error("Error:", error);
                alert("Error al inscribirse en el evento");
            });
        });
    });
    </script>
</body>
</html>