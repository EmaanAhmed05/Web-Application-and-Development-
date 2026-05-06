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
        }

        .welcome-container {
            text-align: center;
        }

        .welcome-text {
            font-size: 4rem;
            font-weight: 800;
            color: #2e5c2e;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease;
        }

        .arrow {
            font-size: 3rem;
            color: #2e7d32;
            cursor: pointer;
            display: inline-block;
            animation: bounce 1.5s infinite;
            transition: all 0.3s ease;
        }

        .arrow:hover {
            transform: scale(1.2);
            color: #1b5e20;
        }

        .arrow i {
            font-size: 3rem;
        }

        .click-hint {
            margin-top: 2rem;
            font-size: 0.8rem;
            color: #4a6b4a;
        }

        body.fade-out {
            animation: fadeOut 0.5s ease forwards;
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

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(15px); }
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

        @media (max-width: 600px) {
            .welcome-text { font-size: 2.5rem; }
            .arrow { font-size: 2rem; }
            .arrow i { font-size: 2rem; }
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <div class="welcome-text">
        Welcome
    </div>
    <div class="arrow" onclick="goToHome()">
        <i class="fas fa-arrow-down"></i>
    </div>
    <div class="click-hint">
        Click the arrow to continue ↓
    </div>
</div>

<script>
    function goToHome() {
        document.body.classList.add('fade-out');
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 500);
    }
</script>

</body>
</html>
