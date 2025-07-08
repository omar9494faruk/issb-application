<?php
session_start();
if ($_SESSION['adminLoggedIn'] != true) {
    
    header("Location: ../index.php");
    exit();
}
$conn = mysqli_connect("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_pArmy");
$query = mysqli_query($conn, "SELECT COUNT(*) AS table_count FROM information_schema.tables WHERE table_schema ='pArmy' ");
$Set = mysqli_fetch_assoc($query);

$tableShow = "SELECT table_name, table_rows FROM information_schema.tables WHERE table_schema = 'pArmy'";
$tableShowOut = $conn->query($tableShow);
$totalNumber =  $Set['table_count'];
$newTableName = "set_".$totalNumber+1;
$upSet;
if(isset($_POST['submit'])){
$selectedSet = $_POST['setNumber'];
$upSet = "set_". $selectedSet;
$question = $_POST['fileLink'];


$updateQuestion = mysqli_query($conn, "
                    INSERT INTO `$upSet` (`fileLink`) 
                    VALUES ('$question')
");

}

if(isset($_POST['addSet'])){
    $createTable = mysqli_query($conn,"CREATE TABLE $newTableName (
        id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fileLink VARCHAR(400) NOT NULL");
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Army Prelims Update</title>
    <link rel="stylesheet" href="style.css">

    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
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


        <input type="text" name="fileLink" id="" placeholder="Question">


        <input type="submit" value="Add Question" name="submit">
    </form>
    
    <table>
    <tr>
        <th>Table Name</th>
        <th>Number of Rows</th>
    </tr>

    <?php
    if ($tableShowOut->num_rows >= 0) {
        while ($row = $tableShowOut->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['table_name']}</td>
                    <td>{$row['table_rows']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No tables found</td></tr>";
    }
    $conn->close();
    ?>

</table>
<script>
        document.getElementById('setnumber').value = localStorage.getItem('selectedSet') || '';

        document.getElementById('setnumber').addEventListener('change', function() {
            localStorage.setItem('selectedSet', this.value);
        });
    </script>
</body>
</html>