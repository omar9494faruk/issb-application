<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
// Database connection
$conn =  mysqli_connect('localhost', 'searchli_mainDevAlpha','AkashBhoraTara@', 'searchli_TAT');
if(!$conn){
    die("Connection failed : " . mysqli_connect_error());
}


$stmt1 = $conn-> prepare("SELECT * FROM `images`");
$stmt1 -> execute();
$query = $stmt1 -> get_result();
$rowNumber = $query->num_rows;


// Generate 4 random numbers (1-4)
$randomNumbers = [];
while (count($randomNumbers) < 4) {
    $randNum = rand(1, $rowNumber);
    if (!in_array($randNum, $randomNumbers)) {
        $randomNumbers[] = $randNum;
    }
}

// Fetch images that match the generated numbers
$images = [];
foreach ($randomNumbers as $num) {


    $stmt2 = $conn-> prepare("SELECT image_data FROM images WHERE id = ?");
    $stmt2 -> bind_param("s",$num);
    $stmt2->execute();
    $result = $stmt2->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $images[] = "data:image/jpeg;base64," . base64_encode($row['image_data']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thematic Appreception Test</title>
    <link rel="stylesheet" href="style.css">

<script>
    let images = <?php echo json_encode($images); ?>;
    let currentIndex = 0;

    // Show the next image and set timer for 30 seconds
    function showNextImage() {
        if (currentIndex < images.length) {
            document.getElementById('imageContainer').src = images[currentIndex];
            document.getElementById('instruction').innerText = currentIndex < 2 ? "Write the story:" : "গল্প লেখ ঃ ";
            document.getElementById('imageContainer').style.display = 'block';
            setTimeout(hideImage, 30000); // 30 seconds per image
        } else {
            // All images displayed, redirect to another file
            window.location.href = '../../wish.php'; // Change 'nextPage.php' to the desired page
        }
    }

    // Hide image after 30 seconds and start countdown
    function hideImage() {
        document.getElementById('imageContainer').style.display = 'none';
        document.getElementById('timer').innerText = "Next image in 3:00";
        let countdown = 180; // 2 minutes 30 seconds

        const countdownInterval = setInterval(() => {
            let minutes = Math.floor(countdown / 60);
            let seconds = countdown % 60;
            document.getElementById('timer').innerText = `Next image in ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            if (countdown === 0) {
                clearInterval(countdownInterval);
                currentIndex++;
                showNextImage();
            }
            countdown--;
        }, 1000);
    }

    window.onload = showNextImage;
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
                    <li><a href="../../index.php" style="color:#fff">Home</a></li>
                    <li><a href="../../blogs/" style="color:#fff">Blogs</a></li>
                </ul>
            </div>
        </div>
    <h1>Thematic Appreception Test</h1>
    <p id="instruction"></p>
    <img id="imageContainer" src=""  alt="tat" style="margin: 10px; display: none;">
    <p id="timer"></p>
<?php
if(isset($stmt1)){
    $stmt1->close();
}
if(isset($stmt2)){
    $stmt2->close();
}
if(isset($conn)){
    $conn->close();
}
?>
</body>
</html>
