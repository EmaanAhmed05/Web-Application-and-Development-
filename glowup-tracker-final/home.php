<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GlowUp · Transform Your Life</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --primary:      #2e7d32;
      --primary-dark: #1b5e20;
      --primary-deep: #1b3b1b;
      --bg-from:  #e8f5e9;
      --bg-to:    #c8e6c9;
      --card:     #ffffff;
      --text:     #1b3b1b;
      --text-mid: #3a6b3a;
      --text-muted: #4a6b4a;
      --text-soft:  #6c8c72;
      --border:   #e8f5e9;
      --border-mid: #c8e6c9;
      --nav-border: rgba(0,0,0,0.05);
      --badge-bg:   rgba(46,125,50,0.10);
      --icon-bg:    rgba(46,125,50,0.10);
      --stat-border: #c8e6c9;
    }

    /* ── Dark mode variables ── */
    body.dark-mode {
      --bg-from:    #1a2a1a;
      --bg-to:      #162116;
      --card:       #243624;
      --text:       #e0f2e0;
      --text-mid:   #b8d4b8;
      --text-muted: #adc7a5;
      --text-soft:  #8aab8a;
      --border:     #3c5a3a;
      --border-mid: #2e4a2e;
      --nav-border: rgba(255,255,255,0.06);
      --badge-bg:   rgba(124,191,142,0.15);
      --icon-bg:    rgba(124,191,142,0.15);
      --stat-border: #2e4a2e;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(145deg, var(--bg-from) 0%, var(--bg-to) 100%);
      min-height: 100vh;
      overflow-x: hidden;
      transition: background 0.3s ease;
    }

    /* ── Navbar ── */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem 5%;
      max-width: 1400px;
      margin: 0 auto;
      border-bottom: 1px solid var(--nav-border);
      transition: border-color 0.3s;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--text);
      transition: color 0.3s;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }

    .nav-links a {
      text-decoration: none;
      color: var(--text);
      font-weight: 500;
      transition: color 0.3s;
    }
    .nav-links a:hover { color: var(--primary); }

    .nav-btn {
      background: var(--primary) !important;
      color: #fff !important;
      padding: 0.6rem 1.5rem;
      border-radius: 2rem;
      transition: background 0.3s !important;
    }
    .nav-btn:hover { background: var(--primary-dark) !important; }

    /* ── Dark toggle in nav ── */
    .dark-toggle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 1px solid var(--border-mid);
      background: var(--badge-bg);
      color: var(--primary);
      font-size: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
      flex-shrink: 0;
    }
    .dark-toggle:hover { background: var(--icon-bg); transform: scale(1.1); }

    /* ── Hero ── */
    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      max-width: 1300px;
      margin: 0 auto;
      padding: 3rem 5%;
      gap: 3rem;
      flex-wrap: wrap;
    }

    .hero-content { flex: 1; }

    .hero-badge {
      display: inline-block;
      background: var(--badge-bg);
      color: var(--primary);
      padding: 0.4rem 1rem;
      border-radius: 2rem;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      transition: all 0.3s;
    }

    .hero-content h1 {
      font-size: 3.5rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 1rem;
      color: var(--text);
      transition: color 0.3s;
    }
    .hero-content h1 span { color: var(--primary); }

    .hero-tagline {
      font-size: 1.2rem;
      color: var(--text-mid);
      margin-bottom: 1rem;
      font-weight: 500;
      transition: color 0.3s;
    }

    .hero-description {
      color: var(--text-muted);
      line-height: 1.7;
      margin: 1.5rem 0 2rem;
      font-size: 1.05rem;
      max-width: 500px;
      transition: color 0.3s;
    }

    /* ── Buttons ── */
    .button-group {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      margin-top: 1rem;
      flex-wrap: wrap;
    }

    .btn-start {
      background: var(--badge-bg);
      border: 1px solid rgba(46,125,50,0.3);
      color: var(--primary);
      padding: 0.8rem 1.8rem;
      border-radius: 3rem;
      font-size: 1rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s;
    }

    .btn-signin {
      background: transparent;
      border: 2px solid var(--primary);
      color: var(--primary);
      padding: 0.8rem 1.8rem;
      border-radius: 3rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s;
    }
    .btn-signin:hover {
      background: var(--badge-bg);
      transform: translateY(-3px);
      gap: 0.8rem;
    }

    /* ── Feature grid ── */
    .hero-visual { flex: 1; }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.2rem;
    }

    .feature-card {
      background: var(--card);
      border-radius: 1.5rem;
      padding: 1.5rem;
      text-align: center;
      border: 1px solid var(--border);
      cursor: pointer;
      transition: all 0.3s;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.10);
      border-color: var(--primary);
    }

    .feature-icon {
      width: 60px;
      height: 60px;
      background: var(--icon-bg);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      transition: all 0.3s;
    }
    .feature-card:hover .feature-icon { background: var(--primary); }

    .feature-icon i {
      font-size: 1.8rem;
      color: var(--primary);
      transition: all 0.3s;
    }
    .feature-card:hover .feature-icon i { color: #fff; }

    .feature-card h3 {
      font-size: 1rem;
      margin-bottom: 0.5rem;
      color: var(--text);
      transition: color 0.3s;
    }

    .feature-card p {
      font-size: 0.75rem;
      color: var(--text-soft);
      transition: color 0.3s;
    }

    /* ── Stats ── */
    .stats {
      display: flex;
      justify-content: space-around;
      max-width: 1000px;
      margin: 2rem auto 0;
      padding: 2rem 5%;
      border-top: 1px solid var(--stat-border);
      flex-wrap: wrap;
      gap: 2rem;
      transition: border-color 0.3s;
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--primary);
      transition: color 0.3s;
    }

    .stat-label {
      color: var(--text-muted);
      font-size: 0.9rem;
      transition: color 0.3s;
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
      .hero { flex-direction: column; text-align: center; }
      .hero-content h1 { font-size: 2.5rem; }
      .hero-description { max-width: 100%; }
      .button-group { justify-content: center; }
      .navbar { flex-direction: column; gap: 1rem; }
    }

    @media (max-width: 480px) {
      .hero-content h1 { font-size: 2rem; }
      .feature-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="logo">GlowUp</div>
  <div class="nav-links">
    <a href="#">Home</a>
    <a href="#">Features</a>
    <a href="pages/about.php">About</a>
    <a href="auth/login.php" class="nav-btn">Sign In</a>
    <button class="dark-toggle" onclick="toggleDark()" aria-label="Toggle dark mode">
      <i class="fas fa-moon" id="darkIcon"></i>
    </button>
  </div>
</nav>

<section class="hero">
  <div class="hero-content">
    <span class="hero-badge">Transform Your Life. One Day at a Time</span>
    <h1>Your Ultimate <span>GlowUp Journey</span></h1>
    <p class="hero-tagline">Track your habits, monitor your progress</p>
    <p class="hero-description">
      Track your habits, monitor your progress, and achieve your self-improvement goals
      with our beautiful and intuitive platform.
    </p>
    <div class="button-group">
      <div class="btn-start">
        Start Your Glow Up <i class="fas fa-arrow-right"></i>
      </div>
      <a href="auth/login.php" class="btn-signin">
        Sign In <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>

  <div class="hero-visual">
    <div class="feature-grid">
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
        <h3>Daily Tasks</h3>
        <p>Organize your day</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
        <h3>Track Progress</h3>
        <p>See your growth</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-bell"></i></div>
        <h3>Reminders</h3>
        <p>Never miss a task</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-moon"></i></div>
        <h3>Dark Mode</h3>
        <p>Easy on eyes</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-trophy"></i></div>
        <h3>Achievements</h3>
        <p>Earn badges</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
        <h3>Secure</h3>
        <p>Your data is safe</p>
      </div>
    </div>
  </div>
</section>

<div class="stats">
  <div class="stat-item">
    <div class="stat-number">10K+</div>
    <div class="stat-label">Active Users</div>
  </div>
  <div class="stat-item">
    <div class="stat-number">50K+</div>
    <div class="stat-label">Tasks Completed</div>
  </div>
  <div class="stat-item">
    <div class="stat-number">85%</div>
    <div class="stat-label">Success Rate</div>
  </div>
</div>

<script>
  function toggleDark() {
    const isDark = document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', isDark);
    document.getElementById('darkIcon').className = isDark ? 'fas fa-sun' : 'fas fa-moon';
  }

  // Sync with welcome page preference
  if (localStorage.getItem('darkMode') === 'true' || localStorage.getItem('glowDark') === 'true') {
    document.body.classList.add('dark-mode');
    document.getElementById('darkIcon').className = 'fas fa-sun';
  }
</script>
</body>
</html>
