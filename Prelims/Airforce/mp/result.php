<?php
session_start();
require 'config.php';

$wrongId = $_SESSION['wrongInpMTH'] ?? [];
$wrongId2 = $_SESSION['wrongInpPHY'] ?? [];
$noAnswer = $_SESSION['notAnsweredMTH'] ?? [];
$noAnswer2 = $_SESSION['notAnsweredPHY'] ?? [];

$setNumber = $_SESSION['setN'] ?? null;
$tableName = $setNumber ? "set_" . $setNumber : '';

$verify = $verify11 = $verify2 = $verify22 = [];

// Wrong Math
if (!empty($wrongId)) {
    $placeholders1 = implode(',', array_fill(0, count($wrongId), '?'));
    $stmt1 = $conn->prepare("SELECT * FROM $tableName WHERE id IN ($placeholders1)");
    $types1 = str_repeat('i', count($wrongId));
    $stmt1->bind_param($types1, ...$wrongId);
    $stmt1->execute();
    $query = $stmt1->get_result();
    $verify = $query->fetch_all(MYSQLI_ASSOC);
    $stmt1->close();
}

// Wrong Physics
if (!empty($wrongId2)) {
    $placeholders11 = implode(',', array_fill(0, count($wrongId2), '?'));
    $stmt11 = $conn2->prepare("SELECT * FROM $tableName WHERE id IN ($placeholders11)");
    $types11 = str_repeat('i', count($wrongId2));
    $stmt11->bind_param($types11, ...$wrongId2);
    $stmt11->execute();
    $query11 = $stmt11->get_result();
    $verify11 = $query11->fetch_all(MYSQLI_ASSOC);
    $stmt11->close();
}

// Unanswered Math
if (!empty($noAnswer)) {
    $placeholders2 = implode(',', array_fill(0, count($noAnswer), '?'));
    $stmt2 = $conn->prepare("SELECT * FROM $tableName WHERE id IN ($placeholders2)");
    $types2 = str_repeat('i', count($noAnswer));
    $stmt2->bind_param($types2, ...$noAnswer);
    $stmt2->execute();
    $query2 = $stmt2->get_result();
    $verify2 = $query2->fetch_all(MYSQLI_ASSOC);
    $stmt2->close();
}

// Unanswered Physics
if (!empty($noAnswer2)) {
    $placeholders22 = implode(',', array_fill(0, count($noAnswer2), '?'));
    $stmt22 = $conn2->prepare("SELECT * FROM $tableName WHERE id IN ($placeholders22)");
    $types22 = str_repeat('i', count($noAnswer2));
    $stmt22->bind_param($types22, ...$noAnswer2);
    $stmt22->execute();
    $query22 = $stmt22->get_result();
    $verify22 = $query22->fetch_all(MYSQLI_ASSOC);
    $stmt22->close();
}

$conn->close();
$conn2->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bafa Preliminary Math & Physics Model Test</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="header-part">
        <div class="logo-area">
        <a href="../../../index.php"><img src="../../../images/logo.png" alt="Logo" srcset=""></a>
            <div class="text-area">
                <p style="color:#fff">Lighting Your Way To Success</p>
            </div>
        </div>
        <div class="menu-area">
            <ul>
            </ul>
        </div>
    </div>
    <h1>Results</h1>

    <?php if (!empty($verify)): ?>
        <h2>Math - Wrong Answers</h2>
        <?php foreach ($verify as $q): ?>
            <p><strong><?php echo $q['id']; ?>.</strong> <?php echo htmlspecialchars($q['question']); ?></p>
            <p>Correct Answer: <?php echo htmlspecialchars($q['answer']); ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($verify11)): ?>
        <h2>Physics - Wrong Answers</h2>
        <?php foreach ($verify11 as $q): ?>
            <p><strong><?php echo $q['id']; ?>.</strong> <?php echo htmlspecialchars($q['question']); ?></p>
            <p>Correct Answer: <?php echo htmlspecialchars($q['answer']); ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($verify2)): ?>
        <h2>Math - Not Answered</h2>
        <?php foreach ($verify2 as $q): ?>
            <p><strong><?php echo $q['id']; ?>.</strong> <?php echo htmlspecialchars($q['question']); ?></p>
            <p>Correct Answer: <?php echo htmlspecialchars($q['answer']); ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($verify22)): ?>
        <h2>Physics - Not Answered</h2>
        <?php foreach ($verify22 as $q): ?>
            <p><strong><?php echo $q['id']; ?>.</strong> <?php echo htmlspecialchars($q['question']); ?></p>
            <p>Correct Answer: <?php echo htmlspecialchars($q['answer']); ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
