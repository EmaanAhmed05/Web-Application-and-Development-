<?php include '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>About Us - GlowUp Team</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        :root{
            --primary:#7CBF8E;
            --primary-dark:#5E9F71;
            --primary-light:#DCEEDF;
            --bg:#F4FAF4;
            --card:#FCFEFC;
            --sidebar:#EAF5EA;
            --text:#23412E;
            --muted:#6F8B77;
            --border:#D8E8DA;
            --shadow:0 10px 30px rgba(124,191,142,0.12);
        }

        /* DARK MODE VARIABLES */
        body.dark-mode {
            --bg: #1a2a1a;
            --card: #243624;
            --sidebar: #1e2e1e;
            --text: #e0f2e0;
            --muted: #adc7a5;
            --border: #3c5a3a;
            --shadow: 0 8px 24px rgba(0,0,0,0.2);
            background: linear-gradient(135deg, #1a2a1a, #162116);
        }

        body{
            font-family:'Inter',sans-serif;
            background:linear-gradient(135deg,var(--bg),#EEF7EF);
            color:var(--text);
            min-height:100vh;
            transition: background 0.3s, color 0.2s;
        }

        .container{
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR */
        .sidebar{
            width:280px;
            background:var(--sidebar);
            backdrop-filter:blur(10px);
            position:fixed;
            height:100vh;
            padding-top:10px;
            border-right:1px solid var(--border);
            box-shadow:4px 0 20px rgba(0,0,0,0.03);
            z-index:100;
            transition: background 0.3s;
        }

        .sidebar h2{
            font-size:2rem;
            font-weight:800;
            padding:25px 25px 20px;
            color:var(--primary-dark);
            letter-spacing:-1px;
            border-bottom:1px solid var(--border);
        }

        .sidebar nav{
            margin-top:20px;
        }

        /* Unified link & button styles in sidebar */
        .sidebar a,
        .sidebar .dark-mode-btn {
            display:flex;
            align-items:center;
            gap:14px;
            text-decoration:none;
            color:var(--text);
            margin:10px 15px;
            padding:14px 18px;
            border-radius:16px;
            transition:0.3s ease;
            font-weight:600;
            background: none;
            border: none;
            width: calc(100% - 30px);
            cursor: pointer;
            font-family: inherit;
            font-size: inherit;
        }

        .sidebar a i,
        .sidebar .dark-mode-btn i {
            width:20px;
            font-size:1rem;
        }

        .sidebar a:hover,
        .sidebar .dark-mode-btn:hover {
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            color:white;
            transform:translateX(5px);
            box-shadow:0 8px 18px rgba(124,191,142,0.25);
        }

        .sidebar a.active {
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            color:white;
            transform:translateX(5px);
            box-shadow:0 8px 18px rgba(124,191,142,0.25);
        }

        .logout {
            margin-top:20px;
            border-top:1px solid var(--border);
            padding-top:15px;
        }

        /* MAIN */
        .main{
            flex:1;
            margin-left:280px;
            padding:40px;
        }

        /* HERO SECTION */
        .hero-section{
            background:linear-gradient(135deg,#E9F5EA,#F8FCF8);
            border:1px solid var(--border);
            border-radius:32px;
            padding:70px 50px;
            text-align:center;
            position:relative;
            overflow:hidden;
            box-shadow:var(--shadow);
            margin-bottom:35px;
            transition: background 0.3s, border 0.3s;
        }
        body.dark-mode .hero-section {
            background: linear-gradient(135deg, #2a3a2a, #1e2e1e);
        }

        .hero-section::before{
            content:'';
            position:absolute;
            width:250px;
            height:250px;
            background:rgba(124,191,142,0.12);
            border-radius:50%;
            top:-100px;
            right:-70px;
        }

        .hero-section::after{
            content:'';
            position:absolute;
            width:180px;
            height:180px;
            background:rgba(124,191,142,0.08);
            border-radius:50%;
            bottom:-80px;
            left:-60px;
        }

        .hero-icon{
            width:95px;
            height:95px;
            margin:0 auto 25px;
            border-radius:28px;
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            display:flex;
            align-items:center;
            justify-content:center;
            color:white;
            font-size:2.5rem;
            box-shadow:0 15px 30px rgba(124,191,142,0.3);
            position:relative;
            z-index:2;
        }

        .hero-section h1{
            font-size:4rem;
            font-weight:800;
            color:#2D6A3F;
            margin-bottom:20px;
            position:relative;
            z-index:2;
            letter-spacing:-2px;
        }
        body.dark-mode .hero-section h1 {
            color: #c8e6c9;
        }

        .hero-section p{
            max-width:850px;
            margin:auto;
            font-size:1.25rem;
            line-height:1.8;
            color:#5E7D66;
            position:relative;
            z-index:2;
        }
        body.dark-mode .hero-section p {
            color: #adc7a5;
        }

        /* MISSION CARD */
        .mission-card{
            background:var(--card);
            backdrop-filter:blur(10px);
            border:1px solid var(--border);
            border-radius:30px;
            padding:40px;
            box-shadow:var(--shadow);
            margin-bottom:40px;
            transition: background 0.3s, border 0.3s;
        }

        .mission-card h2{
            font-size:2.3rem;
            margin-bottom:20px;
            color:#2D6A3F;
            font-weight:800;
        }
        body.dark-mode .mission-card h2 {
            color: #c8e6c9;
        }

        .mission-card p{
            font-size:1.08rem;
            line-height:1.9;
            color:#6A8470;
        }
        body.dark-mode .mission-card p {
            color: #adc7a5;
        }

        /* TEAM TITLE */
        .team-header{
            margin-bottom:25px;
        }

        .team-header h2{
            font-size:2.4rem;
            color:#2D6A3F;
            margin-bottom:10px;
            font-weight:800;
        }
        body.dark-mode .team-header h2 {
            color: #c8e6c9;
        }

        .team-header p{
            color:#6F8B77;
            font-size:1rem;
        }
        body.dark-mode .team-header p {
            color: #adc7a5;
        }

        /* PROFILE GRID */
        .profiles{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
            gap:25px;
        }

        /* KEEP PORTFOLIOS SAME */
        .profile-card{
            background:var(--card);
            border-radius:28px;
            padding:28px 22px;
            text-align:center;
            border:1px solid var(--border);
            transition:0.35s ease;
            cursor:pointer;
            position:relative;
            overflow:hidden;
            box-shadow:0 6px 20px rgba(0,0,0,0.04);
        }

        .profile-card:hover{
            transform:translateY(-8px);
            box-shadow:0 18px 35px rgba(124,191,142,0.15);
        }

        .avatar{
            width:90px;
            height:90px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 18px;
            color:white;
            font-size:2.3rem;
            font-weight:700;
            box-shadow:0 10px 25px rgba(0,0,0,0.12);
        }

        /* Portfolio avatar colors unchanged */
        .profile-card:nth-child(1) .avatar { background: linear-gradient(135deg, #22c55e, #14532d); }
        .profile-card:nth-child(2) .avatar { background: linear-gradient(135deg, #10b981, #047857); }
        .profile-card:nth-child(3) .avatar { background: linear-gradient(135deg, #84cc16, #3f6212); }
        .profile-card:nth-child(4) .avatar { background: linear-gradient(135deg, #2dd4bf, #115e59); }

        .profile-card h3{
            font-size:1.15rem;
            margin-bottom:8px;
            color:var(--text);
        }

        .role-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            background:#E8F6EA;
            color:#2D6A3F;
            padding:7px 16px;
            border-radius:999px;
            font-size:0.75rem;
            font-weight:700;
            margin-bottom:12px;
        }
        body.dark-mode .role-badge {
            background: #3c5a3a;
            color: #c8e6c9;
        }

        .bio-mini{
            color:#708878;
            line-height:1.7;
            font-size:0.88rem;
            margin-bottom:18px;
        }
        body.dark-mode .bio-mini {
            color: #adc7a5;
        }

        .social-icons{
            display:flex;
            justify-content:center;
            gap:14px;
            margin-bottom:18px;
        }

        .social-icons i{
            width:38px;
            height:38px;
            border-radius:50%;
            background:#F1F8F2;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#5E7D66;
            transition:0.3s ease;
        }
        body.dark-mode .social-icons i {
            background: #3c5a3a;
            color: #adc7a5;
        }

        .social-icons i:hover{
            background:var(--primary);
            color:white;
            transform:translateY(-3px);
        }

        .portfolio-btn{
            border:none;
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            color:white;
            padding:12px 22px;
            border-radius:14px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s ease;
            display:inline-flex;
            align-items:center;
            gap:8px;
        }

        .portfolio-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 12px 20px rgba(124,191,142,0.25);
        }

        /* FOOTER */
        .footer{
            text-align:center;
            padding:30px 10px 10px;
            color:#78907E;
            font-size:0.9rem;
        }
        body.dark-mode .footer {
            color: #adc7a5;
        }

        .footer i{
            color:var(--primary-dark);
        }

        /* RESPONSIVE */
        @media(max-width:900px){
            .sidebar{
                width:100%;
                height:auto;
                position:relative;
            }

            .main{
                margin-left:0;
                padding:25px;
            }

            .container{
                flex-direction:column;
            }

            .hero-section h1{
                font-size:2.8rem;
            }
        }

        @media(max-width:600px){
            .hero-section{
                padding:50px 25px;
            }

            .hero-section h1{
                font-size:2.2rem;
            }

            .hero-section p{
                font-size:1rem;
            }

            .mission-card{
                padding:28px 22px;
            }

            .main{
                padding:18px;
            }
        }

        /* =========================
   GLOBAL ANIMATIONS
========================= */

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0px); }
}

/* HERO ANIMATION */
.hero-section {
    animation: fadeUp 0.9s ease forwards;
}

/* SIDEBAR ANIMATION */
.sidebar {
    animation: slideInLeft 0.7s ease forwards;
}

/* MISSION CARD */
.mission-card {
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 0.2s;
}

/* TEAM HEADER */
.team-header {
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 0.3s;
}

/* PROFILE CARDS INITIAL STATE */
.profile-card {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.4s ease;
}

/* WHEN VISIBLE */
.profile-card.show {
    opacity: 1;
    transform: translateY(0);
}

/* STAGGER EFFECT */
.profile-card:nth-child(1) { transition-delay: 0.1s; }
.profile-card:nth-child(2) { transition-delay: 0.2s; }
.profile-card:nth-child(3) { transition-delay: 0.3s; }
.profile-card:nth-child(4) { transition-delay: 0.4s; }

/* FLOATING HERO SHAPES */
.hero-section::before,
.hero-section::after {
    animation: float 6s ease-in-out infinite;
}

.social-icons a {
  text-decoration: none;
}

/* BUTTON PULSE ON HOVER */
.portfolio-btn:hover {
    animation: pulse 1.2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(124,191,142,0.4); }
    70% { box-shadow: 0 0 0 15px rgba(124,191,142,0); }
    100% { box-shadow: 0 0 0 0 rgba(124,191,142,0); }
}
    </style>
</head>
<body>

<div class="container">

    <aside class="sidebar">
        <h2>GlowUp</h2>

        <nav>
            <a href="dashboard.php">
                <i class="fas fa-chart-line"></i>
                Dashboard
            </a>

            <a href="about.php" class="active">
                <i class="fas fa-users"></i>
                About
            </a>

            <!-- Dark Mode Toggle Button (styled exactly like sidebar links) -->
            <button class="dark-mode-btn" id="darkModeToggle">
                <i class="fas fa-moon"></i>
                <span>Dark Mode</span>
            </button>

            <a href="../auth/logout.php" class="logout">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </nav>
    </aside>

    <main class="main">

        <!-- HERO -->
        <section class="hero-section">
            <h1>About GlowUp Tracker</h1>

            <p>
                We're on a mission to make self-improvement accessible, enjoyable,
                and sustainable for everyone. One habit at a time, we're helping
                you become the best version of yourself.
            </p>
        </section>

        <!-- MISSION -->
        <section class="mission-card">
            <h2>Our Mission</h2>

            <p>
                To empower individuals on their self-improvement journey by
                providing intuitive tools that track progress, celebrate wins,
                and make healthy habits effortless.
            </p>
        </section>

        <!-- VISION -->
        <section class="mission-card">
            <h2>Our Vision</h2>

            <p>
                A world where everyone has the tools and support they need to live their healthiest, happiest, and most fulfilling life.
            </p>
        </section>

        <!-- TEAM -->
        <div class="team-header">
            <h2>Meet Our Team</h2>
            <p>The minds behind GlowUp Tracker</p>
        </div>

        <div class="profiles">

            <!-- AYESHA -->
            <div class="profile-card" onclick="window.open('../ayesha-portfolio.html', '_blank')">
                <div class="avatar">A</div>
                <h3>Ayesha Zaheed</h3>

                <div class="role-badge">
                    <i class="fas fa-database"></i>
                    Backend Architect
                </div>

                <div class="bio-mini">
                    Scalable APIs • Database whisperer • PHP & Python artisan
                </div><br>

                <div class="social-icons" onclick="event.stopPropagation()">
    <a href="https://instagram.com/ayesha_zaheed" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-instagram"></i>
    </a>
    <a href="https://github.com/Ayesha3137" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-github"></i>
    </a>
    <a href="mailto:zaheedayesha@gmail.com" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-envelope"></i>
    </a>
</div>

                <button class="portfolio-btn" onclick="event.stopPropagation(); window.open('../ayesha-portfolio.html', '_blank')">
                    <i class="fas fa-briefcase"></i>
                    View Portfolio
                </button>
            </div>

            <!-- EMAN -->
            <div class="profile-card" onclick="window.open('../eman-portfolio.html', '_blank')">
                <div class="avatar">E</div>
                <h3>Eman Iftikhar Ahmed</h3>

                <div class="role-badge">
                    <i class="fas fa-code-branch"></i>
                    Backend Engineer
                </div>

                <div class="bio-mini">
                    Microservices • Security • High-performance systems
                </div><br>

                <div class="social-icons" onclick="event.stopPropagation()">
    <a href="https://www.linkedin.com/in/emaan-iftikhar-ahmed/" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-linkedin"></i>
    </a>
    <a href="https://github.com/EmaanAhmed05" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-github"></i>
    </a>
    <a href="mailto:mailto:emaanahmed662@gmail.com" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-envelope"></i>
    </a>
</div>

                <button class="portfolio-btn" onclick="event.stopPropagation(); window.open('../eman-portfolio.html', '_blank')">
                    <i class="fas fa-briefcase"></i>
                    View Portfolio
                </button>
            </div>

            <!-- AREEBA -->
            <div class="profile-card" onclick="window.open('../areeba-portfolio.html', '_blank')">
                <div class="avatar">S</div>
                <h3>Syeda Areeba Naqvi</h3>

                <div class="role-badge">
                    <i class="fas fa-palette"></i>
                    Frontend Lead
                </div>

                <div class="bio-mini">
                    UI/UX magic • Responsive design • React/Vue enthusiast
                </div><br>

                 <div class="social-icons" onclick="event.stopPropagation()">
    <a href="https://www.instagram.com/anthophile.2702" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-instagram"></i>
    </a>
    <a href="mailto:areeba.naqv1@gmail.com" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-envelope"></i>
    </a>
    <a href="tel:+923328910558" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-phone-alt"></i>
    </a>
</div>

                <button class="portfolio-btn" onclick="event.stopPropagation(); window.open('../areeba-portfolio.html', '_blank')">
                    <i class="fas fa-briefcase"></i>
                    View Portfolio
                </button>
            </div>

            <!-- MAHNOOR -->
            <div class="profile-card" onclick="window.open('../mahnoor-portfolio.html', '_blank')">
                <div class="avatar">M</div>
                <h3>Mahnoor Zahid</h3>

                <div class="role-badge">
                    <i class="fas fa-laptop-code"></i>
                    Frontend Developer
                </div>

                <div class="bio-mini">
                    Interactive animations • Accessibility • Pixel-perfect crafts
                </div><br>

                <div class="social-icons" onclick="event.stopPropagation()">
    <a href="https://www.linkedin.com/in/mahnoor-zahid-028881355?utm_source=share_via&utm_content=profile&utm_medium=member_android" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-linkedin"></i>
    </a>
    <a href="https://github.com/EmaanAhmed05/Web-Application-and-Development-" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-github"></i>
    </a>
    <a href="https://www.instagram.com/k.khan_iii" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-instagram"></i>
    </a>
</div>

                <button class="portfolio-btn" onclick="event.stopPropagation(); window.open('../mahnoor-portfolio.html', '_blank')">
                    <i class="fas fa-briefcase"></i>
                    View Portfolio
                </button>
            </div>
        </div>

        <div class="footer">
            GlowUp <i class="fas fa-heart"></i> Designed with passion
        </div>

    </main>
</div>

<script>
    // Smooth scroll reveal for profile cards
    const cards = document.querySelectorAll('.profile-card');

    const observer = new IntersectionObserver(entries => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('show');
                }, index * 120);
            }
        });
    }, {
        threshold: 0.2
    });

    cards.forEach(card => {
        observer.observe(card);
    });

    // Dark Mode Toggle - styled like sidebar links
    const toggleBtn = document.getElementById('darkModeToggle');
    const iconSpan = toggleBtn.querySelector('i');
    const textSpan = toggleBtn.querySelector('span');

    function applyDarkMode(isDark) {
        if (isDark) {
            document.body.classList.add('dark-mode');
            iconSpan.className = 'fas fa-sun';
            textSpan.innerText = 'Light Mode';
        } else {
            document.body.classList.remove('dark-mode');
            iconSpan.className = 'fas fa-moon';
            textSpan.innerText = 'Dark Mode';
        }
        localStorage.setItem('aboutDarkMode', isDark);
    }

    toggleBtn.addEventListener('click', () => {
        const willBeDark = !document.body.classList.contains('dark-mode');
        applyDarkMode(willBeDark);
    });

    // Load saved preference
    const savedDark = localStorage.getItem('aboutDarkMode') === 'true';
    if (savedDark) applyDarkMode(true);
</script>

</body>
</html>
