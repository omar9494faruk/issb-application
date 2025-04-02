<?php

$conn = mysqli_connect("localhost", "root", "", "IQ");
$query = mysqli_query($conn, "SELECT COUNT(*) AS table_count FROM information_schema.tables WHERE table_schema ='IQ' ");
$Set = mysqli_fetch_assoc($query);
$totalNumber =  $Set['table_count'];
$newTableName = "set_".$totalNumber+1;
$upSet;
if(isset($_POST['submit'])){
$selectedSet = $_POST['setNumber'];
$upSet = "set_". $selectedSet;

$question = $_POST['question'];
$option1 = $_POST['option1'];
$option2 = $_POST['option2'];
$option3 = $_POST['option3'];
$option4 = $_POST['option4'];
$answer = $_POST['answer'];

$updateQuestion = mysqli_query($conn, "
                    INSERT INTO `set_1` (`question`, `option_1`, `option_2`, `option_3`, `option_4`, `answer`) 
                    VALUES ('$question', '$option1', '$option2', '$option3', '$option4', '$answer')
");

}

if(isset($_POST['addSet'])){
    $createTable = mysqli_query($conn,"CREATE TABLE $newTableName (
        id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        question VARCHAR(400) NOT NULL,
        option_1 VARCHAR(400) NOT NULL,
        option_2 VARCHAR(400) NOT NULL,
        option_3 VARCHAR(400) NOT NULL,
        option_4 VARCHAR(400) NOT NULL,
        answer VARCHAR(400))");
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update IQ</title>
</head>
<body>
<?php include 'menu.php'; ?>

    <h3>Add new set</h3>
    <form action="" method="post">
        <input type="submit" value="Add new set" name="addSet">
    </form>

    <form action="" method="post">

        <select name="setNumber" id="setnumber">
            <?php $i = 1; while ($i <= $totalNumber) {  ?>
            <option value="<?php echo htmlspecialchars($i); ?>">Set <?php echo htmlspecialchars($i); ?></option>
            <?php $i++; } ?>
        </select><br>

        <input type="text" name="question" id="" placeholder="Question">
        <input type="text" name="option1" id="" placeholder="Option 1">
        <input type="text" name="option2" id="" placeholder="Option 2">
        <input type="text" name="option3" id="" placeholder="Option 3">
        <input type="text" name="option4" id="" placeholder="Option 4">
        <input type="text" name="answer" id="" placeholder="Answer">

        <input type="submit" value="Add Question" name="submit">
    </form>
    
    
</body>
</html>