<?php include '../config/db.php';
$error='';
if(isset($_POST['signup'])){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(strlen($password) < 6){
        $error = 'Password must be at least 6 characters';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users(username,email,password) VALUES(?,?,?)");
        $stmt->bind_param("sss", $username, $email, $hash);
        if($stmt->execute()){
            header("Location: login.php?msg=signup_success");
            exit;
        } else {
            $error = 'Email already exists';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign Up - GlowUp</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <h2>Start your glow up here</h2>
    <p>Create your account and transform today</p>
    <form method="POST" onsubmit="return validateAuth(this)">
        <input name="username" placeholder="Username" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <button name="signup">Sign Up</button>
        <p class="error"><?= e($error) ?></p>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
