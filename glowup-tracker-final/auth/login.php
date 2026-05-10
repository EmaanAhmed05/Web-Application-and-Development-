<?php 
session_start();
include '../config/db.php';

$error = '';
$email_value = '';

if(isset($_COOKIE['remember_email'])) {
    $email_value = $_COOKIE['remember_email'];
}

if(isset($_POST['login'])){
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR username=? LIMIT 1");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];

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
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --primary:      #2e7d32;
      --primary-dark: #1b5e20;
      --bg-from: #e8f5e9;
      --bg-to:   #c8e6c9;
      --card:    #ffffff;
      --text:    #1b3b1b;
      --text-mid: #2e5c2e;
      --text-muted: #4a6b4a;
      --input-bg:     #fafafa;
      --input-border: #e0e0e0;
      --input-focus-shadow: rgba(46,125,50,0.10);
      --success-bg:   #e8f5e9;
      --success-text: #2e7d32;
      --success-border: #2e7d32;
      --label-color:  #2e5c2e;
      --link-color:   #2e7d32;
      --sub-color:    #4a6b4a;
      --card-shadow:  0 25px 50px -12px rgba(0,0,0,0.18);
      --particle-bg:  rgba(46,125,50,0.10);
    }

    body.dark-mode {
      --bg-from: #1a2a1a;
      --bg-to:   #162116;
      --card:    #243624;
      --text:    #e0f2e0;
      --text-mid: #a8cca8;
      --text-muted: #8aab8a;
      --input-bg:     #1e301e;
      --input-border: #3c5a3a;
      --input-focus-shadow: rgba(124,191,142,0.12);
      --success-bg:   #1e3a1e;
      --success-text: #7cbf8e;
      --success-border: #5e9f71;
      --label-color:  #9fcf9f;
      --link-color:   #7cbf8e;
      --sub-color:    #8aab8a;
      --card-shadow:  0 25px 50px -12px rgba(0,0,0,0.40);
      --particle-bg:  rgba(124,191,142,0.08);
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(145deg, var(--bg-from) 0%, var(--bg-to) 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
      padding: 1rem;
      transition: background 0.3s ease;
    }

    /* ── Particles ── */
    .particle {
      position: absolute;
      border-radius: 50%;
      background: var(--particle-bg);
      pointer-events: none;
      animation: float 20s ease-in-out infinite;
      transition: background 0.3s;
    }
    .particle:nth-child(1) { width:300px; height:300px; top:-100px;  left:-100px;  animation-delay:0s; }
    .particle:nth-child(2) { width:200px; height:200px; bottom:-50px; right:-50px;  animation-delay:2s; }
    .particle:nth-child(3) { width:150px; height:150px; top:50%;     left:10%;     animation-delay:4s; }
    .particle:nth-child(4) { width:250px; height:250px; bottom:20%;  right:15%;    animation-delay:6s; }
    .particle:nth-child(5) { width:100px; height:100px; top:20%;     right:30%;    animation-delay:1s; }
    .particle:nth-child(6) { width:180px; height:180px; bottom:10%;  left:20%;     animation-delay:3s; }
    .particle:nth-child(7) { width:80px;  height:80px;  top:60%;     right:5%;     animation-delay:5s; }

    @keyframes float {
      0%,100% { transform: translateY(0)     rotate(0deg);  }
      25%      { transform: translateY(-20px) rotate(5deg);  }
      75%      { transform: translateY(20px)  rotate(-5deg); }
    }

    /* ── Card ── */
    .login-card {
      background: var(--card);
      border-radius: 2rem;
      padding: 2rem;
      width: 100%;
      max-width: 450px;
      box-shadow: var(--card-shadow);
      animation: fadeInUp 0.6s ease both;
      z-index: 10;
      position: relative;
      transition: background 0.3s, box-shadow 0.3s;
    }
    @keyframes fadeInUp {
      from { opacity:0; transform:translateY(30px); }
      to   { opacity:1; transform:translateY(0);    }
    }

    /* ── Header ── */
    .logo {
      text-align: center;
      font-size: 2rem;
      font-weight: 800;
      color: var(--primary);
      margin-bottom: 0.5rem;
      transition: color 0.3s;
    }
    .welcome-text {
      text-align: center;
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 0.3rem;
      transition: color 0.3s;
    }
    .glow-sub {
      text-align: center;
      font-size: 0.9rem;
      color: var(--sub-color);
      margin-bottom: 1.8rem;
      transition: color 0.3s;
    }

    /* ── Alerts ── */
    .success-message {
      background: var(--success-bg);
      color: var(--success-text);
      border-left: 4px solid var(--success-border);
      padding: 0.8rem;
      border-radius: 1rem;
      font-size: 0.85rem;
      text-align: center;
      margin-bottom: 1rem;
      transition: all 0.3s;
    }
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
    body.dark-mode .error-message {
      background: #3b1a1a;
      color: #f48a8a;
    }
    @keyframes shake {
      0%,100% { transform:translateX(0);  }
      25%      { transform:translateX(-5px); }
      75%      { transform:translateX(5px);  }
    }

    /* ── Form ── */
    .input-group { margin-bottom: 1.3rem; }

    .input-label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--label-color);
      margin-bottom: 0.5rem;
      transition: color 0.3s;
    }

    .input-wrapper { position: relative; display: flex; align-items: center; }

    .input-wrapper input {
      width: 100%;
      padding: 0.9rem 1rem 0.9rem 2.8rem;
      font-size: 1rem;
      border: 1.5px solid var(--input-border);
      border-radius: 1rem;
      background: var(--input-bg);
      color: var(--text);
      outline: none;
      transition: all 0.3s ease;
    }
    .input-wrapper input::placeholder { color: var(--sub-color); }
    .input-wrapper input:focus {
      border-color: var(--primary);
      background: var(--card);
      box-shadow: 0 0 0 3px var(--input-focus-shadow);
    }

    .input-icon {
      position: absolute;
      left: 1rem;
      color: var(--primary);
      font-size: 1rem;
      transition: color 0.3s;
    }

    .toggle-password {
      position: absolute;
      right: 1rem;
      background: none;
      border: none;
      cursor: pointer;
      color: var(--sub-color);
      font-size: 1rem;
      transition: color 0.3s;
    }
    .toggle-password:hover { color: var(--primary); }

    /* ── Row actions ── */
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
      color: var(--text-muted);
      cursor: pointer;
      transition: color 0.3s;
    }
    .checkbox-label input { width:1rem; height:1rem; accent-color: var(--primary); }
    .forgot-link {
      color: var(--link-color);
      text-decoration: none;
      transition: all 0.3s;
    }
    .forgot-link:hover { color: var(--primary-dark); text-decoration: underline; }

    /* ── Submit button ── */
    .login-btn {
      background: var(--primary);
      color: #fff;
      width: 100%;
      border: none;
      padding: 1rem;
      border-radius: 1.5rem;
      font-family: 'Inter', sans-serif;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.8rem;
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
    }
    .login-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      gap: 1rem;
      box-shadow: 0 5px 15px rgba(46,125,50,0.3);
    }

    /* ── Signup link ── */
    .signup-link {
      text-align: center;
      color: var(--sub-color);
      font-size: 0.9rem;
      transition: color 0.3s;
    }
    .signup-link a {
      color: var(--link-color);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }
    .signup-link a:hover { text-decoration: underline; }

    /* ── Dark mode toggle ── */
    .dark-toggle {
      position: fixed;
      bottom: 28px;
      right: 28px;
      z-index: 1000;
      width: 46px;
      height: 46px;
      border-radius: 50%;
      border: 1.5px solid var(--input-border);
      background: var(--card);
      color: var(--primary);
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: var(--card-shadow);
      transition: all 0.3s ease;
    }
    .dark-toggle:hover { transform: scale(1.1); }

    /* ── Responsive ── */
    @media (max-width: 480px) {
      .login-card  { padding: 1.5rem; }
      .welcome-text { font-size: 1.5rem; }
    }
  </style>
  <!-- Prevent flash of wrong theme -->
  <script>
    if(localStorage.getItem('darkMode') === 'true' || localStorage.getItem('glowDark') === 'true') {
      document.documentElement.classList.add('dark-mode-pending');
    }
  </script>
