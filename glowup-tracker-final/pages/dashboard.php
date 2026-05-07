<?php 
include '../config/db.php';
if(!isset($_SESSION['user_id'])) header("Location: ../auth/login.php");

$id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'User';

// filters
$status = $_GET['status'] ?? 'all';
$search = $_GET['q'] ?? '';

$sql = "SELECT * FROM tasks WHERE user_id=?";
$params = [$id];
$types = "i";

if($status === 'complete' || $status === 'incomplete'){
    $sql .= " AND status=?";
    $params[] = $status;
    $types .= "s";
}
if($search){
    $sql .= " AND (title LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%'))";
    $params[] = $search;
    $params[] = $search;
    $types .= "ss";
}
$sql .= " ORDER BY due_date IS NULL, due_date ASC, created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// stats
$total = $conn->query("SELECT COUNT(*) c FROM tasks WHERE user_id=$id")->fetch_assoc()['c'];
$completed = $conn->query("SELECT COUNT(*) c FROM tasks WHERE user_id=$id AND status='complete'")->fetch_assoc()['c'];
$incomplete = $total - $completed;
$percent = $total ? round(($completed/$total)*100) : 0;

// Check for overdue tasks
$today = date('Y-m-d');
$overdue_query = $conn->query("SELECT COUNT(*) c FROM tasks WHERE user_id=$id AND due_date < '$today' AND status='incomplete'");
$overdue = $overdue_query ? $overdue_query->fetch_assoc()['c'] : 0;

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard - GlowUp</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
    .task {
        border-left: 5px solid #ccc;
    }
    .task-high {
        border-left-color: #f44336 !important;
    }
    .task-medium {
        border-left-color: #ff9800 !important;
    }
    .task-low {
        border-left-color: #4caf50 !important;
    }
    .badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        margin-right: 5px;
    }
    .badge-category {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .badge-high {
        background: #ffebee;
        color: #f44336;
    }
    .badge-medium {
        background: #fff3e0;
        color: #ff9800;
    }
    .badge-low {
        background: #e8f5e9;
        color: #4caf50;
    }
    select, input {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .task-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    .task-form input, .task-form select {
        flex: 1;
        min-width: 120px;
    }
    .task-form button {
        background: #2e7d32;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        cursor: pointer;
    }
    
    /* Dark Mode CSS */
    body.dark-mode {
        background: #1a1a2e !important;
        color: #eeeeee !important;
    }
    body.dark-mode .sidebar {
        background: #16213e !important;
    }
    body.dark-mode .sidebar h2 {
        color: #4caf50 !important;
    }
    body.dark-mode .sidebar a {
        color: #cccccc !important;
    }
    body.dark-mode .sidebar a:hover {
        background: #2a2a4a !important;
    }
    body.dark-mode .main {
        background: #1a1a2e !important;
    }
    body.dark-mode .card {
        background: #16213e !important;
    }
    body.dark-mode .card h3 {
        color: #4caf50 !important;
    }
    body.dark-mode .card p {
        color: white !important;
    }
    body.dark-mode .tasks li {
        background: #16213e !important;
    }
    body.dark-mode .task-left strong {
        color: white !important;
    }
    body.dark-mode .filters input,
    body.dark-mode .filters select,
    body.dark-mode .task-form input,
    body.dark-mode .task-form select {
        background: #16213e !important;
        color: white !important;
        border-color: #2a2a4a !important;
    }
    body.dark-mode button {
        background: #1b5e20 !important;
    }
    body.dark-mode .modal-content {
        background: #16213e !important;
        color: white !important;
    }
    body.dark-mode .alert {
        background: #16213e !important;
        color: white !important;
    }
    body.dark-mode .topbar h1 {
        color: white !important;
    }
    body.dark-mode .logout {
        color: #ff6b6b !important;
    }
</style>
</head>
<body>
<div class="container">
<aside class="sidebar">
    <h2>GlowUp</h2>
    <a class="active" href="#">Dashboard</a>
    <a href="about.php">About</a>
    <a href="#" class="dark-mode-btn">Dark Mode</a>
    <a href="../auth/logout.php" class="logout">Logout</a>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Welcome back, <?= htmlspecialchars($username) ?></h1>
            <p class="subtitle">Here's your glow up progress</p>
        </div>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert" style="background:#e8f5e9; padding:10px; border-radius:8px; margin-bottom:15px; text-align:center;">
            <?php 
            $msg_type = $_GET['msg'];
            if($msg_type == 'deleted'): ?>
                🗑️ Task deleted! <a href="../tasks/undo.php" style="color:#2e7d32; font-weight:bold;">Click here to Undo</a>
            <?php elseif($msg_type == 'restored'): ?>
                ✅ Task restored successfully!
            <?php elseif($msg_type == 'added'): ?>
                ✅ Task added successfully!
            <?php elseif($msg_type == 'updated'): ?>
                ✅ Task updated successfully!
            <?php elseif($msg_type == 'error'): ?>
                ❌ Something went wrong!
            <?php else: ?>
                <?= htmlspecialchars($msg_type) ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if($overdue > 0): ?>
        <div class="alert" style="background:#fff3e0; border-left:4px solid #ff9800; padding:10px; border-radius:8px; margin-bottom:15px;">
            ⚠️ You have <?= $overdue ?> overdue task<?= $overdue > 1 ? 's' : '' ?>! Please complete them soon.
        </div>
    <?php endif; ?>

    <div class="cards">
        <div class="card">
            <h3>Completed</h3>
            <p><?= $completed ?> tasks</p>
            <div class="progress"><div style="width:<?= $percent ?>%"></div></div>
            <span><?= $percent ?>%</span>
        </div>
        <div class="card">
            <h3>Pending</h3>
            <p><?= $incomplete ?> tasks</p>
            <div class="progress"><div style="width:<?= 100-$percent ?>%"></div></div>
            <span><?= 100-$percent ?>%</span>
        </div>
        <div class="card">
            <h3>Total</h3>
            <p><?= $total ?> tasks</p>
            <div class="progress"><div style="width:100%"></div></div>
            <span>100%</span>
        </div>
    </div>

    <div class="task-controls">
        <form method="GET" class="filters">
            <input name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search tasks...">
            <select name="status">
                <option value="all" <?= $status==='all'?'selected':'' ?>>All</option>
                <option value="complete" <?= $status==='complete'?'selected':'' ?>>Completed</option>
                <option value="incomplete" <?= $status==='incomplete'?'selected':'' ?>>Incomplete</option>
            </select>
            <button>Filter</button>
        </form>
    </div>

    <form action="../tasks/add.php" method="POST" class="task-form" onsubmit="return validateTask(this)">
        <input type="text" name="title" placeholder="Task title" required>
        <input type="text" name="description" placeholder="Description">
        <input type="date" name="due_date">
        <select name="category" required>
            <option value="personal">👤 Personal</option>
            <option value="work">💼 Work</option>
            <option value="health">💪 Health</option>
            <option value="education">📚 Education</option>
            <option value="other">📌 Other</option>
        </select>
        <select name="priority" required>
            <option value="low">🟢 Low Priority</option>
            <option value="medium">🟡 Medium Priority</option>
            <option value="high">🔴 High Priority</option>
        </select>
        <button type="submit">Add Task</button>
    </form>

    <ul class="tasks" id="tasks">
        <?php if($result && $result->num_rows > 0): ?>
            <?php while($t = $result->fetch_assoc()): ?>
                <?php 
                $priority_class = '';
                if($t['priority'] == 'high') $priority_class = 'task-high';
                elseif($t['priority'] == 'medium') $priority_class = 'task-medium';
                else $priority_class = 'task-low';
                ?>
                <li class="task <?= $priority_class ?>">
                    <div class="task-left">
                        <strong><?= htmlspecialchars($t['title']) ?></strong>
                        <div style="display: flex; gap: 8px; margin-top: 5px; flex-wrap: wrap;">
                            <?php 
                            $category = $t['category'] ?? 'other';
                            $category_name = '';
                            if($category == 'personal') $category_name = '👤 Personal';
                            elseif($category == 'work') $category_name = '💼 Work';
                            elseif($category == 'health') $category_name = '💪 Health';
                            elseif($category == 'education') $category_name = '📚 Education';
                            else $category_name = '📌 Other';
                            ?>
                            <span class="badge badge-category"><?= $category_name ?></span>
                            <?php 
                            $priority = $t['priority'] ?? 'medium';
                            $priority_name = '';
                            $priority_badge = '';
                            if($priority == 'high') {
                                $priority_name = '🔴 High';
                                $priority_badge = 'badge-high';
                            } elseif($priority == 'medium') {
                                $priority_name = '🟡 Medium';
                                $priority_badge = 'badge-medium';
                            } else {
                                $priority_name = '🟢 Low';
                                $priority_badge = 'badge-low';
                            }
                            ?>
                            <span class="badge <?= $priority_badge ?>"><?= $priority_name ?></span>
                            <span class="badge" style="background:#f0f0f0;">📅 <?= $t['due_date'] ? htmlspecialchars($t['due_date']) : 'No due date' ?></span>
                        </div>
                    </div>
                    <div class="task-actions">
                        <a title="Mark Complete" href="../tasks/toggle.php?id=<?= $t['id'] ?>">✔️</a>
                        <button onclick='openEdit(<?= $t['id'] ?>, <?= json_encode($t['title']) ?>, <?= json_encode($t['description']) ?>, <?= json_encode($t['due_date']) ?>, <?= json_encode($t['category']) ?>, <?= json_encode($t['priority']) ?>)'>✏️</button>
                        <a title="Delete" href="../tasks/delete.php?id=<?= $t['id'] ?>" onclick="return confirmDelete()">🗑️</a>
                    </div>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li style="text-align:center; padding:20px; color:#888;">No tasks yet. Add your first task above! ✨</li>
        <?php endif; ?>
    </ul>

</main>
</div>

<div id="modal" class="modal">
  <div class="modal-content">
    <h3>Edit Task</h3>
    <form method="POST" action="../tasks/edit.php" onsubmit="return validateTask(this)">
        <input type="hidden" name="id" id="edit-id">
        <input type="text" name="title" id="edit-title" required placeholder="Task title" style="width:100%; margin-bottom:10px; padding:8px;">
        <input type="text" name="description" id="edit-desc" placeholder="Description" style="width:100%; margin-bottom:10px; padding:8px;">
        <input type="date" name="due_date" id="edit-date" style="width:100%; margin-bottom:10px; padding:8px;">
        <select name="category" id="edit-category" style="width:100%; margin-bottom:10px; padding:8px;">
            <option value="personal">👤 Personal</option>
            <option value="work">💼 Work</option>
            <option value="health">💪 Health</option>
            <option value="education">📚 Education</option>
            <option value="other">📌 Other</option>
        </select>
        <select name="priority" id="edit-priority" style="width:100%; margin-bottom:10px; padding:8px;">
            <option value="low">🟢 Low Priority</option>
            <option value="medium">🟡 Medium Priority</option>
            <option value="high">🔴 High Priority</option>
        </select>
        <button type="submit">Update</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
  </div>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
