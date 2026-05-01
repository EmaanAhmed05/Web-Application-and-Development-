<?php include '../config/db.php';
if(!isset($_SESSION['user_id'])){ header('Location: ../auth/login.php'); exit; }

$id = intval($_GET['id'] ?? 0);
$conn->query("UPDATE tasks SET status = IF(status='complete','incomplete','complete') WHERE id=$id AND user_id=".$_SESSION['user_id']);

header('Location: ../pages/dashboard.php?msg=toggled');
exit;
?>