<?php
session_start();
$conn = mysqli_connect('localhost','searchli_mainDevAlpha','AkashBhoraTara@','searchli_users');

$eligibility = $conn-> prepare("SELECT essay FROM `user_test_appear` WHERE `email` = ? ");
$eligibility-> bind_param("s", $_SESSION['email']);
$eligibility->execute();
$robo = $eligibility-> get_result();
$eligible = $robo -> fetch_assoc();


if(isset($_POST['startTest'])){
    $newValue = (int)$eligible['essay'] + 1;

    $stmt3 = $conn->prepare("UPDATE `user_test_appear` SET `essay` = ? WHERE `email` = ?");
    $stmt3->bind_param("is", $newValue, $_SESSION['email']);
    $stmt3->execute();

    


    header("Location: essay.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essay writing</title>
    <link rel="stylesheet" href="ess-style.css">
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
        <h1>Essay Writing : English & Bangla</h1>
        <form action="" method="post">
        <?php if($_SESSION['user_type'] == 'regular') {
                if($eligible['essay'] < 2){ ?>
                   <input type="submit" value="Select" name="startTest">
            <?php     }else { ?>
                <input type="submit" value="Select" name="startTest" disabled>
                <p style="color:red;s">Free access to mock tests has ended. <a href="">Click here</a> to get access</p>
            <?php }
            }else { ?>
                <input type="submit" value="Select" name="startTest">
           <?php } ?>

        </form>
     </div>
     <div class="instruction">
        <h2>Instructions :</h2>
        <ul>
            <li>First one will be english essay</li>
            <li>Second one will be bangla essay</li>
            <li>For each segment you'll get 10 minutes</li>
            <li>After completion of the first test it will automatically more to second test</li>
        </ul>
     </div>

    
</body>
</html>