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
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: #2e5c2e;
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
            padding: 3rem 5% 5rem;
            gap: 3rem;
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
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: #1b3b1b;
        }

        .hero-content h1 span {
            color: #2e7d32;
        }

        .hero-tagline {
            font-size: 1.2rem;
            color: #3a6b3a;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .hero-description {
            color: #4a6b4a;
            line-height: 1.7;
            margin: 1.5rem 0 2rem;
            font-size: 1.05rem;
            max-width: 500px;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #2e7d32;
            color: white;
            border: none;
            padding: 1rem 2.2rem;
            border-radius: 3rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #1b5e20;
            transform: translateY(-3px);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid #2e7d32;
            color: #2e7d32;
            padding: 0.9rem 2rem;
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

        .btn-secondary:hover {
            background: rgba(46, 125, 50, 0.1);
            transform: translateY(-3px);
        }

        .hero-visual {
            flex: 1;
        }

        .glow-card-demo {
            background: white;
            border-radius: 2rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid #c8e6c9;
        }

        .demo-task {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            margin: 0.5rem 0;
            background: #f1f8e9;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .demo-task:hover {
            background: #e8f5e9;
            transform: translateX(8px);
        }

        .demo-check {
            width: 24px;
            height: 24px;
            background: #2e7d32;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.7rem;
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
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2e7d32;
        }

        .stat-label {
            color: #4a6b4a;
            font-size: 0.9rem;
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
            .hero-buttons {
                justify-content: center;
            }
            .navbar {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2rem;
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
        <div class="hero-buttons">
            <a href="auth/signup.php" class="btn-primary">
                Start Your Glow Up <i class="fas fa-arrow-right"></i>
            </a>
            <a href="auth/login.php" class="btn-secondary">
                Sign In <i class="fas fa-user"></i>
            </a>
        </div>
    </div>
    
    <div class="hero-visual">
        <div class="glow-card-demo">
            <div class="demo-task">
                <div class="demo-check">✓</div>
                <span style="flex:1; margin-left: 1rem;">Morning meditation 🧘</span>
                <small style="color:#2e7d32;">🔥 7 day streak</small>
            </div>
            <div class="demo-task">
                <div class="demo-check">✓</div>
                <span style="flex:1; margin-left: 1rem;">Drink 2L water 💧</span>
                <small style="color:#2e7d32;">Completed today</small>
            </div>
            <div class="demo-task">
                <div style="width:24px;"></div>
                <span style="flex:1; margin-left: 1rem;">Read 20 mins 📚</span>
                <small style="color:#888;">In progress</small>
            </div>
            <div class="demo-task">
                <div style="width:24px;"></div>
                <span style="flex:1; margin-left: 1rem;">Workout 💪</span>
                <small style="color:#2e7d32;">⚡ Due today</small>
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
        <div class="stat-label">Habit Success Rate</div>
    </div>
</div>

</body>
</html>
