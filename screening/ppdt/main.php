<?php
// main.php

$conn = new mysqli("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_ppdt");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get a random image ID (or latest etc.)
$sql = "SELECT id FROM images ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);
$imageId = '';

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imageId = $row['id'];
} else {
    echo "No image found.";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>PPDT Test</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #imageBox {
            display: block;
            text-align: center;
            margin-top: 50px;
            filter:blur(6px);
        }
        #timerBox {
            display: none;
            text-align: center;
            font-size: 24px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="header-part">
            <div class="logo-area">
            <div class="logo-main-area"><a href="../../index.php"><img src="../../images/logo.png" alt="Logo" srcset=""></a></div>
                <div class="text-area">
                    <p style="color:#fff">Lighting Your Way To Success</p>
                </div>
            </div>
            <div class="menu-area">
                <ul>
                    
                </ul>
            </div>
        </div>

<div id="imageBox">
    <img src="image.php?id=<?php echo $imageId; ?>" alt="Image from DB" width="400">
</div>

<div id="timerBox">
    Time ends in <span id="countdown">240</span> seconds...(4 mintutes)
</div>

<script>
    // After 30 seconds, hide image and start 5-minute timer
    setTimeout(function() {
        document.getElementById('imageBox').style.display = 'none';
        document.getElementById('timerBox').style.display = 'block';

        let secondsLeft = 300;
        let countdownSpan = document.getElementById('countdown');

        let countdown = setInterval(function() {
            secondsLeft--;
            countdownSpan.textContent = secondsLeft;
            if (secondsLeft <= 0) {
                clearInterval(countdown);
                window.location.href = "../../wish.php"; // Redirect after 5 minutes
            }
        }, 1000);

    }, 30000); // 30 seconds
</script>

</body>
</html>
