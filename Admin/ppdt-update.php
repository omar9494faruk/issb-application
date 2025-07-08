<?php
session_start();
if ($_SESSION['adminLoggedIn'] != true) {
    
    header("Location: ../index.php");
    exit();
}
// Database connection
$conn = mysqli_connect("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_ppdt");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted and file uploaded
if (isset($_POST['submit']) && isset($_FILES['image'])) {
    $imageName = $_FILES['image']['name'];
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $imageType = $_FILES['image']['type']; // Extract image type (e.g., image/jpeg)

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO images (image_name, image_data, image_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sbs", $imageName, $imageData, $imageType);
    $stmt->send_long_data(1, $imageData); // Correctly refers to the second parameter (BLOB data)

    if ($stmt->execute()) {
        $message = "Image uploaded successfully!";
    } else {
        $messageF = "Error uploading image: " . $stmt->error;
    }

    $stmt->close();
}

// Check if an image ID is requested for viewing
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize ID to prevent SQL injection

    // Fetch image data
    $stmt = $conn->prepare("SELECT image_data, image_type FROM images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    // Check if the image exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imageData, $imageType);
        $stmt->fetch();

        // Display the image
        header("Content-Type: $imageType");
        echo $imageData;
        exit; // Stop further execution
    } else {
        echo "Image not found.";
        exit;
    }
}

// Display all uploaded images
$result = $conn->query("SELECT id, image_name FROM images");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDT Update</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <h1 style="color:#9b59b6;">PPDT Updates</h1>
    <p style="color:#9b59b6;">Choose image from you device by clicking "Choose file"</p>
    <p>
        <?php
            if (isset($message)) {
                echo $message;
            }
            if (isset($messageF)) {
                echo $messageF;
            }

            $conn->close();
        ?>
    </p>

    <form action="" method="post" enctype="multipart/form-data" class="tat-form">
        <input type="file" name="image" required>
        <input type="submit" value="Upload" name="submit" class="tatSub">
    </form>

    <h2 style="color:#9b59b6;">Uploaded Images</h2>
    <div class="banTable" style="width:100%;">
        <table class="banglaTable" width="90%" style="margin:auto">
            <tr>
                <th>id</th>
                <th>Essay topic</th>
            </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><img src="?id=<?php echo $row['id']; ?>" width="200" alt="<?php echo htmlspecialchars($row['image_name']); ?>"></td>
            </tr>
        <?php endwhile;?>
        </table>
    </div>
            


</body>
</html>
