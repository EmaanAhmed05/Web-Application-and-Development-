<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlowUp · Transform Your Life</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            overflow-x: hidden;
            transition: background 0.3s ease;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background: linear-gradient(145deg, #1a1a2e 0%, #16213e 100%);
        }

        body.dark-mode .navbar {
            border-bottom-color: rgba(255,255,255,0.1);
        }

        body.dark-mode .logo {
            color: #4caf50;
        }

        body.dark-mode .nav-links a {
            color: #ffffff;
        }

        body.dark-mode .nav-links a:hover {
            color: #4caf50;
        }

        body.dark-mode .nav-btn {
            background: #4caf50;
        }

        body.dark-mode .hero-badge {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
        }

        body.dark-mode .hero-content h1 {
            color: #ffffff;
        }

        body.dark-mode .hero-content h1 span {
            color: #4caf50;
        }

        body.dark-mode .hero-tagline {
            color: #b0b0b0;
        }

        body.dark-mode .hero-description {
            color: #b0b0b0;
        }

        body.dark-mode .btn-start {
            background: rgba(76, 175, 80, 0.15);
            border-color: rgba(76, 175, 80, 0.3);
            color: #4caf50;
        }

        body.dark-mode .btn-signin {
            border-color: #4caf50;
            color: #4caf50;
        }

        body.dark-mode .btn-signin:hover {
            background: rgba(76, 175, 80, 0.1);
        }

        body.dark-mode .feature-card {
            background: #16213e;
            border-color: rgba(255,255,255,0.1);
        }

        body.dark-mode .feature-card h3 {
            color: #4caf50;
        }

        body.dark-mode .feature-card p {
            color: #b0b0b0;
        }

        body.dark-mode .stats {
            border-top-color: rgba(255,255,255,0.1);
        }

        body.dark-mode .stat-number {
            color: #4caf50;
        }

        body.dark-mode .stat-label {
            color: #b0b0b0;
        }

        body.dark-mode .dark-toggle {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            max-width: 1400px;
            margin: 0 auto;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: #2e5c2e;
            transition: color 0.3s ease;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #2e5c2e;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: #1b3b1b;
        }

        .nav-btn {
            background: #2e7d32;
            color: white !important;
            padding: 0.6rem 1.5rem;
            border-radius: 2rem;
        }

        .nav-btn:hover {
            background: #1b5e20;
        }

        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1300px;
            margin: 0 auto;
            padding: 3rem 5% 3rem;
            gap: 3rem;
            flex-wrap: wrap;
        }

        .hero-content {
            flex: 1;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(46, 125, 50, 0.1);
            color: #2e7d32;
            padding: 0.4rem 1rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: #1b3b1b;
            transition: color 0.3s ease;
        }

        .hero-content h1 span {
            color: #2e7d32;
            transition: color 0.3s ease;
        }

        .hero-tagline {
            font-size: 1.2rem;
            color: #3a6b3a;
            margin-bottom: 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .hero-description {
            color: #4a6b4a;
            line-height: 1.7;
            margin: 1.5rem 0 2rem;
            font-size: 1.05rem;
            max-width: 500px;
            transition: color 0.3s ease;
        }

        /* Button wrapper */
        .button-group {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        /* Start Button - VISUAL ONLY, NOT CLICKABLE */
        .btn-start {
            background: rgba(46, 125, 50, 0.1);
            border: 1px solid rgba(46, 125, 50, 0.3);
            color: #2e7d32;
            padding: 0.8rem 1.8rem;
            border-radius: 3rem;
            font-size: 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: default;
            transition: all 0.3s ease;
        }

        /* Sign In Button - CLICKABLE */
        .btn-signin {
            background: transparent;
            border: 2px solid #2e7d32;
            color: #2e7d32;
            padding: 0.8rem 1.8rem;
            border-radius: 3rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-signin:hover {
            background: rgba(46, 125, 50, 0.1);
            transform: translateY(-3px);
            gap: 0.8rem;
        }

        /* Right Side - Feature Cards */
        .hero-visual {
            flex: 1;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.2rem;
        }

        .feature-card {
            background: white;
            border-radius: 1.5rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e8f5e9;
            cursor: pointer;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: #2e7d32;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(46, 125, 50, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: #2e7d32;
        }

        .feature-icon i {
            font-size: 1.8rem;
            color: #2e7d32;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon i {
            color: white;
        }

        .feature-card h3 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #1b3b1b;
        }

        .feature-card p {
            font-size: 0.75rem;
            color: #6c8c72;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            max-width: 1000px;
            margin: 2rem auto 0;
            padding: 2rem 5%;
            border-top: 1px solid #c8e6c9;
            flex-wrap: wrap;
            gap: 2rem;
            transition: border-color 0.3s ease;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2e7d32;
            transition: color 0.3s ease;
        }

        .stat-label {
            color: #4a6b4a;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        /* Dark Mode Toggle Button */
        .dark-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2e7d32;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            font-size: 1.2rem;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .dark-toggle:hover {
            transform: scale(1.1);
            background: #1b5e20;
        }

        @media (max-width: 900px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }
            .hero-content h1 {
                font-size: 2.5rem;
            }
            .hero-description {
                max-width: 100%;
            }
            .button-group {
                justify-content: center;
            }
            .navbar {
                flex-direction: column;
                gap: 1rem;
            }
            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            .feature-grid {
                grid-template-columns: 1fr;
            }
            .dark-toggle {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">✨ GlowUp</div>
    <div class="nav-links">
        <a href="#">Home</a>
        <a href="#">Features</a>
        <a href="pages/about.php">About</a>
        <a href="auth/login.php" class="nav-btn">Sign In</a>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <span class="hero-badge">✨ Transform Your Life. One Day at a Time</span>
        <h1>Your Ultimate <span>GlowUp Journey</span></h1>
        <p class="hero-tagline">Track your habits, monitor your progress</p>
        <p class="hero-description">
            Track your habits, monitor your progress, and achieve your self-improvement goals 
            with our beautiful and intuitive platform.
        </p>
        
        <!-- Two buttons: Start Your Glow Up (NOT clickable) and Sign In (clickable) -->
        <div class="button-group">
            <div class="btn-start">
                Start Your Glow Up <i class="fas fa-arrow-right"></i>
            </div>
            <a href="auth/login.php" class="btn-signin">
                Sign In <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Right Side - Feature Cards -->
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

<!-- Dark Mode Toggle Button -->
<button class="dark-toggle" onclick="toggleDarkMode()">
    <i class="fas fa-moon"></i>
</button>

<script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('homeDarkMode', isDark);
        const btn = document.querySelector('.dark-toggle i');
        if(isDark) {
            btn.className = 'fas fa-sun';
        } else {
            btn.className = 'fas fa-moon';
        }
    }

    // Load saved dark mode
    const savedDark = localStorage.getItem('homeDarkMode');
    if(savedDark === 'true') {
        document.body.classList.add('dark-mode');
        document.querySelector('.dark-toggle i').className = 'fas fa-sun';
    }
</script>

</body>
</html>
