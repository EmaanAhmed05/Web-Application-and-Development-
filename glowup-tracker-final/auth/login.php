<?php 
session_start();
include '../config/db.php';

$error = '';

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR username=? LIMIT 1");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();

    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if($user && password_verify($password, $user['PASSWORD'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: ../pages/dashboard.php?msg=login_success");
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login - GlowUp</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <h2>GlowUp Tracker</h2>
    <form method="POST" onsubmit="return validateAuth(this)">
        <input name="email" placeholder="Email or Username" required>
        <input name="password" type="password" placeholder="Password" required>
        <button name="login">Login</button>
        <p class="error"><?= e($error) ?></p>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