</head>
<body>

  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>

  <div class="login-card">
    <div class="logo">GlowUp</div>
    <div class="welcome-text">Welcome Back!</div>
    <div class="glow-sub">Continue your glow up journey</div>

    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'signup_success'): ?>
      <div class="success-message">Account created successfully! Please sign in.</div>
    <?php endif; ?>

    <?php if($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="input-group">
        <div class="input-label"><i class="fas fa-envelope"></i> Email Address</div>
        <div class="input-wrapper">
          <i class="fas fa-envelope input-icon"></i>
          <input type="email" name="email" placeholder="your@email.com"
                 value="<?= htmlspecialchars($email_value) ?>" required>
        </div>
      </div>

      <div class="input-group">
        <div class="input-label"><i class="fas fa-lock"></i> Password</div>
        <div class="input-wrapper">
          <i class="fas fa-key input-icon"></i>
          <input type="password" name="password" id="password" placeholder="••••••••" required>
          <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password visibility">
            <i class="fas fa-eye-slash"></i>
          </button>
        </div>
      </div>

      <div class="row-actions">
        <label class="checkbox-label">
          <input type="checkbox" name="remember" <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?>>
          <span>Remember me</span>
        </label>
        <a href="#" id="forgotPassword" class="forgot-link">Forgot password?</a>
      </div>

      <button type="submit" name="login" class="login-btn">
        Sign In <i class="fas fa-arrow-right"></i>
      </button>

      <div class="signup-link">
        Don't have an account? <a href="signup.php">Sign Up</a>
      </div>
    </form>
  </div>

  <!-- Dark mode toggle -->
  <button class="dark-toggle" onclick="toggleDark()" aria-label="Toggle dark mode">
    <i class="fas fa-moon" id="darkIcon"></i>
  </button>

  <script src="../assets/js/script.js"></script>
  <script>
    // Password visibility toggle
    document.getElementById('togglePassword').addEventListener('click', function() {
      const field = document.getElementById('password');
      const isHidden = field.type === 'password';
      field.type = isHidden ? 'text' : 'password';
      this.querySelector('i').classList.toggle('fa-eye-slash', !isHidden);
      this.querySelector('i').classList.toggle('fa-eye', isHidden);
    });

    // Forgot password
    document.getElementById('forgotPassword').addEventListener('click', function(e) {
      e.preventDefault();
      alert('Password reset link would be sent to your email.');
    });

    // Dark mode
    function toggleDark() {
      const isDark = document.body.classList.toggle('dark-mode');
      localStorage.setItem('darkMode', isDark);
      document.getElementById('darkIcon').className = isDark ? 'fas fa-sun' : 'fas fa-moon';
    }

    // Sync preference from any GlowUp page
    if(localStorage.getItem('darkMode') === 'true' || localStorage.getItem('glowDark') === 'true') {
      document.body.classList.add('dark-mode');
      document.getElementById('darkIcon').className = 'fas fa-sun';
    }
  </script>
</body>
</html>
