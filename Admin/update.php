<?php
session_start();
if ($_SESSION['adminLoggedIn'] != true) {
    
    header("Location: ../index.php");
    exit();
}

$conn = mysqli_connect('localhost','searchli_mainDevAlpha','AkashBhoraTara@','searchli_users');
$conn2 = mysqli_connect('localhost','searchli_mainDevAlpha','AkashBhoraTara@','searchli_Notice');





if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $usertype="premium";

    $stmt = $conn -> prepare("UPDATE user_details SET user_type = ? WHERE email = ? AND phone_number = ?");
    $stmt-> bind_param('sss', $usertype, $email, $phoneNumber);
    $stmt->execute();
    $message = "User type has been updated!!!";
}

if(isset($_POST['noticeSub'])){
    $notice = $_POST['notice'];

    $stmt2 = $conn2 -> prepare("UPDATE message SET msg = ? ");
    $stmt2-> bind_param('s', $notice);
    $stmt2->execute();
    $message2 = "Notice has been added!!!";
}

$stmt3 = $conn2 -> prepare("SELECT * FROM `inqMessage` ");
$stmt3 -> execute();
$query = $stmt3->get_result();
$result = $query;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATES</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="update">
        <h2>Admin Panel</h2>
    <ul>
        <li><a href="wat-update.php">wat update</a></li>
        <li><a href="ppdt-update.php">PPDT update</a></li>
        <li><a href="tat-update.php">tat update</a></li>
        <li><a href="cs-update.php">completing story update</a></li>
        <li><a href="fb-update.php">completing sentence update</a></li>
        <li><a href="essay-update.php">essay topic update</a></li>
        <li><a href="blog-update.php">blog Updates</a></li>
        <li><a href="iq-update.php">IQ updates</a></li>
        <li><a href="pArmy.php">Army Prelims Update</a></li>
        <li><a href="pNavy-update.php">Navy Prelims</a></li>
        <li><a href="AFprelims-update.php">Air Force Prelims</a></li>

    </ul>
    </div>
    <div class="update-users">
        <h2>Updating users to premium</h2>
        <form action="" method="post">
            <p>
                <?php
                    if (isset($message)){
                        echo $message;
                    }
                ?>
            </p>
            <input type="text" name="email" id="" placeholder="User Email">
            <input type="text" name="phoneNumber" id="" placeholder="Phone Number"><br>
            <input type="submit" value="Update User Type" name="submit">
        </form>
    </div>
    <div class="notice">
        <h2>Update Notice</h2>
            <p>
                <?php
                    if (isset($message2)){
                        echo $message2;
                    }
                ?>
            </p>
        <form action="" method="post">
            <textarea name="notice" id=""></textarea><br>
            <input type="submit" value="Add notice" name="noticeSub">

        </form>
    </div>


    <h2>Pending requests</h2>
    <table class="messageTable" width="90%" style="margin:auto;margin-bottom:2%;">
            <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Message</th>
            </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><span><?php echo htmlspecialchars($row['name']); ?></span></td>
                <td><span><?php echo htmlspecialchars($row['phoneNumber']); ?></span></td>
                <td><span><?php echo htmlspecialchars($row['message']); ?></span></td>
                <td><span>
                    <form action="" method="post">
                        <?php
                            $removeMsg = "submit".$row['id'];
                            $id = $row['id'];
                            if(isset($_POST[$removeMsg])){
                                $stmt4 = $conn2 -> prepare("DELETE FROM `inqMessage` WHERE id = ?");
                                $stmt4-> bind_param('s', $id);
                                $stmt4 -> execute();

                            }
                        ?>
                        <input type="submit" value="❌" name="submit<?php echo htmlspecialchars($row['id']); ?>">
                    </form>
                </span></td>
            </tr>
        <?php endwhile;?>
    </table>
</body>
</html>