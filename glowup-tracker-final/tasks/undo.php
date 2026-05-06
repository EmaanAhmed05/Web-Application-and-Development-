<?php
session_start();
include '../config/db.php';

if(isset($_SESSION['undo_task'])){
    $task = $_SESSION['undo_task'];
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $task['user_id'], $task['title'], $task['description'], $task['due_date'], $task['status']);
    $stmt->execute();
    $stmt->close();
    unset($_SESSION['undo_task']);
    header("Location: ../pages/dashboard.php?msg=restored");
} else {
    header("Location: ../pages/dashboard.php?msg=nothing");
}
exit;
?>
