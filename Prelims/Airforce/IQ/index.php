<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../../index.php");
}

$conn = mysqli_connect("localhost", 'searchli_mainDevAlpha', 'AkashBhoraTara@', 'searchli_pAFiq');
$conn2 = mysqli_connect("localhost", 'searchli_mainDevAlpha', 'AkashBhoraTara@', 'searchli_users');

$database = "searchli_pAFiq";
$stmt1 = $conn-> prepare("SELECT COUNT(*) AS table_count FROM information_schema.tables WHERE table_schema = ? ");
$stmt1-> bind_param("s", $database);
$stmt1->execute();
$result = $stmt1-> get_result();
$Set = $result -> fetch_assoc();


$eligibility = $conn2-> prepare("SELECT pBafaIQ FROM `user_test_appear` WHERE `email` = ? ");
$eligibility-> bind_param("s", $_SESSION['email']);
$eligibility->execute();
$robo = $eligibility-> get_result();
$eligible = $robo -> fetch_assoc();


$totalNumber =  $Set['table_count'];
if(isset($_POST['select'])){
    $setN = $_POST['setNumber'];
    $_SESSION['setN'] = $setN;

    $newValue = (int)$eligible['pBafaIQ'] + 1;

    $stmt3 = $conn2->prepare("UPDATE `user_test_appear` SET `pBafaIQ` = ? WHERE `email` = ?");
    $stmt3->bind_param("is", $newValue, $_SESSION['email']);
    $stmt3->execute();

    header("Location: iq.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAFA Preliminary IQ Model Test</title>
    <link rel="stylesheet" href="assets/style.css">

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
    <h1>BAFA Preliminary IQ Model Test</h1>
    <h2>Select model test set number from the options: </h2>
    <form action="" method="POST">
            <select name="setNumber" id="setnumber">
                <?php $i = 1; while ($i <= $totalNumber) {  ?>
                <option value="<?php echo htmlspecialchars($i); ?>"><?php echo htmlspecialchars($i); ?></option>
                <?php $i++; } ?>
            </select>
            <?php if($_SESSION['user_type'] == 'regular') {
                if($eligible['pBafaIQ'] < 2){ ?>
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
}
?>
</body>
</html>