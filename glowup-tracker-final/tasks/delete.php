<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

// Store deleted task for undo
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$deleted_task = $stmt->get_result()->fetch_assoc();
$stmt->close();

if($deleted_task){
    $_SESSION['undo_task'] = $deleted_task;
}

$stmt = $conn->prepare("DELETE FROM tasks WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$stmt->close();

// Redirect with success message
header("Location: ../pages/dashboard.php?msg=deleted");
exit;
?>
