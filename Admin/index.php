<?php

session_start();
// if (!isset($_SESSION['username'])) {
    
//     header("Location: ../index.php");
//     exit();
// }
include 'adm-conf.php';
$message;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM ulala WHERE username='$username' AND email='$email'");
    $user = mysqli_fetch_assoc($result);

    if($user && $user['password']==$password){
        $_SESSION['username'] = $username;
        header('Location: update.php');
    }else{
        $message = "Invalid cridentials";
    }


}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header-part">
        <h1>Admin Panel</h1>
    </div>
    <div class="login-part">
    <div class="invalid">
        <p>
            <?php
                if(isset($message)){
                    echo $message;
                }
            ?>
        </p>
    </div>
    <h2>Give you admin credentials</h2>
    <form action="" method="post">
        <input type="text" name="username" id="" class="username input" placeholder="Username"><br>
        <input type="email" name="email" id="" class="email input" placeholder=" Email Address"><br>
        <input type="password" name="password" id="" class=" password input" placeholder="Password"><br>

        <input type="submit" value="Login" name="submit" class="submit">
    </form>
    </div>
</body>
</html>