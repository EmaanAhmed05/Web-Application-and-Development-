<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome · GlowUp</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(46, 125, 50, 0.15);
            pointer-events: none;
            animation: float 15s infinite ease-in-out;
        }

        .particle:nth-child(1) { width: 300px; height: 300px; top: -100px; left: -100px; animation-delay: 0s; }
        .particle:nth-child(2) { width: 200px; height: 200px; bottom: -50px; right: -50px; animation-delay: 2s; }
        .particle:nth-child(3) { width: 150px; height: 150px; top: 50%; left: 10%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 250px; height: 250px; bottom: 20%; right: 15%; animation-delay: 6s; }
        .particle:nth-child(5) { width: 100px; height: 100px; top: 20%; right: 30%; animation-delay: 1s; }
        .particle:nth-child(6) { width: 180px; height: 180px; bottom: 10%; left: 20%; animation-delay: 3s; }
        .particle:nth-child(7) { width: 80px; height: 80px; top: 60%; right: 5%; animation-delay: 5s; }
        .particle:nth-child(8) { width: 120px; height: 120px; top: 80%; left: 40%; animation-delay: 7s; }
        .particle:nth-child(9) { width: 60px; height: 60px; bottom: 40%; left: 60%; animation-delay: 2.5s; }
        .particle:nth-child(10) { width: 90px; height: 90px; top: 10%; left: 80%; animation-delay: 8s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            75% { transform: translateY(20px) rotate(-5deg); }
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background: linear-gradient(145deg, #1a1a2e 0%, #16213e 100%);
        }

        body.dark-mode .welcome-text {
            color: #4caf50;
        }

        body.dark-mode .arrow-down {
            color: #4caf50;
        }

        body.dark-mode .click-text {
            color: #b0b0b0;
        }

        body.dark-mode .start-button {
            background: #4caf50;
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.3);
        }

        body.dark-mode .start-button:hover {
            background: #2e7d32;
        }

        body.dark-mode .particle {
            background: rgba(76, 175, 80, 0.08);
        }

        body.dark-mode .dark-toggle {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        body.dark-mode .decorative-line {
            background: #4caf50;
        }

        /* Welcome Container */
        .welcome-container {
            text-align: center;
            z-index: 10;
            position: relative;
            animation: containerFadeIn 1s ease;
        }

        @keyframes containerFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Logo */
        .logo {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2e7d32;
            margin-bottom: 2rem;
            letter-spacing: 2px;
            opacity: 0.8;
            animation: fadeInUp 0.6s ease;
        }

        /* Welcome Text */
        .welcome-text {
            font-size: 4.5rem;
            font-weight: 800;
            color: #2e5c2e;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease;
            text-shadow: 2px 2px 10px rgba(46, 125, 50, 0.2);
            transition: color 0.3s ease;
            letter-spacing: -0.02em;
        }

        /* Decorative Line */
        .decorative-line {
            width: 60px;
            height: 3px;
            background: #2e7d32;
            margin: 1rem auto;
            border-radius: 3px;
            animation: widthGrow 0.8s ease 0.3s both;
        }

        @keyframes widthGrow {
            from {
                width: 0;
                opacity: 0;
            }
            to {
                width: 60px;
                opacity: 1;
            }
        }

        /* Subtitle */
        .subtitle {
            font-size: 1rem;
            color: #4a6b4a;
            margin-bottom: 2.5rem;
            animation: fadeInUp 0.8s ease 0.2s both;
            transition: color 0.3s ease;
        }

        /* Arrow */
        .arrow-down {
            font-size: 2.5rem;
            color: #2e7d32;
            animation: bounce 1.5s infinite;
            margin-bottom: 1rem;
            display: inline-block;
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .arrow-down i {
            font-size: 2.5rem;
        }

        /* Click Text */
        .click-text {
            font-size: 0.85rem;
            color: #4a6b4a;
            margin-bottom: 1.8rem;
            font-weight: 500;
            animation: fadeIn 1s ease 0.4s both;
            transition: color 0.3s ease;
            letter-spacing: 1px;
        }

        /* Start Button */
        .start-button {
            background: #2e7d32;
            color: white;
            padding: 1rem 2.8rem;
            border-radius: 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            animation: fadeInUp 0.8s ease 0.6s both;
            box-shadow: 0 5px 20px rgba(46, 125, 50, 0.3);
            border: none;
            font-family: 'Inter', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            letter-spacing: 0.5px;
        }

        .start-button:hover {
            background: #1b5e20;
            transform: scale(1.05) translateY(-3px);
            box-shadow: 0 10px 30px rgba(46, 125, 50, 0.4);
            gap: 1rem;
        }

        .start-button:active {
            transform: scale(0.98);
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

        /* Fade out animation */
        body.fade-out {
            animation: fadeOut 0.5s ease forwards;
        }

        /* Animations */
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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(10px);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }
            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }

        /* Responsive */
        @media (max-width: 600px) {
            .welcome-text {
                font-size: 2.8rem;
            }
            .arrow-down {
                font-size: 2rem;
            }
            .arrow-down i {
                font-size: 2rem;
            }
            .start-button {
                padding: 0.8rem 2rem;
                font-size: 1rem;
            }
            .dark-toggle {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                bottom: 20px;
                right: 20px;
            }
            .logo {
                font-size: 1rem;
            }
            .subtitle {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

    <!-- Animated Background Particles -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <div class="welcome-container">
        <div class="logo">
            ✨ GLOWUP
        </div>
        
        <div class="welcome-text">
            Welcome
        </div>
        
        <div class="decorative-line"></div>
        
        <div class="subtitle">
            Your journey to a better you starts here
        </div>

        <!-- Arrow pointing down -->
        <div class="arrow-down" onclick="goToHome()">
            <i class="fas fa-arrow-down"></i>
        </div>

        <!-- Click text -->
        <div class="click-text">
            CLICK TO CONTINUE
        </div>

        <!-- Start Button -->
        <button class="start-button" onclick="goToHome()">
            Get Started <i class="fas fa-rocket"></i>
        </button>
    </div>

    <!-- Dark Mode Toggle Button -->
    <button class="dark-toggle" onclick="toggleDarkMode()">
        <i class="fas fa-moon"></i>
    </button>

    <script>
        function goToHome() {
            document.body.classList.add('fade-out');
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 500);
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('welcomeDarkMode', isDark);
            const btn = document.querySelector('.dark-toggle i');
            if(isDark) {
                btn.className = 'fas fa-sun';
            } else {
                btn.className = 'fas fa-moon';
            }
        }

        // Load saved dark mode
        const savedDark = localStorage.getItem('welcomeDarkMode');
        if(savedDark === 'true') {
            document.body.classList.add('dark-mode');
            document.querySelector('.dark-toggle i').className = 'fas fa-sun';
        }
    </script>

</body>
</html>
