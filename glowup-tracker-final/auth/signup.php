<?php 
session_start();
include '../config/db.php';

$error = '';
$username_value = '';
$email_value = '';

if(isset($_POST['signup'])){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $username_value = $username;
    $email_value = $email;

    if(strlen($password) < 6){
        $error = 'Password must be at least 6 characters';
    } elseif($password !== $confirm_password){
        $error = 'Passwords do not match';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if($check_stmt->num_rows > 0){
            $error = 'Email already registered';
        } else {
            $stmt = $conn->prepare("INSERT INTO users(username, email, password) VALUES(?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hash);
            if($stmt->execute()){
                header("Location: login.php?msg=signup_success");
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
        $check_stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up · GlowUp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="../assets/js/script.js"></script></head>


    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #e8f5e9 0%, #c8e6c9 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }
        .signup-card {
            background: white;
            border-radius: 2rem;
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
        }
        .logo { text-align: center; font-size: 2rem; font-weight: 800; color: #2e5c2e; }
        .welcome-text { text-align: center; font-size: 1.6rem; font-weight: 700; color: #1b3b1b; }
        .glow-sub { text-align: center; font-size: 0.85rem; color: #4a6b4a; margin-bottom: 1.5rem; }
        .input-group { margin-bottom: 1rem; }
        .input-label { font-size: 0.75rem; font-weight: 600; color: #2e5c2e; margin-bottom: 0.3rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 1rem;
            font-size: 0.9rem;
        }
        .input-icon { position: absolute; left: 0.8rem; top: 0.8rem; color: #2e7d32; }
        .toggle-password { position: absolute; right: 0.8rem; top: 0.7rem; background: none; border: none; cursor: pointer; color: #888; }
        .signup-btn {
            background: #2e7d32;
            color: white;
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin: 1rem 0;
        }
        .signup-btn:hover { background: #1b5e20; }
        .login-link { text-align: center; font-size: 0.85rem; }
        .login-link a { color: #2e7d32; text-decoration: none; }
        .error-message { background: #ffebee; color: #c62828; padding: 0.5rem; border-radius: 0.5rem; margin-bottom: 1rem; text-align: center; }
        .password-hint { font-size: 0.65rem; color: #888; margin-top: 0.2rem; }
    </style>
</head>
<body>
    <div class="signup-card">
        <div class="logo">✨ GlowUp</div>
        <div class="welcome-text">Create Account</div>
        <div class="glow-sub">Start your glow up journey today</div>

        <?php if($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <div class="input-label">Username</div>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="username" placeholder="Your username" value="<?= htmlspecialchars($username_value) ?>" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-label">Email Address</div>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" placeholder="your@email.com" value="<?= htmlspecialchars($email_value) ?>" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-label">Password</div>
                <div class="input-wrapper">
                    <i class="fas fa-key input-icon"></i>
                    <input type="password" name="password" id="password" placeholder="Min. 6 characters" required>
                    <button type="button" class="toggle-password" id="togglePassword"><i class="fas fa-eye-slash"></i></button>
                </div>
                <div class="password-hint">🔒 Password must be at least 6 characters</div>
            </div>

            <div class="input-group">
                <div class="input-label">Confirm Password</div>
                <div class="input-wrapper">
                    <i class="fas fa-check input-icon"></i>
                    <input type="password" name="confirm_password" id="confirmPassword" placeholder="Repeat your password" required>
                    <button type="button" class="toggle-password" id="toggleConfirmPassword"><i class="fas fa-eye-slash"></i></button>
                </div>
            </div>

            <button type="submit" name="signup" class="signup-btn">Sign Up <i class="fas fa-arrow-right"></i></button>

            <div class="login-link">Already have an account? <a href="login.php">Sign In</a></div>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            let p = document.getElementById('password');
            p.type = p.type === 'password' ? 'text' : 'password';
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            let p = document.getElementById('confirmPassword');
            p.type = p.type === 'password' ? 'text' : 'password';
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
