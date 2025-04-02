<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
// database connection


$conn = new mysqli("localhost", "root", "", "essay");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get random topic from a table
function getRandomTopic($table) {
    global $conn;

    $stmt1 = $conn-> prepare("SELECT topic FROM $table ORDER BY RAND() LIMIT 1");
    $stmt1 ->execute();
    $result = $stmt1->get_result();



    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['topic'];
    } else {
        return null;
    }
}

$englishTopic = getRandomTopic('engTopic');
$banglaTopic = getRandomTopic('banTopic');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essay Timer</title>
    <style>
        .topic { font-size: 24px; font-weight: bold; }
        #timer, #topicDisplay { margin-top: 20px; }
    </style>
</head>
<body>

    <div id="timer">Waiting for 2 minutes...</div>
    <div id="topicDisplay" class="topic"></div>

    <script>
        let englishTopic = "<?php echo $englishTopic; ?>";
        let banglaTopic = "<?php echo $banglaTopic; ?>";
        let englishTimer, banglaTimer, finalTimer;

        // Timer function to handle all the timers
        function startTimer(duration, display, callback) {
            let timer = duration, minutes, seconds;
            let interval = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    callback();
                }
            }, 1000);
        }

        // 1. Wait for 2 minutes
        setTimeout(() => {
            document.getElementById("timer").textContent = "Starting...";
            
            // Show English topic for 30 seconds
            document.getElementById("topicDisplay").textContent = englishTopic;
            startTimer(30, document.getElementById("timer"), function() {
                document.getElementById("topicDisplay").textContent = ""; // Hide topic
                startTimer(240, document.getElementById("timer"), function() { // 4 mins timer
                    // Show Bangla topic for 30 seconds
                    document.getElementById("topicDisplay").textContent = banglaTopic;
                    startTimer(30, document.getElementById("timer"), function() {
                        document.getElementById("topicDisplay").textContent = ""; // Hide topic
                        startTimer(300, document.getElementById("timer"), function() { // 5 mins timer
                            window.location.href = "../../wish.php"; // Redirect after 5 minutes
                        });
                    });
                });
            });
        }, 0); // Wait for 2 minutes before starting (2 minutes = 120000 milliseconds)
    </script>

<?php
if(isset($stmt1)){
    $stmt1->close();
}
if(isset($conn)){
    $conn->close();
}
?>
</body>
</html>
