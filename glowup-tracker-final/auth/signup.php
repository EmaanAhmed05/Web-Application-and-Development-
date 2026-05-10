<?php 
session_start();
include '../config/db.php';

$error          = '';
$username_value = '';
$email_value    = '';

if(isset($_POST['signup'])){
    $username         = trim($_POST['username']);
    $email            = trim($_POST['email']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $username_value = $username;
    $email_value    = $email;

    if(strlen($password) < 6){
        $error = 'Password must be at least 6 characters';
    } elseif($password !== $confirm_password){
        $error = 'Passwords do not match';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
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
        $check->close();
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
      --sub-color:    #4a6b4a;
      --hint-color:   #888888;
      --input-bg:     #fafafa;
      --input-border: #e0e0e0;
      --input-focus-shadow: rgba(46,125,50,0.10);
      --label-color:  #2e5c2e;
      --link-color:   #2e7d32;
      --card-shadow:  0 25px 50px -12px rgba(0,0,0,0.18);
      --particle-bg:  rgba(46,125,50,0.10);
    }

    body.dark-mode {
      --bg-from: #1a2a1a;
      --bg-to:   #162116;
      --card:    #243624;
      --text:    #e0f2e0;
      --text-mid: #a8cca8;
      --sub-color:    #8aab8a;
      --hint-color:   #6a8a6a;
      --input-bg:     #1e301e;
      --input-border: #3c5a3a;
      --input-focus-shadow: rgba(124,191,142,0.12);
      --label-color:  #9fcf9f;
      --link-color:   #7cbf8e;
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
      padding: 2rem 1rem;
      position: relative;
      overflow: hidden;
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
    .signup-card {
      background: var(--card);
      border-radius: 2rem;
      padding: 2rem;
      width: 100%;
      max-width: 450px;
      box-shadow: var(--card-shadow);
      position: relative;
      z-index: 10;
      animation: fadeInUp 0.6s ease both;
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
      transition: color 0.3s;
    }
    .welcome-text {
      text-align: center;
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--text);
      transition: color 0.3s;
    }
    .glow-sub {
      text-align: center;
      font-size: 0.85rem;
      color: var(--sub-color);
      margin-bottom: 1.5rem;
      transition: color 0.3s;
    }

    /* ── Error ── */
    .error-message {
      background: #ffebee;
      color: #c62828;
      padding: 0.5rem;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
      text-align: center;
      font-size: 0.85rem;
      animation: shake 0.5s ease;
    }
    body.dark-mode .error-message {
      background: #3b1a1a;
      color: #f48a8a;
    }
    @keyframes shake {
      0%,100% { transform:translateX(0);   }
      25%      { transform:translateX(-5px); }
      75%      { transform:translateX(5px);  }
    }

    /* ── Form ── */
    .input-group { margin-bottom: 1rem; }

    .input-label {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--label-color);
      margin-bottom: 0.3rem;
      transition: color 0.3s;
    }

    .input-wrapper { position: relative; }

    .input-wrapper input {
      width: 100%;
      padding: 0.8rem 1rem 0.8rem 2.5rem;
      border: 1.5px solid var(--input-border);
      border-radius: 1rem;
      font-size: 0.9rem;
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
      left: 0.8rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--primary);
      font-size: 0.9rem;
      transition: color 0.3s;
    }

    .toggle-password {
      position: absolute;
      right: 0.8rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: var(--hint-color);
      font-size: 0.9rem;
      transition: color 0.3s;
    }
    .toggle-password:hover { color: var(--primary); }

    .password-hint {
      font-size: 0.65rem;
      color: var(--hint-color);
      margin-top: 0.25rem;
      transition: color 0.3s;
    }

    /* ── Submit ── */
    .signup-btn {
      background: var(--primary);
      color: #fff;
      width: 100%;
      padding: 0.9rem;
      border: none;
      border-radius: 1.5rem;
      font-family: 'Inter', sans-serif;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.7rem;
      margin: 1rem 0;
      transition: all 0.3s ease;
    }
    .signup-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(46,125,50,0.3);
    }
    .signup-btn:active { transform: scale(0.98); }

    /* ── Login link ── */
    .login-link {
      text-align: center;
      font-size: 0.85rem;
      color: var(--sub-color);
      transition: color 0.3s;
    }
    .login-link a {
      color: var(--link-color);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }
    .login-link a:hover { text-decoration: underline; }

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
      .signup-card { padding: 1.5rem; }
      .welcome-text { font-size: 1.3rem; }
    }
  </style>
</head>
<body>

  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>

  <div class="signup-card">
    <div class="logo">GlowUp</div>
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
          <input type="text" name="username" placeholder="Your username"
                 value="<?= htmlspecialchars($username_value) ?>" required>
        </div>
      </div>

      <div class="input-group">
        <div class="input-label">Email Address</div>
        <div class="input-wrapper">
          <i class="fas fa-envelope input-icon"></i>
          <input type="email" name="email" placeholder="your@email.com"
                 value="<?= htmlspecialchars($email_value) ?>" required>
        </div>
      </div>

      <div class="input-group">
        <div class="input-label">Password</div>
        <div class="input-wrapper">
          <i class="fas fa-key input-icon"></i>
          <input type="password" name="password" id="password" placeholder="Min. 6 characters" required>
          <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password">
            <i class="fas fa-eye-slash"></i>
          </button>
        </div>
        <div class="password-hint">Password must be at least 6 characters</div>
      </div>

      <div class="input-group">
        <div class="input-label">Confirm Password</div>
        <div class="input-wrapper">
          <i class="fas fa-check input-icon"></i>
          <input type="password" name="confirm_password" id="confirmPassword"
                 placeholder="Repeat your password" required>
          <button type="button" class="toggle-password" id="toggleConfirm" aria-label="Toggle confirm password">
            <i class="fas fa-eye-slash"></i>
          </button>
        </div>
      </div>

      <button type="submit" name="signup" class="signup-btn">
        Sign Up <i class="fas fa-arrow-right"></i>
      </button>

      <div class="login-link">Already have an account? <a href="login.php">Sign In</a></div>
    </form>
  </div>

  <button class="dark-toggle" onclick="toggleDark()" aria-label="Toggle dark mode">
    <i class="fas fa-moon" id="darkIcon"></i>
  </button>

  <script src="../assets/js/script.js"></script>
  <script>
    // Password toggles
    function makeToggle(btnId, fieldId) {
      document.getElementById(btnId).addEventListener('click', function() {
        const field = document.getElementById(fieldId);
        const isHidden = field.type === 'password';
        field.type = isHidden ? 'text' : 'password';
        this.querySelector('i').classList.toggle('fa-eye-slash', !isHidden);
        this.querySelector('i').classList.toggle('fa-eye', isHidden);
      });
    }
    makeToggle('togglePassword', 'password');
    makeToggle('toggleConfirm', 'confirmPassword');

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
