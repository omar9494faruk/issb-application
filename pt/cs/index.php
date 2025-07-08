<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
$conn = mysqli_connect('localhost','searchli_mainDevAlpha','AkashBhoraTara@','searchli_users');

$eligibility = $conn-> prepare("SELECT story FROM `user_test_appear` WHERE `email` = ? ");
$eligibility-> bind_param("s", $_SESSION['email']);
$eligibility->execute();
$robo = $eligibility-> get_result();
$eligible = $robo -> fetch_assoc();


if(isset($_POST['startTest'])){
    $newValue = (int)$eligible['story'] + 1;

    $stmt3 = $conn->prepare("UPDATE `user_test_appear` SET `story` = ? WHERE `email` = ?");
    $stmt3->bind_param("is", $newValue, $_SESSION['email']);
    $stmt3->execute();

    $newValue1 = (int)$eligible['iq'] + 1;

    $stmt4 = $conn->prepare("UPDATE `user_test_appear` SET `tat` = ? WHERE `email` = ?");
    $stmt4->bind_param("is", $newValue, $_SESSION['email']);
    $stmt4->execute();


    header("Location: main.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situational Reaction Test and Thematic Appreception Test</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header-part">
            <div class="logo-area">
            <a href="index.php"><img src="../../images/logo.png" alt="Logo" srcset=""></a>
                <div class="text-area">
                    <p style="color:#fff">Lighting Your Way To Success</p>
                </div>
            </div>
            <div class="menu-area">
                <ul>
                </ul>
            </div>
     </div>
     <div class="main-part">
        <h1>Situational Reaction Test and Thematic Appreception Test</h1>
        <form action="" method="post">
            <?php if($_SESSION['user_type'] == 'regular') {
                if($eligible['story'] < 2){ ?>
                   <input type="submit" value="Start Test" name="startTest">
            <?php     }else { ?>
                <input type="submit" value="Start Test" name="startTest" disabled>
                <p style="color:red;s">Free access to mock tests has ended. <a href="">Click here</a> to get access</p>
            <?php }
            }else { ?>
                <input type="submit" value="Start Test" name="startTest">
           <?php } ?>
        </form>
     </div>
     <div class="instruction">
        <h2>Instructions :</h2>
        <h3>Situational Reaction Test :</h3>
        <ul>
            <li>FIRST 02 STORY IN ENGLISH</li>
            <li>LAST 2 STORY IN BANGLA </li>
            <li>2 STORIES IN EVERY PAGE</li>
        </ul>
        <h3>Thematic Appreception Test:</h3>
        <ul>
            <li>FIRST 02 STORY IN ENGLISH</li>
            <li>LAST 2 STORY IN BANGLA </li>
            <li>2 STORIES IN EVERY PAGE</li>
        </ul>
     </div>

    
</body>
</html>