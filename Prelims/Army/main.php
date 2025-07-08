<?php
session_start();
if($_SESSION['loggedIn'] != true){
    header("Location: ../../index.php");
}
$conn =  mysqli_connect('localhost', 'searchli_mainDevAlpha', 'AkashBhoraTara@', 'searchli_pArmy');
$conn2 =  mysqli_connect('localhost', 'searchli_mainDevAlpha', 'AkashBhoraTara@', 'searchli_users');
$setNumber = $_SESSION['setN'] ?? null;
if ($setNumber) {
    $tableName = "set_".$setNumber;
    
    try {

        $stmt1 = $conn->prepare("SELECT * FROM `$tableName` ");
        $stmt1->execute();
        $query=$stmt1->get_result();
        $queData = $query->fetch_all(MYSQLI_ASSOC);


    } catch (mysqli_sql_exception $e) {
        die("Error fetching questions: " . $e->getMessage()); // Debugging message
    }
}


if(isset($_POST['submit'])){


    header('Location: result.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Army Preliminary Model Test</title>
    <link rel="stylesheet" href="style.css">

    <script src="assets/script.js"></script>
</head>
<body>
    <div class="header-part">
        <div class="logo-area">
        <a href="../../index.php"><img src="../../images/logo.png" alt="Logo" srcset=""></a>
            <div class="text-area">
                <p style="color:#fff">Lighting Your Way To Success</p>
            </div>
        </div>
        <div class="menu-area">
            <ul>
            </ul>
        </div>
    </div>
<div class="main-part">
    <h2 style="color:#389d9f;text-align:center;">Army Preliminary Model Test</h2>
    <form action="" method="post">
        <?php foreach ($queData as $question): ?>
            <p><?php echo $question['fileLink']; ?></p>
        <?php endforeach; ?>
        <div id="timer"></div>
        <input type="submit" name="submit" value="Submit">
    </form>

</div>
<?php
if(isset($stmt1)){
    $stmt1->close();
}
if(isset($conn)){
    $conn->close();
}
?>
<script>
  let submitClicked = false;
  const submitButton = document.querySelector('input[name="submit"]');

  // Track manual submission
  submitButton.addEventListener('click', () => {
    submitClicked = true;
  });

  // Timer setup
  let totalSeconds = 2 * 60 * 60; // 2 hours
  const timerElement = document.getElementById("timer");

  function updateTimerDisplay() {
    let hours = Math.floor(totalSeconds / 3600);
    let minutes = Math.floor((totalSeconds % 3600) / 60);
    let seconds = totalSeconds % 60;
    timerElement.textContent = 
      `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
  }

  updateTimerDisplay(); // Show timer immediately on load

  const timerInterval = setInterval(() => {
    totalSeconds--;

    if (totalSeconds >= 0) {
      updateTimerDisplay();
    } else {
      clearInterval(timerInterval);
      timerElement.textContent = "00:00:00";
      console.log("Timer ended");

      // 20 second delay before auto-submit
      setTimeout(() => {
        if (!submitClicked) {
          console.log("Auto-submitting...");
          submitButton.click();
        }
      }, 20000);
    }
  }, 1000);
</script>

</body>
</html>
