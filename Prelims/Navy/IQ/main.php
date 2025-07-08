<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../../index.php");
}
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
        $cAns = $que['answer'];

        if(!isset($_POST[$opName])){
            $no[] = $que['id'];
        } else {
            $gAns = $_POST[$opName];
            if($gAns != $cAns){
                $inpAns[] = $que['id'];
            }
        }
    }

    // Set session values after loop
    $_SESSION['notAnswered'] = $no;
    $_SESSION['wrongInp'] = $inpAns;

    // Redirect only once, after processing all questions
    header('Location: result.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navy Preliminary Test</title>
    <link rel="stylesheet" href="assets/style.css">



    <script src="assets/script.js"></script>
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
    <h1>Navy Preliminary IQ Test</h1>
    <form action="" method="post">
            <?php foreach($queData as $queNum) { ?>
                    <p><span><?php echo htmlspecialchars($queNum['id']); ?>. </span><?php echo htmlspecialchars($queNum['question']); ?></p>
                    <ul>
                        <li><input type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_1']); ?>"><label for="op1"><?php echo htmlspecialchars($queNum['option_1']); ?></label></li>
                        <li><input type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_2']); ?>"><label for="op2"><?php echo htmlspecialchars($queNum['option_2']); ?></label></li>
                        <li><input type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_3']); ?>"><label for="op3"><?php echo htmlspecialchars($queNum['option_3']); ?></label></li>
                        <li><input type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_4']); ?>"><label for="op4"><?php echo htmlspecialchars($queNum['option_4']); ?></label></li>
                        <li><input type="radio" name="options<?php echo htmlspecialchars($queNum['id']); ?>" value="<?php echo htmlspecialchars($queNum['option_5']); ?>"><label for="op4"><?php echo htmlspecialchars($queNum['option_5']); ?></label></li>
                    </ul>
            <?php } ?>
        

        <input type="submit" name="submit" value="Submit">
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
