<?php 
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: index.php");
}

$conn = mysqli_connect('localhost','searchli_mainDevAlpha','AkashBhoraTara@','searchli_users');

$eligibility = $conn-> prepare("SELECT * FROM `user_details` WHERE `email` = ? ");
$eligibility-> bind_param("s", $_SESSION['email']);
$eligibility->execute();
$robo = $eligibility-> get_result();
$eligible = $robo -> fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    <?php include 'templates/uikit.php'; ?>
    <style>
        .header-part{
            margin-top:0;
        }
        .header-part .logo-area .text-area {
            color:#fff !important;
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
                <li><a href="index.php">Home</a></li>
                <li><a href="blogs">Blogs</a></li>
            </ul>
        </div>
        <div class="profile-area">
            <a href="logout.php" class="uk-icon-link" uk-icon="icon: sign-out; ratio:2" style="color:#c4f1ff;"></a>
        </div>
    </div>
    <div class="main-profile-area">
        <h1>Profile Details</h1>
        <ul>
            <li><p><span>Name: </span><?php echo htmlspecialchars($eligible['Name']) ?></p></li>
            <li><p><span>Email Address: </span><?php echo htmlspecialchars($eligible['email']) ?></p></li>
            <li><p><span>Username: </span><?php echo htmlspecialchars($eligible['username']) ?></p></li>
            <li><p><span>Phone Number: </span><?php echo htmlspecialchars($eligible['phone_number']) ?></p></li>
            <li><p><span>User type: </span><?php echo htmlspecialchars($eligible['user_type']) ?></p></li>
        </ul>
        <h3><a href="paid.php">Click Here</a> to get the premium version of <span style="font-weight:bold; color:#389d9f;">SEARCH LIGHT</span></h3>
    </div>
</body>
</html>