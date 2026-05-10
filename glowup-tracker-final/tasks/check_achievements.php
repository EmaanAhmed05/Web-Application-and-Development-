<?php
function checkAndUnlockAchievements($user_id, $conn) {
    // Get user stats
    $total_tasks = $conn->query("SELECT COUNT(*) c FROM tasks WHERE user_id=$user_id")->fetch_assoc()['c'];
    $completed_tasks = $conn->query("SELECT COUNT(*) c FROM tasks WHERE user_id=$user_id AND status='complete'")->fetch_assoc()['c'];
    $total_completed = $completed_tasks;
    
    // Check existing achievements
    $existing = [];
    $existing_result = $conn->query("SELECT achievement_name FROM achievements WHERE user_id=$user_id");
    while($row = $existing_result->fetch_assoc()) {
        $existing[] = $row['achievement_name'];
    }
    
    $new_achievements = [];
    
    // Achievement 1: Getting Started (5 tasks completed)
    if($total_completed >= 5 && !in_array('Getting Started', $existing)) {
        $stmt = $conn->prepare("INSERT INTO achievements (user_id, achievement_name, achievement_description) VALUES (?, 'Getting Started', 'Completed 5 tasks')");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $new_achievements[] = 'Getting Started - Completed 5 tasks!';
    }
    
    // Achievement 2: Task Master (10 tasks completed)
    if($total_completed >= 10 && !in_array('Task Master', $existing)) {
        $stmt = $conn->prepare("INSERT INTO achievements (user_id, achievement_name, achievement_description) VALUES (?, 'Task Master', 'Completed 10 tasks')");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $new_achievements[] = 'Task Master - Completed 10 tasks!';
    }
    
    // Achievement 3: Dedicated User (25 tasks completed)
    if($total_completed >= 25 && !in_array('Dedicated User', $existing)) {
        $stmt = $conn->prepare("INSERT INTO achievements (user_id, achievement_name, achievement_description) VALUES (?, 'Dedicated User', 'Completed 25 tasks')");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $new_achievements[] = 'Dedicated User - Completed 25 tasks!';
    }
    
    // Achievement 4: Task Master Pro (50 tasks completed)
    if($total_completed >= 50 && !in_array('Task Master Pro', $existing)) {
        $stmt = $conn->prepare("INSERT INTO achievements (user_id, achievement_name, achievement_description) VALUES (?, 'Task Master Pro', 'Completed 50 tasks')");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $new_achievements[] = 'Task Master Pro - Completed 50 tasks!';
    }
    
    // Achievement 5: High Priority Hero (3 high priority tasks)
    $high_priority = $conn->query("SELECT COUNT(*) c FROM tasks WHERE user_id=$user_id AND priority='high' AND status='complete'")->fetch_assoc()['c'];
    if($high_priority >= 3 && !in_array('High Priority Hero', $existing)) {
        $stmt = $conn->prepare("INSERT INTO achievements (user_id, achievement_name, achievement_description) VALUES (?, 'High Priority Hero', 'Completed 3 high priority tasks')");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $new_achievements[] = 'High Priority Hero - Completed 3 high priority tasks!';
    }
    
    // Achievement 6: Perfect Week (7 tasks in 7 days)
    $week_ago = date('Y-m-d H:i:s', strtotime('-7 days'));
    $week_tasks = $conn->query("SELECT COUNT(*) c FROM tasks WHERE user_id=$user_id AND status='complete' AND created_at > '$week_ago'")->fetch_assoc()['c'];
    if($week_tasks >= 7 && !in_array('Perfect Week', $existing)) {
        $stmt = $conn->prepare("INSERT INTO achievements (user_id, achievement_name, achievement_description) VALUES (?, 'Perfect Week', 'Completed 7 tasks in 7 days')");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $new_achievements[] = 'Perfect Week - Completed 7 tasks in 7 days!';
    }
    
    // Achievement 7: Category Master (tasks in all 5 categories)
    $categories = $conn->query("SELECT DISTINCT category FROM tasks WHERE user_id=$user_id AND status='complete'");
    $cat_count = $categories->num_rows;
    if($cat_count >= 5 && !in_array('Category Master', $existing)) {
        $stmt = $conn->prepare("INSERT INTO achievements (user_id, achievement_name, achievement_description) VALUES (?, 'Category Master', 'Completed tasks in all 5 categories')");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $new_achievements[] = 'Category Master - Completed tasks in all categories!';
    }
    
    return $new_achievements;
}
?>
