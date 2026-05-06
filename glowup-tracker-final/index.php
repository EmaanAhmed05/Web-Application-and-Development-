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
            position: relative;
            overflow: hidden;
        }

        /* Background Circles */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(46, 125, 50, 0.1);
            pointer-events: none;
            animation: float 20s infinite ease-in-out;
        }

        .circle1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .circle2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            animation-delay: 2s;
        }

        .circle3 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 10%;
            animation-delay: 4s;
        }

        .circle4 {
            width: 250px;
            height: 250px;
            bottom: 20%;
            right: 15%;
            animation-delay: 6s;
        }

        .circle5 {
            width: 100px;
            height: 100px;
            top: 20%;
            right: 30%;
            animation-delay: 1s;
        }

        .circle6 {
            width: 180px;
            height: 180px;
            bottom: 10%;
            left: 20%;
            animation-delay: 3s;
        }

        .circle7 {
            width: 80px;
            height: 80px;
            top: 60%;
            right: 5%;
            animation-delay: 5s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-20px) rotate(5deg);
            }
            75% {
                transform: translateY(20px) rotate(-5deg);
            }
        }

        /* Welcome Container */
        .welcome-container {
            text-align: center;
            z-index: 10;
            position: relative;
        }

        .welcome-text {
            font-size: 4rem;
            font-weight: 800;
            color: #2e5c2e;
            margin-bottom: 3rem;
            animation: fadeInUp 0.8s ease;
            text-shadow: 2px 2px 10px rgba(46, 125, 50, 0.2);
        }

        /* Arrow (pointing down) */
        .arrow-down {
            font-size: 3rem;
            color: #2e7d32;
            animation: bounce 1.5s infinite;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .arrow-down i {
            font-size: 3rem;
        }

        /* Click here text */
        .click-text {
            font-size: 0.9rem;
            color: #4a6b4a;
            margin-bottom: 1.5rem;
            font-weight: 500;
            animation: fadeIn 1s ease;
        }

        /* Start Button */
        .start-button {
            background: #2e7d32;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 3rem;
            font-size: 1.3rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            animation: fadeInUp 0.8s ease 0.2s both;
            box-shadow: 0 5px 20px rgba(46, 125, 50, 0.3);
            border: none;
            font-family: 'Inter', sans-serif;
            display: inline-block;
        }

        .start-button:hover {
            background: #1b5e20;
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(46, 125, 50, 0.4);
        }

        .start-button:active {
            transform: scale(0.98);
        }

        /* Fade out animation for page transition */
        body.fade-out {
            animation: fadeOut 0.5s ease forwards;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
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
                transform: translateY(12px);
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
                font-size: 2.5rem;
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

    <div class="welcome-container">
        <div class="welcome-text">
            Welcome
        </div>

        <!-- Arrow pointing down (not clickable, just pointing) -->
        <div class="arrow-down">
            <i class="fas fa-arrow-down"></i>
        </div>

        <!-- Click here text -->
        <div class="click-text">
            click here to continue 
        </div>

        <!-- Start Button -->
        <button class="start-button" onclick="goToHome()">
            Start
        </button>
    </div>

    <script>
        function goToHome() {
            document.body.classList.add('fade-out');
            setTimeout(function() {
                window.location.href = 'home.php';
            }, 500);
        }
    </script>

</body>
</html>
