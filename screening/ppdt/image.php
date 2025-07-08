<?php
// image.php

$conn = new mysqli("localhost", "searchli_mainDevAlpha", "AkashBhoraTara@", "searchli_ppdt");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Get image by ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT image_data, image_type FROM images WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Content-Type: " . $row['image_type']);
    echo $row['image_data'];
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Image not found.";
}

$conn->close();
?>
