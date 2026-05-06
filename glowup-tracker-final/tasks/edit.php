<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_POST['id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$due_date = $_POST['due_date'] ?: null;
$category = $_POST['category'] ?? 'other';
$priority = $_POST['priority'] ?? 'medium';

if(strlen($title) < 3){
    header("Location: ../pages/dashboard.php?msg=Title too short");
} elseif(strlen($title) > 100){
    header("Location: ../pages/dashboard.php?msg=Title too long");
} else {
    $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, due_date=?, category=?, priority=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sssssii", $title, $description, $due_date, $category, $priority, $id, $_SESSION['user_id']);
    
    if($stmt->execute()){
        header("Location: ../pages/dashboard.php?msg=updated");
    } else {
        header("Location: ../pages/dashboard.php?msg=error");
    }
    $stmt->close();
    exit;
}
exit;
?>
