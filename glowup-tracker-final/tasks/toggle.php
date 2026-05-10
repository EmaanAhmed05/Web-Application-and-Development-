<?php
session_start();
include '../config/db.php';
include 'check_achievements.php';

if(!isset($_SESSION['user_id'])){
    header('Location: ../auth/login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$user_id = $_SESSION['user_id'];

// Get current status
$result = $conn->query("SELECT status FROM tasks WHERE id=$id AND user_id=$user_id");
if($result->num_rows > 0) {
    $current = $result->fetch_assoc();
    $new_status = ($current['status'] == 'complete') ? 'incomplete' : 'complete';
    $conn->query("UPDATE tasks SET status='$new_status' WHERE id=$id AND user_id=$user_id");
    
    // Check achievements if task was completed
    if($new_status == 'complete') {
        $new_achievements = checkAndUnlockAchievements($user_id, $conn);
        if(!empty($new_achievements)) {
            $_SESSION['new_achievements'] = $new_achievements;
        }
    }
}

header('Location: ../pages/dashboard.php?msg=toggled');
exit;
?>
