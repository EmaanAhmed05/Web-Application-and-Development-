<?php include '../config/db.php';
if(!isset($_SESSION['user_id'])){ header('Location: ../auth/login.php'); exit; }

$title = trim($_POST['title'] ?? '');
$desc  = trim($_POST['description'] ?? '');
$date  = $_POST['due_date'] ?? null;

if($title){
    $stmt = $conn->prepare("INSERT INTO tasks(user_id,title,description,due_date) VALUES(?,?,?,?)");
    $stmt->bind_param("isss", $_SESSION['user_id'], $title, $desc, $date);
    $stmt->execute();
    header('Location: ../pages/dashboard.php?msg=created');
} else {
    header('Location: ../pages/dashboard.php?msg=error');
}
exit;
?>