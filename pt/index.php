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
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../responsive.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <div class="test-area">
        <ul>
            <li><a href="wat/">
            <img src="../images/issbInst.webp" alt="">     
            WAT</a></li>
            <li><a href="cs/">
            <img src="../images/issbInst.webp" alt="">     
            Comleting story and TAT</a></li>
            <li><a href="otests/fb-eng.php">
            <img src="../images/issbInst.webp" alt="">     
            Completing Sentences</a></li>
            <li><a href="otests/index-essay.php">
            <img src="../images/issbInst.webp" alt="">     
            Esssay Writing</a></li>
        </ul>
    </div>
    
    <script src="script.js"></script>
</body>
</html>