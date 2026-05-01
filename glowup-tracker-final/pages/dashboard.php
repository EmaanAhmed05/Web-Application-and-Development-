<?php include '../config/db.php';
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

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard - GlowUp</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
<aside class="sidebar">
    <h2>GlowUp</h2>
    <a class="active" href="#">Dashboard</a>
    <a href="about.php">About</a>
    <a href="#" onclick="toggleDark()">🌙 Dark Mode</a>
    <a href="../auth/logout.php" class="logout">Logout</a>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Welcome back, <?= e($username) ?> 👋</h1>
            <p class="subtitle">Here's your glow up progress</p>
        </div>
    </div>

    <?php if($msg): ?>
        <div class="alert"><?= e($msg) ?></div>
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
            <input name="q" value="<?= e($search) ?>" placeholder="Search tasks...">
            <select name="status">
                <option value="all" <?= $status==='all'?'selected':'' ?>>All</option>
                <option value="complete" <?= $status==='complete'?'selected':'' ?>>Completed</option>
                <option value="incomplete" <?= $status==='incomplete'?'selected':'' ?>>Incomplete</option>
            </select>
            <button>Filter</button>
        </form>
    </div>

    <form action="../tasks/add.php" method="POST" class="task-form" onsubmit="return validateTask(this)">
        <input name="title" placeholder="Task title" required>
        <input name="description" placeholder="Description">
        <input name="due_date" type="date">
        <button>Add Task</button>
    </form>

    <ul class="tasks" id="tasks">
    <?php while($t=$result->fetch_assoc()): ?>
        <li class="task <?= $t['STATUS'] ?>">
            <div class="task-left">
                <strong><?= e($t['title']) ?></strong>
                <small><?= e($t['due_date'] ?? '') ?></small>
            </div>
            <div class="task-actions">
                <a title="Toggle" href="../tasks/toggle.php?id=<?= $t['id'] ?>">✔</a>
                <button onclick="openEdit(<?= $t['id'] ?>,'<?= e($t['title']) ?>','<?= e($t['description']) ?>','<?= e($t['due_date']) ?>')">✏️</button>
                <a title="Delete" href="../tasks/delete.php?id=<?= $t['id'] ?>" onclick="return confirmDelete()">🗑️</a>
            </div>
        </li>
    <?php endwhile; ?>
    </ul>

</main>
</div>

<!-- Edit Modal -->
<div id="modal" class="modal">
  <div class="modal-content">
    <h3>Edit Task</h3>
    <form method="POST" action="../tasks/edit.php" onsubmit="return validateTask(this)">
        <input type="hidden" name="id" id="edit-id">
        <input name="title" id="edit-title" required>
        <input name="description" id="edit-desc">
        <input type="date" name="due_date" id="edit-date">
        <button>Update</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
  </div>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
