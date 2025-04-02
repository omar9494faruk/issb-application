<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WISH</title>
</head>
<body>
    <H1>THIS IS WISHING</H1>

    <p>
        <?php
            if(isset($_SESSION['allRight'])){
                echo $_SESSION['allRight'];
            }
        ?>
    </p>
</body>
</html>