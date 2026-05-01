<?php include '../config/db.php';
if(!isset($_SESSION['user_id'])){ header('Location: ../auth/login.php'); exit; }

$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("DELETE FROM tasks WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();

header('Location: ../pages/dashboard.php?msg=deleted');
exit;
?>