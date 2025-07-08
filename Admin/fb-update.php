<?php
session_start();
if ($_SESSION['adminLoggedIn'] != true) {
    
    header("Location: ../index.php");
    exit();
}


$message;
$conn = mysqli_connect("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_fb");

    if(isset($_POST['engSubmit'])){
        $words = $_POST['sentence_english'];

        mysqli_query($conn, "INSERT INTO `english` (`id`, `engSent`) VALUES (NULL, '$words')");

        $message = "New sentence has been added!";
    }
    if(isset($_POST['banSubmit'])){
        $words = $_POST['sentence_bangla'];

        mysqli_query($conn, "INSERT INTO `bangla` (`id`, `banSent`) VALUES (NULL, '$words')");

        $message = "New sentence has been added!";
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
    <title>Completing sentence Update</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <h1 style="color:#C4E538;">Completing Sentences Updates</h1>
    <p style="color:#C4E538;">**In the boxes, enter the sentence you want to add. You must enter the topic in specified box according to language**</p>
    <div class="fb-main-part">
    <form action="" method="post">
        <input type="text" name="sentence_english" id="" placeholder="English Sentence">
        <input type="submit" name="engSubmit" value="Add sentence" class="fbSub">
    </form>
    <form action="" method="post">
        <input type="text" name="sentence_bangla" id="" placeholder="বাংলা Sentence">
        <input type="submit"  name="banSubmit" value="Add sentence" class="fbSub">
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
                        <th>Sentences</th>
                    </tr>
                    <?php foreach( $rowsEng as $info ){ ?>
                        <tr>
                        <td><?php echo htmlspecialchars($info['id']); ?></td>
                        <td><?php echo htmlspecialchars($info['engSent']); ?></td>
                        </tr>
                    <?php  } ?>
                </table>
            </div>
            <div class="banTable">
                <table class="banglaTable">
                    <tr>
                        <th>id</th>
                        <th>Sentences</th>
                    </tr>
                    <?php foreach( $rowsBan as $info ){ ?>
                        <tr>
                        <td><?php echo htmlspecialchars($info['id']); ?></td>
                        <td><?php echo htmlspecialchars($info['banSent']); ?></td>
                        </tr>
                    <?php  } 
                    $conn -> close(); ?>
                </table>
            </div>
            
        
        </div>

    </div>
    </div>
</body>
</html>