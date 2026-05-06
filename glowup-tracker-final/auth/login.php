<?php 
session_start();
include '../config/db.php';

$error = '';
$email_value = '';

// Remember me feature - pre-fill email if cookie exists
if(isset($_COOKIE['remember_email'])) {
    $email_value = $_COOKIE['remember_email'];
}

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR username=? LIMIT 1");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();

    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Set remember me cookie for 30 days
        if($remember){
            setcookie('remember_email', $email, time() + (86400 * 30), "/");
        } else {
            setcookie('remember_email', '', time() - 3600, "/");
        }

        header("Location: ../pages/dashboard.php?msg=login_success");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · GlowUp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="../assets/js/script.js"></script></head>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #e8f5e9 0%, #c8e6c9 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 1rem;
        }

        /* Background Circles */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(46, 125, 50, 0.1);
            pointer-events: none;
            animation: float 20s infinite ease-in-out;
        }

        .circle1 { width: 300px; height: 300px; top: -100px; left: -100px; animation-delay: 0s; }
        .circle2 { width: 200px; height: 200px; bottom: -50px; right: -50px; animation-delay: 2s; }
        .circle3 { width: 150px; height: 150px; top: 50%; left: 10%; animation-delay: 4s; }
        .circle4 { width: 250px; height: 250px; bottom: 20%; right: 15%; animation-delay: 6s; }
        .circle5 { width: 100px; height: 100px; top: 20%; right: 30%; animation-delay: 1s; }
        .circle6 { width: 180px; height: 180px; bottom: 10%; left: 20%; animation-delay: 3s; }
        .circle7 { width: 80px; height: 80px; top: 60%; right: 5%; animation-delay: 5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            75% { transform: translateY(20px) rotate(-5deg); }
        }

        /* Login Card */
        .login-card {
            background: white;
            border-radius: 2rem;
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.6s ease;
            z-index: 10;
            position: relative;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            font-size: 2rem;
            font-weight: 800;
            color: #2e5c2e;
            margin-bottom: 0.5rem;
        }

        .welcome-text {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: #1b3b1b;
            margin-bottom: 0.3rem;
        }

        .glow-sub {
            text-align: center;
            font-size: 0.9rem;
            color: #4a6b4a;
            margin-bottom: 1.8rem;
        }

        /* Success Message */
        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 0.8rem;
            border-radius: 1rem;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 1rem;
            border-left: 4px solid #2e7d32;
        }

        /* Input Groups */
        .input-group {
            margin-bottom: 1.3rem;
        }

        .input-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #2e5c2e;
            margin-bottom: 0.5rem;
        }

        .input-label i {
            font-size: 0.9rem;
            color: #2e7d32;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            font-size: 1rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 1rem;
            background: #fafafa;
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .input-wrapper input:focus {
            border-color: #2e7d32;
            background: white;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #2e7d32;
            font-size: 1rem;
        }

        /* Password Toggle */
        .toggle-password {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #888;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #2e7d32;
        }

        /* Row Actions */
        .row-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1rem 0 1.8rem;
            font-size: 0.85rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #4a6b4a;
            cursor: pointer;
        }

        .checkbox-label input {
            width: 1rem;
            height: 1rem;
            accent-color: #2e7d32;
            cursor: pointer;
        }

        .forgot-link {
            color: #2e7d32;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: #1b5e20;
            text-decoration: underline;
        }

        /* Login Button */
        .login-btn {
            background: #2e7d32;
            color: white;
            width: 100%;
            border: none;
            padding: 1rem;
            border-radius: 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .login-btn:hover {
            background: #1b5e20;
            transform: translateY(-2px);
            gap: 1rem;
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Sign Up Link */
        .signup-link {
            text-align: center;
            color: #4a6b4a;
            font-size: 0.9rem;
        }

        .signup-link a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: #1b5e20;
            text-decoration: underline;
        }

        /* Error Message */
        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 0.8rem;
            border-radius: 1rem;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 1rem;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
            }
            .welcome-text {
                font-size: 1.5rem;
            }
        }
        body.dark-mode .login-card {
    background: #16213e !important;
    color: white !important;
}
body.dark-mode .login-card input {
    background: #1a1a2e !important;
    color: white !important;
}
body.dark-mode .login-card h2 {
    color: #4caf50 !important;
}
    </style>
</head>
<body>

    <!-- Background Circles -->
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>
    <div class="circle circle4"></div>
    <div class="circle circle5"></div>
    <div class="circle circle6"></div>
    <div class="circle circle7"></div>

    <div class="login-card">
        <div class="logo">✨ GlowUp</div>
        <div class="welcome-text">Welcome Back!</div>
        <div class="glow-sub">Continue your glow up journey</div>

        <!-- Success message after signup -->
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'signup_success'): ?>
            <div class="success-message">
                ✅ Account created successfully! Please sign in.
            </div>
        <?php endif; ?>

        <!-- Error message -->
        <?php if($error): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <!-- Email Field -->
            <div class="input-group">
                <div class="input-label">
                    <i class="fas fa-envelope"></i>
                    <span>Email Address</span>
                </div>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" placeholder="your@email.com" value="<?= htmlspecialchars($email_value) ?>" required>
                </div>
            </div>

            <!-- Password Field -->
            <div class="input-group">
                <div class="input-label">
                    <i class="fas fa-lock"></i>
                    <span>Password</span>
                </div>
                <div class="input-wrapper">
                    <i class="fas fa-key input-icon"></i>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="row-actions">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?>>
                    <span>Remember me</span>
                </label>
                <a href="#" id="forgotPassword" class="forgot-link">Forgot password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit" name="login" class="login-btn">
                Sign In <i class="fas fa-arrow-right"></i>
            </button>

            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </div>
        </form>
    </div>

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        toggleBtn.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            const icon = toggleBtn.querySelector('i');
            if(type === 'text') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        // Forgot password demo
        document.getElementById('forgotPassword').addEventListener('click', function(e) {
            e.preventDefault();
            alert('📧 Password reset link would be sent to your email.\n(Demo feature)');
        });
    </script>

</body>
</html>
