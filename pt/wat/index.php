<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}

$conn =  mysqli_connect('localhost', 'root','', 'WAT');
if(!$conn){
    die("Connection failed : " . mysqli_connect_error());
}


$stmt1 = $conn -> prepare("SELECT * FROM `words`");
$stmt1->execute();
$query = $stmt1->get_result();
$rowNumber = $query->num_rows;
// Generate a random number between 1 and the number of rows
$randomNumber = rand(1, $rowNumber);

// Fetch the word content from the database if the random number matches a word ID



$stmt2 = $conn-> prepare("SELECT words FROM words WHERE id = ?");
$stmt2 -> bind_param("s",$randomNumber);
$stmt2->execute();
$result = $stmt2->get_result();
$rowsN =  $result-> num_rows;

if ($rowsN > 0) {
    $row = $result->fetch_assoc();
    $wordContent = $row['words'];
} else {
    $wordContent = "No matching words found in the database.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>WAT</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const wordsContainer = document.getElementById("words");
            const startButton = document.getElementById("startButton");
            const wordCount = document.getElementById("wordCount");
            const words = wordsContainer.innerText.trim().split(" ");
            const clickSound = new Audio("click.mp3"); // Add a click sound file in your project

            let index = 0;
            let wordCounter = 0; // Counter to track how many words have been shown
            const maxWords = 80; // Maximum number of words to show

            // Display word count
            wordCount.innerText = `Total Words: ${words.length}`;

            function changeWord() {
                clickSound.play().catch(err => console.warn("Audio playback prevented by browser policy."));
                wordsContainer.innerText = words[index];
                index = (index + 1) % words.length; // Loop through words
                wordCounter++; // Increment word counter

                
                // Stop the word switching after showing 80 words
                if (wordCounter >= maxWords) {
                    clearInterval(wordInterval); // Stop the interval
                    window.location.href = "../../wish.php"; // Redirect to another page
                }
            }

            // Hide words initially
            wordsContainer.style.display = "none";

            // Start the word switching on button click
            startButton.addEventListener("click", function () {
                // Show the words and hide the start button
                wordsContainer.style.display = "block"; 
                startButton.style.display = "none"; 
                wordCount.style.display = "none";

                // Show the first word from the start
                changeWord();

                // Change word every 10 seconds
                wordInterval = setInterval(changeWord, 10000);
            });
        });
    </script>
</head>
<body>
    <div class="header">
        <h1>WAT Practice for ISSB</h1>
    </div>
    <h2>
        <div class="wordCount" id="wordCount" style="display:none;"></div>
    </h2>
    <div id="words" class="words">
        <?php echo $wordContent; ?>
    </div>

    <!-- Start Button -->
    <button id="startButton">Start</button>

    <div class="footer">
        <p>All rights reserved | 2025</p>
    </div>
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
