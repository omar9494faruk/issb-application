<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
require 'config.php';

$database = "searchli_pAFmath";
$stmt1 = $conn-> prepare("SELECT COUNT(*) AS table_count FROM information_schema.tables WHERE table_schema = ? ");
$stmt1-> bind_param("s", $database);
$stmt1->execute();
$result = $stmt1-> get_result();
$Set = $result -> fetch_assoc();


$eligibility = $conn3-> prepare("SELECT pBafaElse FROM `user_test_appear` WHERE `email` = ? ");
$eligibility-> bind_param("s", $_SESSION['email']);
$eligibility->execute();
$robo = $eligibility-> get_result();
$eligible = $robo -> fetch_assoc();


$totalNumber =  $Set['table_count'];
if(isset($_POST['select'])){
    $setN = $_POST['setNumber'];
    $_SESSION['setN'] = $setN;

    $newValue = (int)$eligible['pBafaElse'] + 1;

    $stmt3 = $conn3->prepare("UPDATE `user_test_appear` SET `pBafaElse` = ? WHERE `email` = ?");
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
    <title>BAFA Preliminary Physics & Math Test</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/responsive.css">

</head>
<body>
    <div class="header-part">
        <div class="logo-area">
        <a href="../../../index.php"><img src="../../../images/logo.png" alt="Logo" srcset=""></a>
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
    <form action="" method="post">
            <h2>Select the model Test set number</h2>
            <select name="setNumber" id="setnumber">
                <?php $i = 1; while ($i <= $totalNumber) {  ?>
                <option value="<?php echo htmlspecialchars($i); ?>"><?php echo htmlspecialchars($i); ?></option>
                <?php $i++; } ?>
            </select>
            <?php if($_SESSION['user_type'] == 'regular') {
                if($eligible['pBafaElse'] < 6){ ?>
                   <input type="submit" value="Select" name="select" class="iqSubmit">
            <?php     }else { ?>
                <input type="submit" value="Select" name="select" class="iqSubmit" disabled>
                <p style="color:red;s">Free access to mock tests has ended. <a href="">Click here</a> to get access</p>
            <?php }
            }else { ?>
                <input type="submit" value="Select" name="select" class="iqSubmit">
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
    $conn3->close();
}
?>
</body>
</html>