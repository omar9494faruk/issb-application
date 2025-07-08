<?php
session_start();
include 'conf.php';

if(isset($_POST['register'])){
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $phoneNumber = filter_var($_POST['phoneNumber'], FILTER_SANITIZE_NUMBER_INT);

    // $register_data = mysqli_query($conn, " 
    // INSERT INTO `user_details` (`Name`, `username`, `password`, `email`, `phone_number`) 
    // VALUES ('$name', '$username', '$password', '$email', '$phoneNumber') " );

   $stmt1 = $conn -> prepare("INSERT INTO `user_details` (`Name`, `username`, `password`, `email`, `phone_number`) VALUES (?, ?, ?, ?, ?) ");
   $stmt1->bind_param("sssss", $name, $username, $password, $email, $phoneNumber);
   $stmt1->execute();


 $stmt3 = $conn -> prepare(
    "INSERT INTO `user_test_appear` (`id`, `name`, `username`, `email`, `iq`, `wat`, `tat`, `sentence`, `story`, `essay`, `ppdt`, `pNavy`, `pArmy`, `pBafaIQ`, `pBafaElse`) 
    VALUES (NULL, ?, ?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)"
);
   $stmt3->bind_param("sss", $name, $username, $email,);
   $stmt3->execute();




    $message = "Your account has been registered. You can login with you email and password";

    // $verify = mysqli_query($conn, "SELECT email FROM user_details WHERE email = '$email'");
    // $verify_result= mysqli_fetch_assoc($verify);

    $stmt2 = $conn-> prepare("SELECT email FROM user_details WHERE email = ?");
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $verify_result = $result->fetch_assoc();
    if($verify_result == $email){
        $showError = "Email still exist";
    }
}

if(isset($_POST['login'])){
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];


    $stmt3 = $conn-> prepare("SELECT * FROM `user_details` WHERE email = ?");
    $stmt3->bind_param('s', $email);
    $stmt3->execute();
    $result = $stmt3->get_result();
    $verify_result = $result-> fetch_assoc();

    // $verify = mysqli_query($conn, "SELECT * FROM user_details");
    // $verify_result= mysqli_fetch_assoc($verify);

    if($verify_result['email'] == $email ){
        if($verify_result['password'] == $password){
            $_SESSION['loggedIn'] = true;
            $_SESSION['email'] = $email;
            if($verify_result['user_type'] == 'premium'){
                $_SESSION['user_type'] = 'premium';
            }else{
                $_SESSION['user_type'] = 'regular';
            }
            header('Location: index.php');
        }else{
            $wrongPass = "Password you entered is wrong";
        }
    }else{
        $wrongMail = "Wrong email address";
    }
}

if(isset($stmt1)){
    $stmt1->close();
}
if(isset($stmt2)){
    $stmt2->close();
}
if(isset($stmt3)){
    $stmt3->close();
}
if(isset($conn)){
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Light</title>
    <?php include 'templates/uikit.php'; ?>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
</head>
<body>
    <div class="goto-hero-bg">
<div class="goto-header-part header-part">
            <div class="logo-area">
                <a href="index.php"><img src="images/logo.png" alt="Logo" srcset=""></a>
                <div class="text-area">
                    <p>Lighting Your Way To Success</p>
                </div>
            </div>
            <div class="menu-area">
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">Blogs</a></li>
                </ul>
            </div>
</div>
    
<div class="goto-main-part">
    <p>
        <?php
            if(isset($wrongMail)){
                echo $wrongMail;
            }
            if(isset($wrongPass)){
                echo $wrongPass;
            }
            if(isset($message)){
                echo $message;
            }
        ?>
    </p>
    <div class="registration">
        <h2>Registration</h2>
        <form action="" method="post">
            <input type="text" name="name" id="" placeholder="Name" required>
            <input type="email" name="email" id="" placeholder="Email Address" required><br>
            <input type="text" name="username" id="" placeholder="Username" required>
            <input type="password" name="password" id="" placeholder="Password" required><br>
            <input type="text" name="phoneNumber" id="" placeholder="Phone Number" required><br>

            <input type="submit" value="Register" name="register" class="entryReg">
        </form>
    </div>
    <div class="login">
        <h2>Login</h2>
        <form action="" method="post">
            <input type="text" name="email" id="" placeholder="Email Adress"><br>
            <input type="password" name="password" id="" placeholder="Password" ><br>
            <input type="submit" value="Login" name="login" class="entry">
        </form>
    </div>
</div>
</div>

    <script src="script.js"></script>
</body>
</html>