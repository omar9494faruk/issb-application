<?php
session_start();

$conn = mysqli_connect('localhost', 'searchli_mainDevAlpha', 'AkashBhoraTara@', 'searchli_Notice');
$stmt = $conn -> prepare("SELECT msg FROM message");
$stmt->execute();
$result = $stmt->get_result();
$notice = $result->fetch_assoc();

if(isset($_POST['inquirySub'])){
    $name = $_POST['name'];
    $phone = $_POST['inquiryPhone'];
    $message = $_POST['inquiry'];

    $stmt1 = $conn-> prepare("INSERT INTO `inqMessage` (`name`, `phoneNumber`, `message`) 
                            VALUES (?, ?, ?)");
    $stmt1 -> bind_param('sss', $name, $phone, $message);
    $stmt1->execute();
    $inqMessage = "Your message has been sent. Our support team will contact you as soon as possible.";

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
    <?php if(isset($notice)){ ?>
    <div class="notice">
        <marquee behavior="scroll" direction="left" style="margin-bottom:-1.5%;"><span style="color:red;font-weight:bold;">You must log in to give tests. </span> <?php echo htmlspecialchars($notice['msg']); ?></marquee>
    </div>
    <?php } ?>
    <div class="hero-bg">
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
                        <a href="goTo.php" class="uk-icon-link" uk-icon="icon: sign-in; ratio:2" style="color:#c4f1ff;">LOG IN</a>
                <?php }else { ?>
                        <a href="profile.php" class="uk-icon-link" uk-icon="icon: user; ratio: 2" style="color:#c4f1ff;"></a>
                <?php }
                ?>

            </div>
        </div>
    
    </div>
    <div class="course-area">
        <h1>Our Services</h1>
        <ul>
            <li>
                <a href="Prelims">
                <img src="images/prelims.webp" alt="">
                    <span>Armed Forces Preli Model Tests</span>
                </a>
            </li>
            <li>
                <a href="pt">
                <img src="images/issbMock.webp" alt="">
                <span>ISSB Personality Mock Tests</span>
                </a>
            </li>
            <li>
                <a href="">
                <img src="images/issbInst.webp" alt="">
                <span>ISSB Instructions</span>
                </a>
            </li>
            <li>
                <a href="screening/iq">
                <img src="images/prelims.webp" alt="">
                    <span>ISSB IQ Mock Test</span>
                </a>
            </li>
            <li>
                <a href="personal.php">
                <img src="images/person.png" alt="">
                <span>Personalized Consultation</span>
                </a>
            </li>

            <li>
                <a href="screening/ppdt">
                <img src="images/ppdt-ico.png" alt="">
                    <span>ISSB PPDT Test</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="contact-area">
        <h1>Contact Us</h1>
        <h3>If you have any queries, if you want to get enrolled in any course or want to get the premium access of SEATCHLIGHT, please let us know. Our support team will reach to you.</h3>
        <form action="" method="post">
            <textarea name="inquiry" id="" placeholder="Put your message here" style="width:50%; height:200px;"></textarea><br>
            <input type="text" name="name" id="" placeholder="Name" class="inqPhone"><br>
            <input type="text" name="inquiryPhone" id="" placeholder="Phone Number" class="inqPhone"><br>

            <input type="submit" value="Send" name="inquirySub" class="inquirySub">
        </form>
    </div>

    <script src="script.js"></script>
    <?php if(isset($inqMessage)){ ?>
        <script>
            alert("<?php echo $inqMessage; ?> ");
        </script>
    <?php } ?>
</body>
</html>