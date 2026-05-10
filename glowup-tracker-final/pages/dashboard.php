<?php 
session_start();
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
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #7CBF8E;
        --primary-dark: #5E9F71;
        --primary-light: #DCEEDF;
        --bg: #F4FAF4;
        --card: #FCFEFC;
        --sidebar: rgba(234, 245, 234, 0.95);
        --text: #23412E;
        --muted: #6F8B77;
        --border: #D8E8DA;
        --shadow: 0 10px 30px rgba(124, 191, 142, 0.12);
        --alert-bg: #e8f5e9;
        --alert-text: #2e7d32;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, var(--bg), #EEF7EF);
        color: var(--text);
        transition: background 0.3s, color 0.2s;
    }

    /* DARK MODE */
    body.dark-mode {
        --bg: #1a2a1a;
        --card: #243624;
        --sidebar: #1e2e1e;
        --text: #e0f2e0;
        --muted: #adc7a5;
        --border: #3c5a3a;
        --shadow: 0 8px 24px rgba(0,0,0,0.2);
        --alert-bg: #2a3a2a;
        --alert-text: #c8e6c9;
        background: linear-gradient(135deg, #1a2a1a, #162116);
    }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
        width: 280px;
        background: var(--sidebar);
        backdrop-filter: blur(10px);
        position: fixed;
        height: 100vh;
        padding-top: 10px;
        border-right: 1px solid var(--border);
        box-shadow: 4px 0 20px rgba(0,0,0,0.03);
        z-index: 100;
        transition: all 0.3s;
    }

    .sidebar .logo {
        padding: 25px 25px 20px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 20px;
    }

    .sidebar .logo h2 {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        letter-spacing: -1px;
    }

    .sidebar .logo p {
        font-size: 0.75rem;
        color: var(--muted);
        margin-top: 5px;
    }

    .sidebar nav a {
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        color: var(--text);
        margin: 10px 15px;
        padding: 14px 18px;
        border-radius: 16px;
        transition: 0.3s ease;
        font-weight: 600;
    }

    .sidebar nav a i {
        width: 20px;
        font-size: 1rem;
    }

    .sidebar nav a:hover,
    .sidebar nav a.active {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        transform: translateX(5px);
        box-shadow: 0 8px 18px rgba(124,191,142,0.25);
    }

    .sidebar .logout {
        margin-top: 20px;
        border-top: 1px solid var(--border);
        padding-top: 15px;
    }

    /* MAIN CONTENT */
    .main-content {
        flex: 1;
        margin-left: 280px;
        padding: 40px;
        animation: fadeUp 0.6s ease;
    }

    /* TOP BAR */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 35px;
    }

    .welcome h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2D6A3F;
    }
    body.dark-mode .welcome h1 {
        color: #c8e6c9;
    }

    .welcome p {
        color: var(--muted);
        font-weight: 500;
    }

    .dark-mode-btn {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 5px 12px rgba(124,191,142,0.25);
    }

    .dark-mode-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(124,191,142,0.35);
    }

    /* ALERTS */
    .alert-success, .alert-warning {
        padding: 16px 20px;
        border-radius: 24px;
        margin-bottom: 25px;
        backdrop-filter: blur(8px);
        font-weight: 500;
        border-left: 4px solid;
    }

    .alert-success {
        background: var(--alert-bg);
        color: var(--alert-text);
        border-left-color: var(--primary);
    }

    .alert-warning {
        background: #FFF3E0;
        color: #c27803;
        border-left-color: #ff9800;
    }
    body.dark-mode .alert-warning {
        background: #4a3a1a;
        color: #ffb74d;
    }

    /* STATS GRID */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: var(--card);
        backdrop-filter: blur(4px);
        border: 1px solid var(--border);
        border-radius: 28px;
        padding: 22px 20px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: 0.3s;
        box-shadow: var(--shadow);
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(124,191,142,0.15);
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }

    .stat-icon.completed { background: rgba(124,191,142,0.15); color: var(--primary-dark); }
    .stat-icon.pending { background: rgba(255,152,0,0.12); color: #ff9800; }
    .stat-icon.total { background: rgba(33,150,243,0.12); color: #2196f3; }
    .stat-icon.overdue { background: rgba(244,67,54,0.12); color: #f44336; }

    .stat-info h3 {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .stat-info .number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text);
    }

    /* PROGRESS SECTION */
    .progress-section {
        background: var(--card);
        backdrop-filter: blur(4px);
        border: 1px solid var(--border);
        border-radius: 28px;
        padding: 22px 25px;
        margin-bottom: 35px;
        box-shadow: var(--shadow);
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .progress-bar {
        height: 10px;
        background: var(--primary-light);
        border-radius: 20px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 20px;
        transition: width 0.8s ease;
    }

    /* ACHIEVEMENTS SECTION */
    .achievements-section {
        background: var(--card);
        backdrop-filter: blur(4px);
        border: 1px solid var(--border);
        border-radius: 28px;
        padding: 22px 25px;
        margin-bottom: 35px;
        box-shadow: var(--shadow);
    }

    .achievements-section h3 {
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--primary-dark);
        font-size: 1.3rem;
    }

    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
    }

    .achievement-badge {
        background: var(--primary-light);
        border-radius: 20px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: 0.2s;
        width: 100%;
    }
    body.dark-mode .achievement-badge {
        background: #3c5a3a;
    }

    .achievement-badge:hover {
        transform: translateY(-3px);
        background: var(--primary);
        color: white;
    }
    body.dark-mode .achievement-badge:hover {
        background: var(--primary);
        color: #1a2a1a;
    }

    .achievement-badge i {
        flex-shrink: 0;
    }

    .achievement-badge div {
        flex: 1;
    }
    body.dark-mode .achievement-badge div div {
        color: #e0f2e0;
    }

    /* FILTERS BAR */
    .filters-bar {
        background: var(--card);
        backdrop-filter: blur(4px);
        border: 1px solid var(--border);
        border-radius: 28px;
        padding: 18px 22px;
        margin-bottom: 30px;
        box-shadow: var(--shadow);
    }

    .filters-bar form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }

    .search-box {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 60px;
        padding: 10px 18px;
        transition: 0.2s;
    }

    .search-box:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(124,191,142,0.2);
    }

    .search-box i {
        color: var(--muted);
    }

    .search-box input {
        border: none;
        background: transparent;
        width: 100%;
        outline: none;
        font-family: 'Inter', sans-serif;
        color: var(--text);
    }

    .filter-select {
        background: var(--bg);
        border: 1px solid var(--border);
        padding: 10px 20px;
        border-radius: 60px;
        font-family: 'Inter', sans-serif;
        color: var(--text);
        cursor: pointer;
        transition: 0.2s;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary);
    }

    .filter-btn {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 10px 28px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(124,191,142,0.3);
    }

    /* ADD TASK CARD */
    .add-task-card {
        background: var(--card);
        backdrop-filter: blur(4px);
        border: 1px solid var(--border);
        border-radius: 28px;
        padding: 25px;
        margin-bottom: 35px;
        box-shadow: var(--shadow);
        transition: 0.2s;
    }

    .add-task-card h3 {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--primary-dark);
    }

    .task-form {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .task-form input,
    .task-form select {
        flex: 1;
        min-width: 140px;
        background: var(--bg);
        border: 1px solid var(--border);
        padding: 12px 18px;
        border-radius: 40px;
        font-family: 'Inter', sans-serif;
        transition: 0.2s;
        color: var(--text);
    }

    .task-form input:focus,
    .task-form select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(124,191,142,0.2);
    }

    .task-form button {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .task-form button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(124,191,142,0.3);
    }

    /* TASKS HEADER */
    .tasks-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 20px;
    }

    .tasks-header h3 {
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--primary-dark);
    }

    .task-count {
        color: var(--muted);
        font-size: 0.85rem;
        background: var(--primary-light);
        padding: 4px 12px;
        border-radius: 30px;
    }

    /* TASKS LIST */
    .tasks-list {
        list-style: none;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .task-item {
        background: var(--card);
        backdrop-filter: blur(4px);
        border: 1px solid var(--border);
        border-left-width: 5px;
        border-radius: 24px;
        padding: 18px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        transition: 0.25s;
        box-shadow: var(--shadow);
    }

    .task-item:hover {
        transform: translateX(6px);
        box-shadow: 0 12px 25px rgba(124,191,142,0.12);
    }

    .task-info { flex: 1; }

    .task-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 8px;
        color: var(--text);
    }

    .task-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .task-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-category {
        background: var(--primary-light);
        color: var(--primary-dark);
    }

    .badge-high {
        background: #ffebee;
        color: #f44336;
    }
    body.dark-mode .badge-high {
        background: #5a2a2a;
        color: #ff8a80;
    }

    .badge-medium {
        background: #fff3e0;
        color: #ff9800;
    }
    body.dark-mode .badge-medium {
        background: #5a3a1a;
        color: #ffb74d;
    }

    .badge-low {
        background: #e8f5e9;
        color: #2e7d32;
    }
    body.dark-mode .badge-low {
        background: #2a4a2a;
        color: #a5d6a7;
    }

    .badge-date {
        background: var(--primary-light);
        color: var(--muted);
    }

    .task-actions {
        display: flex;
        gap: 12px;
    }

    .task-actions a,
    .task-actions button {
        background: none;
        border: none;
        font-size: 1.15rem;
        cursor: pointer;
        padding: 8px;
        border-radius: 12px;
        transition: all 0.2s;
        color: var(--muted);
        text-decoration: none;
    }

    .task-actions a:hover,
    .task-actions button:hover {
        background: var(--primary-light);
        color: var(--primary-dark);
        transform: scale(1.1);
    }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--card);
        border-radius: 28px;
        border: 1px solid var(--border);
        margin-top: 20px;
    }

    .empty-state i {
        font-size: 3.5rem;
        color: var(--muted);
        margin-bottom: 15px;
        opacity: 0.6;
    }

    .empty-state p {
        color: var(--muted);
    }

    /* MODAL */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-content {
        background: var(--card);
        backdrop-filter: blur(12px);
        border-radius: 32px;
        padding: 28px;
        width: 90%;
        max-width: 500px;
        border: 1px solid var(--border);
        animation: fadeUp 0.25s ease;
    }

    .modal-content h3 {
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--primary-dark);
    }

    .modal-content input,
    .modal-content select {
        width: 100%;
        padding: 12px 16px;
        margin-bottom: 14px;
        border: 1px solid var(--border);
        border-radius: 40px;
        font-family: 'Inter', sans-serif;
        background: var(--bg);
        color: var(--text);
    }

    .modal-content input:focus,
    .modal-content select:focus {
        outline: none;
        border-color: var(--primary);
    }

    .modal-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .modal-buttons button {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .modal-buttons button:first-child {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
    }

    .modal-buttons button:first-child:hover {
        transform: translateY(-2px);
    }

    .modal-buttons button:last-child {
        background: var(--primary-light);
        color: var(--text);
    }

    .modal-buttons button:last-child:hover {
        background: #c8e0cb;
    }
    body.dark-mode .modal-buttons button:last-child {
        background: #3c5a3a;
        color: var(--text);
    }

    /* DARK MODE SEARCH FIX */
    body.dark-mode .search-box input,
    body.dark-mode .filter-select,
    body.dark-mode .task-form input,
    body.dark-mode .task-form select {
        color: #e0f2e0;
    }

    /* ANIMATIONS */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            position: fixed;
            z-index: 999;
        }
        .main-content {
            margin-left: 0;
            padding: 25px;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .filters-bar form {
            flex-direction: column;
            align-items: stretch;
        }
        .task-form {
            flex-direction: column;
        }
        .task-item {
            flex-direction: column;
            align-items: flex-start;
        }
        .task-actions {
            align-self: flex-end;
        }
    }
