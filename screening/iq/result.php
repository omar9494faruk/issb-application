<?php
session_start();
require 'config.php';
$wrongId = $_SESSION['wrongInp'];
$noAnswer = $_SESSION['notAnswered'];
$setNumber = $_SESSION['setN'] ?? null;
if($setNumber){
    $tableName = "set_" . $setNumber;
}


$placeholders1 = implode(',', array_fill(0, count($wrongId), '?'));
$stmt1 = $conn -> prepare("SELECT * FROM $tableName WHERE id IN ($placeholders1)");
$types1 = str_repeat('i', count($wrongId));
$stmt1 -> bind_param($types1, ...$wrongId);
$stmt1 -> execute();
$query = $stmt1 -> get_result();
$verify = $query->fetch_all(MYSQLI_ASSOC);



$placeholders2 = implode(',', array_fill(0, count($noAnswer), '?'));
$stmt2 = $conn -> prepare("SELECT * FROM $tableName WHERE id IN ($placeholders2)");
$types2 = str_repeat('i', count($noAnswer)); // Assuming IDs are integers
$stmt2->bind_param($types2, ...$noAnswer);
$stmt2 -> execute();
$query2 = $stmt2-> get_result();
$verify2 = $query2->fetch_all(MYSQLI_ASSOC);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test Result</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="header-part">
            <div class="logo-area">
            <div class="logo-main-area"><a href="../../index.php"><img src="../images/logo.png" alt="Logo" srcset=""></a></div>
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
        <h1>Wrong Answers</h1>
    <?php foreach($verify as $data) { ?>

        <p><span><?php echo htmlspecialchars($data['id']); ?>. </span><?php echo htmlspecialchars($data['question']); ?></p>
        <p><span>Correct Answer: </span><?php echo htmlspecialchars($data['answer']); ?></p>
    <?php } ?><br>


    <h2>Questions Not answered</h2>
    <?php foreach($verify2 as $data2) { ?>


        <p><span><?php echo htmlspecialchars($data2['id']); ?>. </span><?php echo htmlspecialchars($data2['question']); ?></p>
        <p><span>Correct Answer: </span><?php echo htmlspecialchars($data2['answer']); ?></p>

    <?php } ?><br>
    
    </div>
<?php
if(isset($stmt1)){
    $stmt1->close();
}if(isset($stmt2)){
    $stmt2->close();
}
if(isset($conn)){
    $conn->close();
}

?>
</body>
</html>
