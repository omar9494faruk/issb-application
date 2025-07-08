<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
require 'config.php';

$database = "IQ";
$stmt1 = $conn-> prepare("SELECT COUNT(*) AS table_count FROM information_schema.tables WHERE table_schema = ? ");
$stmt1-> bind_param("s", $database);
$stmt1->execute();
$result = $stmt1-> get_result();
$Set = $result -> fetch_assoc();


$eligibility = $conn2-> prepare("SELECT iq FROM `user_test_appear` WHERE `email` = ? ");
$eligibility-> bind_param("s", $_SESSION['email']);
$eligibility->execute();
$robo = $eligibility-> get_result();
$eligible = $robo -> fetch_assoc();


$totalNumber =  $Set['table_count'];
if(isset($_POST['select'])){
    $setN = $_POST['setNumber'];
    $_SESSION['setN'] = $setN;

    $newValue = (int)$eligible['iq'] + 1;

    $stmt3 = $conn2->prepare("UPDATE `user_test_appear` SET `iq` = ? WHERE `email` = ?");
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
    <title>ISSB IQ Practice</title>
    <link rel="stylesheet" href="assets/style.css">

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
    <h2 style="text-align:center;color:#389d9f;">Select iq set number</h2>
    <form action="" method="POST">
            <select name="setNumber" id="setnumber">
                <?php $i = 1; while ($i <= $totalNumber) {  ?>
                <option value="<?php echo htmlspecialchars($i); ?>"><?php echo htmlspecialchars($i); ?></option>
                <?php $i++; } ?>
            </select>
            <?php if($_SESSION['user_type'] == 'regular') {
                if($eligible['iq'] < 2){ ?>
                   <input type="submit" value="Select" name="select">
            <?php     }else { ?>
                <input type="submit" value="Select" name="select" disabled>
                <p style="color:red;s">Free access to mock tests has ended. <a href="">Click here</a> to get access</p>
            <?php }
            }else { ?>
                <input type="submit" value="Select" name="select">
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