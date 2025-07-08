<?php
session_start();

if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAFA Preliminary Examinations Model Test</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../responsive.css">
</head>
<body>
    <div class="header-part">
        <div class="logo-area">
        <div class="logo-main-area"><a href="../../index.php"><img src="../../images/logo.png" alt="Logo" srcset=""></a></div>
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
                <a href="IQ">
                <img src="../../images/english.jpeg" alt="">
                    <span>IQ</span>
                </a>
            </li>
            <li>
                <a href="english">
                <img src="../../images/AFmodel.jpg" alt="">
                <span>English</span>
                </a>
            </li>
            <li>
                <a href="mp">
                <img src="../../images/mp.jpeg" alt="">
                <span>Maths & Physics</span>
                </a>
            </li>
        </ul>
    </div>
    
</body>
</html>