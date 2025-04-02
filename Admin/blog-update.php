<?php

include 'verify.php';

$conn = mysqli_connect("localhost", "root", "", "BLOGS");

if(isset($_POST['post'])){
    $mydate=getdate(date("U"));
    $blogData = array(
        "authorName"    => $_POST['authorName'],
        "topic"         => $_POST['topic'],
        "title"         => $_POST['title'],
        "text"          => $_POST['text'],
    );

    mysqli_query($conn, "
    INSERT INTO `blogData` (`author`, `topic`, `title`, `text`) 
    VALUES ('{$blogData["authorName"]}', '{$blogData["topic"]}', '{$blogData["title"]}', '{$blogData["text"]}')
");

    $message = "Blog has been posted";
}

if(isset($_POST['deletePost'])){
    $deleteID = $_POST['deleteID'];
    $deltePost = mysqli_query($conn, "DELETE FROM `blogData` WHERE `blogData`.`id` = '$deleteID';
");
}

$blogPost = mysqli_query($conn, "SELECT * FROM `blogData`");
$bpData =  mysqli_fetch_all($blogPost, MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog updates</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <H2>blog posts</H2>
    <form action="" method="post">
        <input type="text" name="authorName" placeholder="Author Name" id="" required>
        <input type="text" name="topic" placeholder="Topic of the blog" id="" required>
        <input type="text" name="title" placeholder="Title" id="" required> <br>
        <textarea name="text" id=""></textarea> <br>

        <input type="submit" value="Post" name="post">
    </form>
    
    <div class="all-blog-posts">
        <ul>
            <?php 
            foreach( $bpData as $postInfo ){
                ?>
            <li>
                <span class="id"><?php echo htmlspecialchars($postInfo['id']); ?></span><br>
                <span class="author"><?php echo htmlspecialchars($postInfo['author']); ?></span><br>
                <span class="date"><?php echo htmlspecialchars($postInfo['date']) ?></span><br>
                <span class="topic"><?php echo htmlspecialchars($postInfo['topic']) ?></span><br>
                <span class="text"><?php echo htmlspecialchars($postInfo['text']) ?></span>
            </li>
           <?php  } ?>
        </ul>
    </div>
    <div class="delete-area">
        <h3>Input the ID of the post you want to delete</h3>
        <form action="" method="post">
            <input type="number" name="deleteID" class="deleteBox" id="">
            <input type="submit" value="Delete Post" name="deletePost">
        </form>
    </div>
</body>
</html>