<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
// Database connection


// Create connection
$conn = new mysqli("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_fb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch 25 random rows from the 'english' table


$stmt1 = $conn-> prepare("SELECT engSent FROM english ORDER BY RAND() LIMIT 25");
$stmt1 ->execute();
$result = $stmt1->get_result();

$sentences = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sentences[] = $row['engSent'];
    }
} else {
    echo "No sentences found in the database.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completing Sentences</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let timeLimit = 5 * 60; // 5 minutes in seconds
        let timer;

        function startTimer() {
            let minutes, seconds;

            timer = setInterval(function() {
                minutes = Math.floor(timeLimit / 60);
                seconds = timeLimit % 60;

                // Display timer in MM:SS format
                document.getElementById("timer").textContent = minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);

                if (timeLimit <= 0) {
                    clearInterval(timer);
                    // Redirect to result page after 5 minutes
                    window.location.href = 'fb-ban.php'; // Change 'result.php' to your destination page
                } else {
                    timeLimit--;
                }
            }, 1000);
        }

        // Start the timer immediately when the page loads
        window.onload = function() {
            startTimer();
        };
    </script>
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

    <h1 class="text">Completing Sentences : English </h1>
    <div class="text" id="timer" style="font-size: 30px; font-weight: bold;">5:00</div>

    <h3>English Sentences:</h3>
    <ol class="sentence">
        <?php foreach ($sentences as $sentence): ?>
            <li><?php echo htmlspecialchars($sentence); ?></li>
        <?php endforeach; ?>
    </ol>

</body>
<?php
if(isset($stmt1)){
    $stmt1->close();
}
if(isset($conn)){
    $conn->close();
}
?>
</html>
