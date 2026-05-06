<?php include '../config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>About - GlowUp</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
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
    body.dark-mode .profile-card {
        background: #16213e !important;
        color: white !important;
    }
    body.dark-mode .logout {
        color: #ff6b6b !important;
    }
    body.dark-mode .avatar {
        background: #2e7d32 !important;
    }
</style>
</head>
<body>
<div class="container">
<aside class="sidebar">
    <h2>GlowUp</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="about.php" class="active">About</a>
    <a href="#" class="dark-mode-btn">🌙 Dark Mode</a>
    <a href="../auth/logout.php" class="logout">Logout</a>
</aside>
<main class="main">
    <h1>Our Team</h1>
    <div class="profiles">
        <div class="profile-card" onclick="showProfile('Ayesha Zaheed','Backend Developer')">
            <div class="avatar">A</div>
            <h3>Ayesha Zaheed</h3>
            <p>Backend Developer</p>
        </div>
        <div class="profile-card" onclick="window.open('../eman-portfolio.html', '_blank')">
    <div class="avatar">E</div>
    <h3>Eman Iftikhar Ahmed</h3>
    <p>Backend Developer</p>
</div>
        <div class="profile-card" onclick="showProfile('Syeda Areeba Naqvi','Frontend Developer')">
            <div class="avatar">S</div>
            <h3>Syeda Areeba Naqvi</h3>
            <p>Frontend Developer</p>
        </div>
        <div class="profile-card" onclick="showProfile('Mahnoor Zahid','Frontend Developer')">
            <div class="avatar">M</div>
            <h3>Mahnoor Zahid</h3>
            <p>Frontend Developer</p>
        </div>
    </div>
</main>
</div>

<script src="../assets/js/script.js"></script>
<script>
function showProfile(name, role) {
    alert(name + "\n" + role);
}
</script>
</body>
</html>
