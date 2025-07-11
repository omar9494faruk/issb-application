<?php
session_start();
include 'config.php';
$setNumber = $_SESSION['setN'] ?? null;
$queData = []; // Default empty array
$no = [];
$inpAns = [];
if ($setNumber) {
    $tableName = "set_" . $setNumber;
    
    try {

        $stmt1 = $conn->prepare("SELECT * FROM `$tableName` ");
        $stmt1->execute();
        $query=$stmt1->get_result();
        $queData = $query->fetch_all(MYSQLI_ASSOC);


    } catch (mysqli_sql_exception $e) {
        die("Error fetching questions: " . $e->getMessage()); // Debugging message
    }
}




if(isset($_POST['submit'])){
    foreach($queData as $que){
        $opName = "options" . $que['id'];
        $gAns = $_POST[$opName];
        $cAns = $que['answer'];
        if(!isset($_POST[$opName])){
            array_push($no,$que['id']);
            $_SESSION['notAnswered'] = $no;
        }
        if(isset($_POST[$opName])){
            if($gAns != $cAns){
                array_push($inpAns, $que['id']);
                $_SESSION['wrongInp'] = $inpAns;
                header('Location: result.php');
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Application</title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.23.4/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="assets/style.css">

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.23.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.23.4/dist/js/uikit-icons.min.js"></script>

    <script src="assets/script.js"></script>
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
<div class="main-part">
    <form action="" method="post">
        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
            <?php foreach($queData as $queNum) { ?>
                <li class="qNum <?php echo htmlspecialchars($queNum['id']); ?>"><a href="#"><?php echo htmlspecialchars($queNum['id']); ?></a></li>
            <?php } ?>
        </ul>
        <div class="uk-switcher uk-margin">

            <?php foreach($queData as $queNum) { ?>
                <div>
                <a href="#" uk-switcher-item="previous" uk-icon="icon: chevron-left; ratio: 3.5" class="prev-button"></a>
                    <p><?php echo htmlspecialchars($queNum['question']); ?></p>
                    <ul class="options">
                        <li><input class="qNum <?php echo htmlspecialchars($queNum['id']); ?>" type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_1']); ?>"><label for="op1"><?php echo htmlspecialchars($queNum['option_1']); ?></label></li>
                        <li><input class="qNum <?php echo htmlspecialchars($queNum['id']); ?>" type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_2']); ?>"><label for="op2"><?php echo htmlspecialchars($queNum['option_2']); ?></label></li>
                        <li><input class="qNum <?php echo htmlspecialchars($queNum['id']); ?>" type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_3']); ?>"><label for="op3"><?php echo htmlspecialchars($queNum['option_3']); ?></label></li>
                        <li><input class="qNum <?php echo htmlspecialchars($queNum['id']); ?>" type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_4']); ?>"><label for="op4"><?php echo htmlspecialchars($queNum['option_4']); ?></label></li>
                    </ul>
                    <a href="#" uk-switcher-item="next" uk-icon="icon: chevron-right; ratio: 3.5" class="next-button"></a>
                </div>
            <?php } ?>

        </div>
        <input type="submit" name="submit" value="Submit" class="iqSubmit">
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