</style>
</head>
<body>

<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <h2>GlowUp</h2>
            <p>Track your journey</p>
        </div>
        <nav>
            <a href="dashboard.php" class="active">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="../home.php">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="about.php">
                <i class="fas fa-users"></i> About
            </a>
            <div class="logout">
                <a href="../auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="welcome">
                <h1>Welcome back, <?= htmlspecialchars($username) ?></h1>
                <p>Here's what's happening with your tasks today</p>
            </div>
            <button class="dark-mode-btn" id="darkModeBtn">
                <i class="fas fa-moon"></i> Dark Mode
            </button>
        </div>

        <!-- Messages -->
        <?php if(isset($_GET['msg'])): ?>
            <div class="alert-success">
                <?php 
                $msg_type = $_GET['msg'];
                if($msg_type == 'deleted'): ?>
                    Task deleted! <a href="../tasks/undo.php" style="color:var(--primary-dark); font-weight:bold;">Undo</a>
                <?php elseif($msg_type == 'restored'): ?>
                    Task restored successfully!
                <?php elseif($msg_type == 'added'): ?>
                    Task added successfully!
                <?php elseif($msg_type == 'updated'): ?>
                    Task updated successfully!
                <?php elseif($msg_type == 'error'): ?>
                    Something went wrong!
                <?php else: ?>
                    <?= htmlspecialchars($msg_type) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($overdue > 0): ?>
            <div class="alert-warning">
                ⚠️ You have <?= $overdue ?> overdue task<?= $overdue > 1 ? 's' : '' ?>! Please complete them soon.
            </div>
        <?php endif; ?>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon completed"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3>Completed</h3>
                    <div class="number"><?= $completed ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <h3>Pending</h3>
                    <div class="number"><?= $incomplete ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon total"><i class="fas fa-tasks"></i></div>
                <div class="stat-info">
                    <h3>Total Tasks</h3>
                    <div class="number"><?= $total ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon overdue"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="stat-info">
                    <h3>Overdue</h3>
                    <div class="number"><?= $overdue ?></div>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="progress-section">
            <div class="progress-header">
                <span>Overall Progress</span>
                <span><?= $percent ?>% Complete</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?= $percent ?>%"></div>
            </div>
        </div>

        <!-- ===== ACHIEVEMENTS SECTION ===== -->
        <?php
        // Get user achievements
        $achievements_result = $conn->query("SELECT * FROM achievements WHERE user_id=$id ORDER BY unlocked_at DESC");
        $achievements_count = $achievements_result->num_rows;

        // Show new achievements alert
        if(isset($_SESSION['new_achievements']) && !empty($_SESSION['new_achievements'])): ?>
            <div class="alert-success" style="background: #1a3a1a; border-left: 4px solid #ffd700; margin-bottom: 20px; padding: 15px; border-radius: 16px; color: #ffd700;">
                <strong New Achievement Unlocked! </strong><br>
                <?php foreach($_SESSION['new_achievements'] as $ach): ?>
                    <div> <?= htmlspecialchars($ach) ?></div>
                <?php endforeach; ?>
            </div>
        <?php 
            unset($_SESSION['new_achievements']);
        endif; 
        ?>

        <div class="achievements-section">
            <h3><i class="fas fa-trophy" style="color: #ffd700;"></i> Your Achievements</h3>
            <?php if($achievements_count > 0): ?>
                <div class="achievements-grid">
                    <?php 
                    $achievements_result = $conn->query("SELECT * FROM achievements WHERE user_id=$id ORDER BY unlocked_at DESC");
                    while($ach = $achievements_result->fetch_assoc()): 
                    ?>
                        <div class="achievement-badge">
                            <i class="fas fa-medal" style="color: #ffd700; font-size: 1.8rem;"></i>
                            <div>
                                <div style="font-weight: 600;"> <?= htmlspecialchars($ach['achievement_name']) ?></div>
                                <div style="font-size: 0.7rem; color: var(--muted);"><?= htmlspecialchars($ach['achievement_description']) ?></div>
                                <div style="font-size: 0.65rem; color: var(--primary-dark); margin-top: 3px;">
                                    <i class="far fa-clock"></i> Unlocked: <?= date('M d, Y', strtotime($ach['unlocked_at'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p style="color: var(--muted); text-align: center; padding: 20px;">
                    <i class="fas fa-trophy" style="font-size: 2rem; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                    Complete tasks to unlock achievements!
                </p>
            <?php endif; ?>
        </div>

        <!-- Filters Bar -->
        <div class="filters-bar">
            <form method="GET" style="display: flex; gap: 12px; flex: 1; flex-wrap: wrap;">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Search tasks..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <select name="status" class="filter-select">
                    <option value="all" <?= $status==='all'?'selected':'' ?>>All Tasks</option>
                    <option value="complete" <?= $status==='complete'?'selected':'' ?>>Completed</option>
                    <option value="incomplete" <?= $status==='incomplete'?'selected':'' ?>>Pending</option>
                </select>
                <button type="submit" class="filter-btn"><i class="fas fa-filter"></i> Apply</button>
            </form>
        </div>

        <!-- Add Task Card -->
        <div class="add-task-card">
            <h3><i class="fas fa-plus-circle"></i> Create New Task</h3>
            <form action="../tasks/add.php" method="POST" class="task-form" onsubmit="return validateTask(this)">
                <input type="text" name="title" placeholder="Task title" required>
                <input type="text" name="description" placeholder="Description (optional)">
                <input type="date" name="due_date">
                <select name="category">
                    <option value="personal">👤 Personal</option>
                    <option value="work">💼 Work</option>
                    <option value="health">💪 Health</option>
                    <option value="education">📚 Education</option>
                    <option value="other">📌 Other</option>
                </select>
                <select name="priority">
                    <option value="low">🟢 Low Priority</option>
                    <option value="medium">🟡 Medium Priority</option>
                    <option value="high">🔴 High Priority</option>
                </select>
                <button type="submit"><i class="fas fa-plus"></i> Add Task</button>
            </form>
        </div>

        <!-- Tasks Header -->
        <div class="tasks-header">
            <h3><i class="fas fa-list-check"></i> Your Tasks</h3>
            <span class="task-count"><?= $total ?> total</span>
        </div>

        <!-- Tasks List -->
        <ul class="tasks-list">
            <?php if($result && $result->num_rows > 0): ?>
                <?php while($t = $result->fetch_assoc()): ?>
                    <?php 
                    $border_color = '';
                    if($t['priority'] == 'high') $border_color = '#f44336';
                    elseif($t['priority'] == 'medium') $border_color = '#ff9800';
                    else $border_color = '#4caf50';
                    
                    $priority_text = '';
                    $priority_class = '';
                    if($t['priority'] == 'high') {
                        $priority_text = '🔴 High';
                        $priority_class = 'badge-high';
                    } elseif($t['priority'] == 'medium') {
                        $priority_text = '🟡 Medium';
                        $priority_class = 'badge-medium';
                    } else {
                        $priority_text = '🟢 Low';
                        $priority_class = 'badge-low';
                    }
                    
                    $category = $t['category'] ?? 'other';
                    $category_name = '';
                    if($category == 'personal') $category_name = '👤 Personal';
                    elseif($category == 'work') $category_name = '💼 Work';
                    elseif($category == 'health') $category_name = '💪 Health';
                    elseif($category == 'education') $category_name = '📚 Education';
                    else $category_name = '📌 Other';
                    ?>
                    <li class="task-item" style="border-left-color: <?= $border_color ?>;">
                        <div class="task-info">
                            <div class="task-title"><?= htmlspecialchars($t['title']) ?></div>
                            <div class="task-meta">
                                <span class="task-badge badge-category"><?= $category_name ?></span>
                                <span class="task-badge <?= $priority_class ?>"><?= $priority_text ?></span>
                                <span class="task-badge badge-date"><i class="far fa-calendar-alt"></i> <?= $t['due_date'] ? htmlspecialchars($t['due_date']) : 'No date' ?></span>
                            </div>
                        </div>
                        <div class="task-actions">
                            <a href="../tasks/toggle.php?id=<?= $t['id'] ?>" title="Complete"><i class="fas fa-check-circle"></i></a>
                            <button onclick='openEdit(<?= $t['id'] ?>, <?= json_encode($t['title']) ?>, <?= json_encode($t['description']) ?>, <?= json_encode($t['due_date']) ?>, <?= json_encode($t['category']) ?>, <?= json_encode($t['priority']) ?>)' title="Edit"><i class="fas fa-edit"></i></button>
                            <a href="../tasks/delete.php?id=<?= $t['id'] ?>" onclick="return confirmDelete()" title="Delete"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <p>No tasks yet. Create your first task above!</p>
                </div>
            <?php endif; ?>
        </ul>
    </main>
</div>

<!-- Edit Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h3><i class="fas fa-edit"></i> Edit Task</h3>
        <form method="POST" action="../tasks/edit.php" onsubmit="return validateTask(this)">
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="title" id="edit-title" placeholder="Task title" required>
            <input type="text" name="description" id="edit-desc" placeholder="Description">
            <input type="date" name="due_date" id="edit-date">
            <select name="category" id="edit-category">
                <option value="personal">👤 Personal</option>
                <option value="work">💼 Work</option>
                <option value="health">💪 Health</option>
                <option value="education">📚 Education</option>
                <option value="other">📌 Other</option>
            </select>
            <select name="priority" id="edit-priority">
                <option value="low">🟢 Low Priority</option>
                <option value="medium">🟡 Medium Priority</option>
                <option value="high">🔴 High Priority</option>
            </select>
            <div class="modal-buttons">
                <button type="submit">Save Changes</button>
                <button type="button" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this task?');
}

function openEdit(id, title, desc, date, category, priority) {
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-title').value = title;
    document.getElementById('edit-desc').value = desc || '';
    document.getElementById('edit-date').value = date || '';
    document.getElementById('edit-category').value = category || 'other';
    document.getElementById('edit-priority').value = priority || 'medium';
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function validateTask(form) {
    if(form.title.value.trim() === '') {
        alert('Please enter a task title');
        return false;
    }
    return true;
}

// Dark mode toggle with icon & text update
const darkBtn = document.getElementById('darkModeBtn');
function applyDarkMode(isDark) {
    if (isDark) {
        document.body.classList.add('dark-mode');
        darkBtn.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
    } else {
        document.body.classList.remove('dark-mode');
        darkBtn.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
    }
    localStorage.setItem('glowup_dark', isDark);
}

darkBtn.addEventListener('click', () => {
    const willBeDark = !document.body.classList.contains('dark-mode');
    applyDarkMode(willBeDark);
});

// Load saved preference
const savedDark = localStorage.getItem('glowup_dark') === 'true';
if (savedDark) applyDarkMode(true);
</script>
</body>
</html>
