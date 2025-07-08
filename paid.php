<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Access</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'templates/uikit.php'; ?>
    <style>
        .header-part{
            margin-top:0;
        }
    </style>
</head>
<body>
        <div class="header-part">
            <div class="logo-area">
            <a href="index.php"><img src="images/logo.png" alt="Logo" srcset=""></a>
                <div class="text-area">
                    <p>Lighting Your Way To Success</p>
                </div>
            </div>
            <div class="menu-area">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="blogs">Blogs</a></li>
                </ul>
            </div>
            <div class="profile-area">
                <?php
                    if(isset($_SESSION['loggedIn']) != true){ ?>
                        <a href="goTo.php" class="uk-icon-link" uk-icon="icon: sign-in; ratio:2" style="color:#c4f1ff;"></a>
                <?php }else { ?>
                        <a href="profile.php" class="uk-icon-link" uk-icon="icon: user; ratio: 2" style="color:#c4f1ff;"></a>
                <?php }
                ?>

            </div>
        </div>
        <h1 style="text-align:center; color:#389d9f">Contact the numbers below for getting premium access(Whatsapp)</h1>
        <h2 style="text-align:center; color:#389d9f">016 2983 6687</h2>
        <h2 style="text-align:center; color:#389d9f">016 2983 6688</h2>

    
</body>
</html>