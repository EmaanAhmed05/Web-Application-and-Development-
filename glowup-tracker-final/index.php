<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome · GlowUp</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --primary:      #7CBF8E;
      --primary-dark: #5E9F71;
      --bg:     #F4FAF4;
      --card:   #FCFEFC;
      --text:   #23412E;
      --muted:  #6F8B77;
      --border: #D8E8DA;
      --shadow: 0 10px 30px rgba(124,191,142,0.12);
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, var(--bg), #EEF7EF);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
      transition: background 0.3s ease;
    }

    /* ── Particles ── */
    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(124,191,142,0.13);
      pointer-events: none;
      animation: float 20s ease-in-out infinite;
    }
    .particle:nth-child(1) { width:300px; height:300px; top:-100px;  left:-100px;  animation-delay:0s;  }
    .particle:nth-child(2) { width:200px; height:200px; bottom:-50px; right:-50px;  animation-delay:2s;  }
    .particle:nth-child(3) { width:150px; height:150px; top:50%;     left:10%;     animation-delay:4s;  }
    .particle:nth-child(4) { width:250px; height:250px; bottom:20%;  right:15%;    animation-delay:6s;  }
    .particle:nth-child(5) { width:100px; height:100px; top:20%;     right:30%;    animation-delay:1s;  }
    .particle:nth-child(6) { width:180px; height:180px; bottom:10%;  left:20%;     animation-delay:3s;  }
    .particle:nth-child(7) { width:80px;  height:80px;  top:60%;     right:5%;     animation-delay:5s;  }

    @keyframes float {
      0%,100% { transform: translateY(0)     rotate(0deg);  }
      25%      { transform: translateY(-20px) rotate(5deg);  }
      75%      { transform: translateY(20px)  rotate(-5deg); }
    }

    /* ── Card ── */
    .welcome-container {
      position: relative;
      z-index: 10;
      text-align: center;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 28px;
      padding: 2.5rem 3rem;
      box-shadow: var(--shadow);
      backdrop-filter: blur(4px);
      animation: cardIn 1s ease both;
      transition: background 0.3s, border-color 0.3s, box-shadow 0.3s;
    }
    @keyframes cardIn {
      from { opacity:0; transform:scale(0.95); }
      to   { opacity:1; transform:scale(1);    }
    }

    /* ── Logo ── */
    .logo {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--primary-dark);
      letter-spacing: 2px;
      margin-bottom: 1.5rem;
      opacity: 0.9;
      animation: fadeUp 0.6s ease both;
      transition: color 0.3s;
    }

    /* ── Headline ── */
    .welcome-text {
      font-size: 4.5rem;
      font-weight: 800;
      color: var(--text);
      letter-spacing: -0.02em;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 10px rgba(124,191,142,0.15);
      animation: fadeUp 0.8s ease both;
      transition: color 0.3s;
    }

    /* ── Divider ── */
    .decorative-line {
      width: 70px;
      height: 4px;
      background: var(--primary);
      border-radius: 4px;
      margin: 1rem auto;
      animation: growLine 0.8s ease 0.3s both;
    }
    @keyframes growLine {
      from { width:0; opacity:0; }
      to   { width:70px; opacity:1; }
    }

    /* ── Subtitle ── */
    .subtitle {
      font-size: 1rem;
      font-weight: 500;
      color: var(--muted);
      margin-bottom: 2.5rem;
      animation: fadeUp 0.8s ease 0.2s both;
      transition: color 0.3s;
    }

    /* ── Arrow ── */
    .arrow-down {
      display: inline-block;
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 1rem;
      cursor: pointer;
      animation: bounce 1.5s ease-in-out infinite;
      transition: color 0.3s;
    }
    .arrow-down:hover { color: var(--primary-dark); }

    @keyframes bounce {
      0%,100% { transform:translateY(0);    }
      50%      { transform:translateY(10px); }
    }

    /* ── Click label ── */
    .click-text {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--muted);
      letter-spacing: 2px;
      margin-bottom: 1.8rem;
      animation: fadeIn 1s ease 0.4s both;
      transition: color 0.3s;
    }

    /* ── CTA button ── */
    .start-button {
      display: inline-flex;
      align-items: center;
      gap: 0.8rem;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #fff;
      padding: 1rem 2.8rem;
      border: none;
      border-radius: 3rem;
      font-family: 'Inter', sans-serif;
      font-size: 1.1rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      cursor: pointer;
      box-shadow: 0 5px 20px rgba(124,191,142,0.3);
      animation: fadeUp 0.8s ease 0.6s both;
      transition: all 0.35s ease;
    }
    .start-button:hover {
      background: linear-gradient(135deg, var(--primary-dark), #4a7c5a);
      transform: scale(1.05) translateY(-3px);
      box-shadow: 0 10px 30px rgba(124,191,142,0.4);
      gap: 1rem;
    }
    .start-button:active { transform: scale(0.98); }

    /* ── Dark mode toggle ── */
    .dark-toggle {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 1000;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      border: none;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #fff;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }
    .dark-toggle:hover {
      transform: scale(1.1);
      background: linear-gradient(135deg, var(--primary-dark), #4a7c5a);
    }

    /* ── Fade-out on navigate ── */
    body.fade-out { animation: fadeOut 0.5s ease forwards; }
    @keyframes fadeOut {
      from { opacity:1; transform:scale(1);    }
      to   { opacity:0; transform:scale(0.95); }
    }

    /* ── Shared keyframes ── */
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(30px); }
      to   { opacity:1; transform:translateY(0);    }
    }
    @keyframes fadeIn {
      from { opacity:0; }
      to   { opacity:1; }
    }

    /* ── Dark mode ── */
    body.dark-mode {
      --bg:     #1a2a1a;
      --card:   #243624;
      --text:   #e0f2e0;
      --muted:  #adc7a5;
      --border: #3c5a3a;
      --shadow: 0 8px 24px rgba(0,0,0,0.2);
      background: linear-gradient(135deg, #1a2a1a, #162116);
    }
    body.dark-mode .particle    { background: rgba(124,191,142,0.08); }
    body.dark-mode .dark-toggle { background: rgba(255,255,255,0.15); color: var(--primary); }

    /* ── Responsive ── */
    @media (max-width: 600px) {
      .welcome-container { padding: 1.5rem 2rem; margin: 1rem; }
      .welcome-text      { font-size: 2.8rem; }
      .arrow-down        { font-size: 2rem; }
      .start-button      { padding: 0.8rem 2rem; font-size: 1rem; }
      .dark-toggle       { width:40px; height:40px; font-size:1rem; bottom:20px; right:20px; }
      .logo              { font-size: 1rem; }
      .subtitle          { font-size: 0.85rem; }
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

  <div class="welcome-container">
    <div class="logo">GLOWUP</div>
    <div class="welcome-text">Welcome</div>
    <div class="decorative-line"></div>
    <div class="subtitle">Your journey to a better you starts here</div>
    <div class="arrow-down" onclick="goToHome()"><i class="fas fa-arrow-down"></i></div>
    <div class="click-text">CLICK TO CONTINUE</div>
    <button class="start-button" onclick="goToHome()">
      Get Started
    </button>
  </div>

  <button class="dark-toggle" onclick="toggleDark()">
    <i class="fas fa-moon" id="darkIcon"></i>
  </button>

  <script>
    // Doc 3 used home.php, Doc 2 used index.php — update to match your project
    function goToHome() {
      document.body.classList.add('fade-out');
      setTimeout(() => window.location.href = 'home.php', 500);
    }

    function toggleDark() {
      const isDark = document.body.classList.toggle('dark-mode');
      localStorage.setItem('glowDark', isDark);
      document.getElementById('darkIcon').className = isDark ? 'fas fa-sun' : 'fas fa-moon';
    }

    if (localStorage.getItem('glowDark') === 'true') {
      document.body.classList.add('dark-mode');
      document.getElementById('darkIcon').className = 'fas fa-sun';
    }
  </script>
</body>
</html>
