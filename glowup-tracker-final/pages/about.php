<?php include '../config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>About - GlowUp</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
<aside class="sidebar">
    <h2>GlowUp</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="about.php" class="active">About</a>
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
        <div class="profile-card" onclick="showProfile('Eman Iftikhar Ahmed','Backend Developer')">
            <div class="avatar">E</div>
            <h3>Eman Iftikhar Ahmed</h3>
            <p>Backend Developer</p>
        </div>
        <div class="profile-card" onclick="showProfile('Syeda Areeba Naqvi','Frontkend Developer')">
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
</body>
</html>
