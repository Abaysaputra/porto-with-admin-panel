<?php
/**
 * Admin Login Page
 * File: admin/login/index.php
 */

require_once '../../includes/auth.php';

// If already logged in, redirect to dashboard
if (isLoggedIn()) {
    header('Location: ../index.php');
    exit;
}

$error = '';
$success = '';

// Handle logout message
if (isset($_GET['msg']) && $_GET['msg'] === 'logout') {
    $success = 'Logged out successfully';
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        $result = loginUser($email, $password);
        
        if ($result['success']) {
            // Check for redirect parameter
            $redirect = $_GET['redirect'] ?? '../index.php';
            header('Location: ' . $redirect);
            exit;
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Login Portal">
    <meta name="author" content="Portfolio Admin">
    <title>Admin Login - Portfolio Management</title>

    <!-- Bootstrap CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-yellow: #FFD600;
            --accent-orange: #FFC107;
            --primary-dark: #1a1a1a;
            --text-dark: #212529;
            --bg-light: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Particles */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,214,0,0.15) 0%, transparent 70%);
            animation: float 15s ease-in-out infinite;
        }

        body::before {
            width: 500px;
            height: 500px;
            top: -250px;
            right: -250px;
            animation-delay: 0s;
        }

        body::after {
            width: 400px;
            height: 400px;
            bottom: -200px;
            left: -200px;
            animation-delay: 7s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            25% {
                transform: translate(30px, -30px) scale(1.1);
                opacity: 0.5;
            }
            50% {
                transform: translate(-20px, 20px) scale(0.9);
                opacity: 0.4;
            }
            75% {
                transform: translate(40px, 10px) scale(1.05);
                opacity: 0.6;
            }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 380px;
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.4);
            overflow: hidden;
            animation: slideUpBounce 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideUpBounce {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            60% {
                opacity: 1;
                transform: translateY(-5px) scale(1.02);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-orange) 100%);
            padding: 35px 25px 30px;
            text-align: center;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 18px;
            background: #fff;
            border-radius: 18px 18px 0 0;
        }

        .login-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.35);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            backdrop-filter: blur(10px);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255,255,255,0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(255,255,255,0);
            }
        }

        .login-icon i {
            font-size: 36px;
            color: var(--primary-dark);
        }

        .login-header h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 0.9rem;
            color: rgba(26,26,26,0.75);
            margin: 5px 0 0;
            font-weight: 500;
        }

        .login-body {
            padding: 35px 30px 25px;
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success-custom {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger-custom {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-custom i {
            font-size: 22px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 19px;
            color: #999;
            z-index: 2;
            transition: all 0.3s;
        }

        .form-control-custom {
            width: 100%;
            padding: 13px 18px 13px 46px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--primary-yellow);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255,214,0,0.12);
        }

        .form-control-custom:focus ~ .input-icon {
            color: var(--primary-yellow);
            transform: translateY(-50%) scale(1.1);
        }

        .form-control-custom::placeholder {
            color: #adb5bd;
        }

        .checkbox-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }

        .checkbox-custom input[type="checkbox"] {
            width: 17px;
            height: 17px;
            cursor: pointer;
            accent-color: var(--primary-yellow);
        }

        .checkbox-custom label {
            font-size: 0.9rem;
            color: #6c757d;
            cursor: pointer;
            margin: 0;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-orange) 100%);
            border: none;
            border-radius: 10px;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--primary-dark);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255,214,0,0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255,214,0,0.45);
        }

        .btn-login:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(255,214,0,0.35);
        }

        .login-footer {
            text-align: center;
            padding: 18px 30px 28px;
            border-top: 1px solid #e9ecef;
        }

        .login-footer a {
            color: var(--primary-yellow);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .login-footer a:hover {
            color: var(--accent-orange);
            transform: translateX(-3px);
        }

        .copyright {
            text-align: center;
            margin-top: 25px;
            color: rgba(255,255,255,0.6);
            font-size: 0.85rem;
        }

        .copyright a {
            color: var(--primary-yellow);
            text-decoration: none;
            transition: color 0.3s;
        }

        .copyright a:hover {
            color: var(--accent-orange);
        }

        /* Responsive Breakpoints */
        @media (max-width: 576px) {
            .login-container {
                max-width: 100%;
            }

            .login-body {
                padding: 30px 25px 20px;
            }

            .login-header {
                padding: 30px 20px 25px;
            }

            .login-header h1 {
                font-size: 1.4rem;
            }

            .login-header p {
                font-size: 0.85rem;
            }

            .login-icon {
                width: 65px;
                height: 65px;
            }

            .login-icon i {
                font-size: 32px;
            }

            .login-footer {
                padding: 15px 25px 25px;
            }

            .form-control-custom {
                font-size: 0.9rem;
                padding: 12px 16px 12px 44px;
            }

            .btn-login {
                padding: 13px;
                font-size: 1rem;
            }

            body::before,
            body::after {
                width: 300px;
                height: 300px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-icon">
                    <i class='bx bxs-user-circle'></i>
                </div>
                <h1>Admin Portal</h1>
                <p>Portfolio Management</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <!-- Alert Messages -->
                <?php if ($success): ?>
                <div class="alert-custom alert-success-custom">
                    <i class='bx bx-check-circle'></i>
                    <span><strong>Success!</strong> <?= htmlspecialchars($success) ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="alert-custom alert-danger-custom">
                    <i class='bx bx-error-circle'></i>
                    <span><strong>Error!</strong> <?= htmlspecialchars($error) ?></span>
                </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" action="">
                    <!-- Email Field -->
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="input-group-custom">
                            <input type="email" 
                                   name="email" 
                                   class="form-control-custom" 
                                   placeholder="Enter your email" 
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                   required
                                   autofocus>
                            <i class='bx bx-envelope input-icon'></i>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group-custom">
                            <input type="password" 
                                   name="password" 
                                   class="form-control-custom" 
                                   placeholder="Enter your password"
                                   required>
                            <i class='bx bx-lock-alt input-icon'></i>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="checkbox-custom">
                        <input type="checkbox" name="remember_me" value="1" id="rememberMe">
                        <label for="rememberMe">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        <i class='bx bx-log-in'></i> Sign In
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <a href="../../index.php">
                    <i class='bx bx-arrow-back'></i> Back to Website
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="copyright">
            &copy; 2025 Portfolio Admin
        </div>
    </div>
</body>
</html>
