<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
// Database Connection
$conn = new mysqli("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_CT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$queryBangla = mysqli_query($conn, "SELECT * FROM `bangla`");
$queryEnglish = mysqli_query($conn, "SELECT * FROM `english`");
$rowNumberB = mysqli_num_rows($queryBangla);
$rowNumberE = mysqli_num_rows($queryEnglish);
// Generate Random Numbers
$random1 = rand(1, $rowNumberB);
$random2 = rand(1, $rowNumberE);

// Fetch Stories
$englishQuery = "SELECT story FROM english WHERE id IN ($random1, $random2)";
$banglaQuery = "SELECT story FROM bangla WHERE id IN ($random1, $random2)";

$englishResult = $conn->query($englishQuery);
$banglaResult = $conn->query($banglaQuery);

$stories = [];

while ($row = $englishResult->fetch_assoc()) {
    $stories[] = $row['story'];
}

while ($row = $banglaResult->fetch_assoc()) {
    $stories[] = $row['story'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Story Viewer</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const stories = <?php echo json_encode($stories); ?>;
            let index = 0;

            function showStory() {
                if (index < stories.length) {
                    document.getElementById('story-container').innerText = stories[index];
                    index++;
                    setTimeout(hideStory, 30000); // 30 seconds display
                } else {
                    window.location.href = "../tat/"; // Move to another file
                }
            }

            function hideStory() {
                document.getElementById('story-container').innerText = "";
                let countdown = 180;
                const timerElement = document.getElementById('timer');
                timerElement.innerText = `Next story in ${Math.floor(countdown / 60)}:${('0' + (countdown % 60)).slice(-2)}`;

                const timerInterval = setInterval(() => {
                    countdown--;
                    timerElement.innerText = `Next story in ${Math.floor(countdown / 60)}:${('0' + (countdown % 60)).slice(-2)}`;
                    if (countdown <= 0) {
                        clearInterval(timerInterval);
                        timerElement.innerText = "";
                        showStory();
                    }
                }, 1000);
            }

            showStory();
        });
    </script>
</head>
<body>
<div class="header-part">
            <div class="logo-area">
            <a href="index.php"><img src="../../images/logo.png" alt="Logo" srcset=""></a>
                <div class="text-area">
                    <p style="color:#fff">Lighting Your Way To Success</p>
                </div>
            </div>
            <div class="menu-area">
                <ul>
                    <li><a href="../../index.php" style="color:#fff">Home</a></li>
                    <li><a href="../../blogs/" style="color:#fff">Blogs</a></li>
                </ul>
            </div>
        </div>
    <p class="story-container"><div id="story-container" style="font-size: 20px; text-align: center; padding: 20px;"></div></p>
    <div id="timer" style="font-size: 18px; text-align: center; padding: 10px; color: red;"></div>
</body>
</html>