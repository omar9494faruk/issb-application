<?php 
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile
    </title>
</head>
<body>
        <a href="#">Preliminary Exams</a><br><br>
        <a href="/issb/pt/index.php" >Personality Test</a>
</body>
</html>