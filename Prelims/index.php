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
    <title>Armed Forces Preliminary Examinations</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../responsive.css">
</head>
<body>
    <div class="header-part">
        <div class="logo-area">
        <div class="logo-main-area"><a href="../index.php"><img src="../images/logo.png" alt="Logo" srcset=""></a></div>
            <div class="text-area">
                <p style="color:#fff">Lighting Your Way To Success</p>
            </div>
        </div>
        <div class="menu-area">
            <ul>
            </ul>
        </div>
    </div>
    <div class="course-area">
        <h1>Model Tests</h1>
        <ul>
            <li>
                <a href="Army">
                <img src="../images/armyModel.jpg" alt="">
                    <span>Army</span>
                </a>
            </li>
            <li>
                <a href="Airforce">
                <img src="../images/AFmodel.jpg" alt="">
                <span>Air Force</span>
                </a>
            </li>
            <li>
                <a href="Navy">
                <img src="../images/navyModel.jpg" alt="">
                <span>Navy</span>
                </a>
            </li>
        </ul>
    </div>
    
</body>
</html>