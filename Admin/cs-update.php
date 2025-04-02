<?php

include 'verify.php';

$message;
$conn = mysqli_connect("localhost", "root", "", "CT");

    if(isset($_POST['submitEng'])){
        $storyEng = $_POST['story_english'];

        mysqli_query($conn, "INSERT INTO `english` (`story`) VALUES ('$storyEng')");

        $message = "New story has been added!";
    }

    if(isset($_POST['submitBan'])){
        $storyBan = $_POST['story_bangla'];

        mysqli_query($conn, "INSERT INTO `bangla` (`story`) VALUES ('$storyBan')");

        $message = "New story has been added!";
    }

    $listEng = mysqli_query($conn, "SELECT * FROM english ");
    $listBan = mysqli_query($conn, "SELECT * FROM bangla ");
    $rowsEng = mysqli_fetch_all($listEng, MYSQLI_ASSOC);
    $rowsBan = mysqli_fetch_all($listBan, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Completing update Update</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <h1 style="color:#1abc9c;">Completing Story Updates</h1>
    <p style="color:#1abc9c;">**In the boxes, enter the sentence you want to add. You must enter the topic in specified box according to language**</p>
    <div class="cs-main-part">
    <form action="" method="post">
        <input type="text" name="story_english" id="" placeholder="English Story Topic">
        <input type="submit" value="Add Story" name="submitEng" class="csSub">
    </form>
    <form action="" method="post">
        <input type="text" name="story_bangla" id="" placeholder="বাংলা Story Topic">
        <input type="submit" value="Add Story" name="submitBan" class="csSub">
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
                        <th>Story</th>
                    </tr>
                    <?php foreach( $rowsEng as $info ){ ?>
                        <tr>
                        <td><?php echo htmlspecialchars($info['id']); ?></td>
                        <td><?php echo htmlspecialchars($info['story']); ?></td>
                        </tr>
                    <?php  } ?>
                </table>
            </div>
            <div class="banTable">
                <table class="banglaTable">
                    <tr>
                        <th>id</th>
                        <th>story</th>
                    </tr>
                    <?php foreach( $rowsBan as $info ){ ?>
                        <tr>
                        <td><?php echo htmlspecialchars($info['id']); ?></td>
                        <td><?php echo htmlspecialchars($info['story']); ?></td>
                        </tr>
                    <?php  } 
                    $conn -> close(); ?>
                </table>
            </div>
            
        
        </div>
</body>
</html>