<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_type']);
    }
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out</title>
</head>
<body>
    <script>
        window.location.href = './index.php';
    </script>
</body>
</html>
