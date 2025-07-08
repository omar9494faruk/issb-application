<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
$conn2 = mysqli_connect("localhost","searchli_mainDevAlpha","AkashBhoraTara@","searchli_users");



$eligibility = $conn2-> prepare("SELECT ppdt FROM `user_test_appear` WHERE `email` = ? ");
$eligibility-> bind_param("s", $_SESSION['email']);
$eligibility->execute();
$robo = $eligibility-> get_result();
$eligible = $robo -> fetch_assoc();


if(isset($_POST['select'])){

    $newValue = (int)$eligible['ppdt'] + 1;

    $stmt3 = $conn2->prepare("UPDATE `user_test_appear` SET `ppdt` = ? WHERE `email` = ?");
    $stmt3->bind_param("is", $newValue, $_SESSION['email']);
    $stmt3->execute();


    header("Location: main.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDT Practice</title>
    <link rel="stylesheet" href="style.css">

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
<div class="index-main-part">
<h1>Picture Perception & Description Test</h1>
<h2>Instructions: </h2>
<ul>
    <li>YOU WILL GET 30 SEC TO SEE THE BLURRY PICTURE</li>
    <li>YOU WILL GET 4 MIN TO WRITE THE STORY</li>
    <li>THERE WILL BE 3 DIFFERENT BOXES WHICH ARE SPOT BOX, ACTION BOX AND STORY BOX</li>
    <li>CLICK ON START TO BEGIN</li>
    <li><img src="../../images/ppdt.png" alt="" width="10%"></li>
</ul>
    
    <form action="" method="POST">

            <?php if($_SESSION['user_type'] == 'regular') {
                if($eligible['ppdt'] < 2){ ?>
                   <input type="submit" value="Start" name="select">
            <?php     }else { ?>
                <input type="submit" value="Start" name="select" disabled>
                <p style="color:red;s">Free access to mock tests has ended. <a href="">Click here</a> to get access</p>
            <?php }
            }else { ?>
                <input type="submit" value="Start" name="select">
           <?php }
            
            ?>
            
    </form>


</div>


<?php
if(isset($stmt1)){
    $stmt1->close();
}
if(isset($conn)){
    $conn->close();
    $conn2->close();
}
?>
</body>
</html>