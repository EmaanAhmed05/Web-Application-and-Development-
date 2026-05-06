<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$due_date = $_POST['due_date'] ?: null;
$category = $_POST['category'] ?? 'other';
$priority = $_POST['priority'] ?? 'medium';

$error = '';

if(strlen($title) < 3){
    $error = "Title must be at least 3 characters";
} elseif(strlen($title) > 100){
    $error = "Title cannot exceed 100 characters";
} else {
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, status, category, priority) VALUES (?, ?, ?, ?, 'incomplete', ?, ?)");
    $stmt->bind_param("isssss", $user_id, $title, $description, $due_date, $category, $priority);
    
    if($stmt->execute()){
        header("Location: ../pages/dashboard.php?msg=added");
    } else {
        header("Location: ../pages/dashboard.php?msg=error");
    }
    $stmt->close();
    exit;
}

header("Location: ../pages/dashboard.php?msg=" . urlencode($error));
exit;
?>
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$due_date = $_POST['due_date'] ?: null;
$category = $_POST['category'] ?? 'other';
$priority = $_POST['priority'] ?? 'medium';

$error = '';

if(strlen($title) < 3){
    $error = "Title must be at least 3 characters";
} elseif(strlen($title) > 100){
    $error = "Title cannot exceed 100 characters";
} else {
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, status, category, priority) VALUES (?, ?, ?, ?, 'incomplete', ?, ?)");
    $stmt->bind_param("isssss", $user_id, $title, $description, $due_date, $category, $priority);
    
    if($stmt->execute()){
        header("Location: ../pages/dashboard.php?msg=added");
    } else {
        header("Location: ../pages/dashboard.php?msg=error");
    }
    $stmt->close();
    exit;
}

header("Location: ../pages/dashboard.php?msg=" . urlencode($error));
exit;
?>
