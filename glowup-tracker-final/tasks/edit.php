<?php include '../config/db.php';
if(!isset($_SESSION['user_id'])){ header('Location: ../auth/login.php'); exit; }

$id = intval($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$desc  = trim($_POST['description'] ?? '');
$date  = $_POST['due_date'] ?? null;

$stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, due_date=? WHERE id=? AND user_id=?");
$stmt->bind_param("sssii", $title, $desc, $date, $id, $_SESSION['user_id']);
$stmt->execute();

header('Location: ../pages/dashboard.php?msg=updated');
exit;
?>