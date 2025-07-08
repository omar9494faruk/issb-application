<?php
session_start();
if ($_SESSION['adminLoggedIn'] != true) {
    
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATES</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="update">
        <h2>Air Force Preliminary Question Admin Panel</h2>
    <ul>
        <li><a href="pAFiq-update.php">AF Prelims IQ</a></li>
        <li><a href="pAFeng-update.php">AF Prelims English</a></li>
        <li><a href="pAFmath-update.php">AF Prelims Maths</a></li>
        <li><a href="pAFphy-update.php">AF Prelims Physics</a></li>

    </ul>
    </div>
</body>
</html>