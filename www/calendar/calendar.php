<?php
    //Set timezone
    date_default_timezone_set('europe/madrid');

    //Get prev & next month
    if (isset($_GET['ym'])) {
        $ym = $_GET['ym'];

    } else {
        //This month
        $ym = date('Y-m');
    }
    

    //Check format
    $timestamp = strtotime($ym . '-01'); //the first day of the month
    if ($timestamp === false) {
        $ym = date('Y-m');
        $timestamp = strtotime($ym . '-01');
    }

    //Today (Format:2023-04-13)
    $today = date('Y-m-j');

    //Tittle (Format: Abril, 2023)
    $title = date('F, Y', $timestamp);

    //Create prev & next month link
    $ym_prev = date_create($ym);
    $ym_next = date_create($ym);
    $sub_ym_get = date_sub($ym_prev, date_interval_create_from_date_string("1 month"));
    $prev = date_format($sub_ym_get, "Y-m");
    $add_ym_get = date_add($ym_next, date_interval_create_from_date_string("1 month"));
    $next = date_format($add_ym_get, "Y-m");

    //Number of days in the month
    $day_count = date('t', $timestamp);

    //Format 1:Mon, 2:Tue... 7:Sun
    $str = date('N', $timestamp);

    //Array for calendar
    $weeks = [];
    $week = [];

    //Add empty cell(s)
    $week .= str_repeat('<td></td>', $str - 1);

    for ($day = 1; $day <= $day_count; $day++, $str++) {
        $date = $ym . '-' . $day;
        if ($today == $date) {
            $week .= '<td class="today">';
        } else {
            $week .= '<td>';
        }
        $week .= $day . '</td>';

        //Sunday or last day of the month
        if ($str % 7 == 0 || $day == $day_count) {
            //last day of the month
            if ($day == $day_count && $str % 7 != 0) {
                //Add empty cell(s)
                $week .= str_repeat('<td></td>', 7 - $str % 7);
            }
            $weeks[] = '<tr>' . $week . '</tr>';
            $week = '';
        } 
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf=8">
    <title>PHP Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <style>
        .container{
            font-family: 'Nunito', sans-serif;
            margin-top: 80px auto;
        }
        .list-inline{
            text-align:center;
            margin-bottom: 30px;
        }
        .title{
            font-weight: bold;
            font-size: 26px;
        }
        th{
            height: 30px;
            text-align: center;
            font-weight:700;
        }
        td{
            height:100px;
        }
        th:nth-of-type(6), td:nth-of-type(6) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: red;
        }
        .today{
            background-color: pink;
        }
    </style>

</head>

<body>
    <div class="container">
        <ul class="list-inline">
            <?php
            echo "<a href='?ym=$prev'>Prev</a>";
            ?>
            <li class="list-inline-item"><span class="title"><?php echo $title ?></span></li>
            <?php
            echo "<a href='?ym=$next'>Next</a>";
            ?>
        </ul>
        <p class="text-right"><a href="panel_usuario.php">Today</a></p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>L</th>
                    <th>M</th>
                    <th>X</th>
                    <th>J</th>
                    <th>V</th>
                    <th>S</th>
                    <th>D</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($weeks as $week) {
                        echo $week;
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>