<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../../index.php");
}
include 'config.php';

$setNumber = $_SESSION['setN'] ?? null;
$queData = [];
$queData2 = [];
$no = [];
$no2 = [];
$inpAns = [];
$inpAns2 = [];

if ($setNumber) {
    $tableName = "set_" . $setNumber;
    try {
        $stmt1 = $conn->prepare("SELECT * FROM `$tableName`");
        $stmt1->execute();
        $query = $stmt1->get_result();
        $queData = $query->fetch_all(MYSQLI_ASSOC);

        $stmt2 = $conn2->prepare("SELECT * FROM `$tableName`");
        $stmt2->execute();
        $query2 = $stmt2->get_result();
        $queData2 = $query2->fetch_all(MYSQLI_ASSOC);
    } catch (mysqli_sql_exception $e) {
        die("Error fetching questions: " . $e->getMessage());
    }
}

if (isset($_POST['submit'])) {
    // Math Questions - $queData
    foreach ($queData as $que) {
        $opName = "MTHoptions" . $que['id'];
        if (!isset($_POST[$opName])) {
            $no[] = $que['id'];
        } else {
            $gAns = $_POST[$opName];
            $cAns = $que['answer'];
            if ($gAns != $cAns) {
                $inpAns[] = $que['id'];
            }
        }
    }
    $_SESSION['notAnsweredMTH'] = $no;
    $_SESSION['wrongInpMTH'] = $inpAns;

    // Physics Questions - $queData2
    foreach ($queData2 as $que2) {
        $opName2 = "options" . $que2['id'];
        if (!isset($_POST[$opName2])) {
            $no2[] = $que2['id'];
        } else {
            $gAns2 = $_POST[$opName2];
            $cAns2 = $que2['answer'];
            if ($gAns2 != $cAns2) {
                $inpAns2[] = $que2['id'];
            }
        }
    }
    $_SESSION['notAnsweredPHY'] = $no2;
    $_SESSION['wrongInpPHY'] = $inpAns2;

    header('Location: result.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Navy Preliminary English & GK Model Test</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/responsive.css">
    <script src="assets/script.js"></script>
</head>
<body>
    <div class="header-part">
        <div class="logo-area">
        <a href="index.php"><img src="../../../images/logo.png" alt="Logo" srcset=""></a>
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
    <form action="" method="post">
        <h1>English Questions</h1>
        <?php foreach ($queData as $que): ?>
            <p><span><?php echo htmlspecialchars($que['id']); ?>. </span><?php echo htmlspecialchars($que['question']); ?></p>
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <label>
                    <input type="radio" name="MTHoptions<?php echo $que['id']; ?>" value="<?php echo htmlspecialchars($que['option_' . $i]); ?>">
                    <?php echo htmlspecialchars($que['option_' . $i]); ?>
                </label>
            <?php endfor; ?>
        <?php endforeach; ?>

        <h1>GK Questions</h1>
        <?php foreach ($queData2 as $que2): ?>
            <p><span><?php echo htmlspecialchars($que2['id']); ?>. </span><?php echo htmlspecialchars($que2['question']); ?></p>
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <label class="answers">
                    <input type="radio" name="options<?php echo $que2['id']; ?>" value="<?php echo htmlspecialchars($que2['option_' . $i]); ?>">
                    <?php echo htmlspecialchars($que2['option_' . $i]); ?>
                </label>
            <?php endfor; ?>
        <?php endforeach; ?>

        <input type="submit" name="submit" value="Submit" style="display:block; margin:auto;margin-top:2%;">
    </form>
</div>
</body>
</html>
