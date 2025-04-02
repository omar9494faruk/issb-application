<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../index.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personality Test</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <ul>
        <li><a href="wat/">WAT</a></li>
        <li><a href="cs/">Comleting story and TAT</a></li>
        <li><a href="otests/fb-eng.php">Completing Sentences</a></li>
        <li><a href="otests/essay.php">Esssay Writing</a></li>
    </ul>
    
    
    <script src="script.js"></script>
</body>
</html>