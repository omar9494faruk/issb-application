<?php
session_start();
if ($_SESSION['adminLoggedIn'] != true) {
    
    header("Location: ../index.php");
    exit();
}


$message;
$conn = mysqli_connect("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_essay");

    if(isset($_POST['submitEng'])){
        $words = $_POST['words_english'];

        mysqli_query($conn, "INSERT INTO `engTopic` (`id`, `topic`) VALUES (NULL, '$words')");

        $message = "New topic has been added!";
    }
    if(isset($_POST['submitBan'])){
        $words = $_POST['words_bangla'];

        mysqli_query($conn, "INSERT INTO `banTopic` (`id`, `topic`) VALUES (NULL, '$words')");

        $message = "New topic has been added!";
    }

    $listEng = mysqli_query($conn, "SELECT * FROM engTopic ");
    $listBan = mysqli_query($conn, "SELECT * FROM banTopic ");
    $rowsEng = mysqli_fetch_all($listEng, MYSQLI_ASSOC);
    $rowsBan = mysqli_fetch_all($listBan, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essay Update</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<?php include 'menu.php'; ?>
    <h1>Essay Topic Updates</h1>
    <p>**In the boxes, enter the topic you want to add. You must enter the topic in specified box according to language**</p>
    <div class="essay-main-part">
    <form action="" method="post">
        <input type="text" name="words_english" id="" placeholder="English Essay Topic">
        <input type="submit" value="Add topic" name="submitEng" class="submitBan">
    </form>
    <form action="" method="post">
        <input type="text" name="words_bangla" id=""  placeholder="বাংলা Essay Topic">
        <input type="submit" value="Add topic" name="submitBan" class="submitBan">
    </form>

    <div class="message">
        <p>
            <?php
                if(isset($message)){
                    echo $message;
                }
            ?>
        </p>
    </div>
        <div class="tables">
            <div class="engTable">
                <table class="englishTable">
                    <tr>
                        <th>id</th>
                        <th>Essay topic</th>
                    </tr>
                    <?php foreach( $rowsEng as $info ){ ?>
                        <tr>
                        <td><?php echo htmlspecialchars($info['id']); ?></td>
                        <td><?php echo htmlspecialchars($info['topic']); ?></td>
                        </tr>
                    <?php  } ?>
                </table>
            </div>
            <div class="banTable">
                <table class="banglaTable">
                    <tr>
                        <th>id</th>
                        <th>Essay topic</th>
                    </tr>
                    <?php foreach( $rowsBan as $info ){ ?>
                        <tr>
                        <td><?php echo htmlspecialchars($info['id']); ?></td>
                        <td><?php echo htmlspecialchars($info['topic']); ?></td>
                        </tr>
                    <?php  } 
                    $conn -> close(); ?>
                </table>
            </div>
            
        </div>
    </div>    
</body>
</html>