<?php


session_start();
if ($_SESSION['adminLoggedIn'] != true) {
    
    header("Location: ../index.php");
    exit();
}

$message;
$conn = mysqli_connect("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_wat");

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $words = $_POST['words'];

        mysqli_query($conn, "INSERT INTO `words` (`id`, `words`) VALUES (NULL, '$words')");

        $message = "New words has been added!";
    }

    $list = mysqli_query($conn, "SELECT * FROM words ");
    $rows = mysqli_fetch_all($list, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wat Update</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="wat-main">
        <h2 style="color:#f1c40f;">Wat Updates</h2>
        <p style="color:#f1c40f;">**Write 80 words in a single para separated by a space. Click submit to add the words to the databse**</p>
        <div class="wat-form">
            <form action="" method="post">
                <textarea name="words" id="" required></textarea><br>
                <input type="submit" value="Add words" class="watSub">
            </form>
        </div>

        <div class="message">
            <p>
                <?php
                    if(isset($message)){
                        echo $message;
                    }
                ?>
            </p>
        </div>
        <div class="wat-lists">
            <div class="banTable" style="width:100%;">
                    <table class="banglaTable" width="90%" style="margin:auto">
                        <tr>
                            <th>id</th>
                            <th>Essay topic</th>
                        </tr>
                        <?php foreach( $rows as $info ){ ?>
                            <tr>
                            <td><?php echo htmlspecialchars($info['id']); ?></td>
                            <td><?php echo htmlspecialchars($info['words']); ?></td>
                            </tr>
                        <?php  } 
                        $conn -> close(); ?>
                    </table>
            </div>
        </div>
    </div>

</body>
</html>