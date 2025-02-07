<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database and auth
require_once 'config/db.php';
require_once 'includes/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIVEKANANDHA COLLEGE OF ARTS AND SCIENCES FOR WOMEN (AUTONOMOUS)</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="landing-container">
        <div class="welcome-box">
            <h1><i class="fas fa-graduation-cap"></i> VIVEKANANDHA COLLEGE OF ARTS AND SCIENCES FOR WOMEN (AUTONOMOUS)</h1>
            <h2 style="text-align: center; color: #666; font-size: 1.2rem; margin-top: 10px;">THIRUCHENGODE NAMAKKAL(DT)</h2>
            
            <div class="login-links">
                <div class="portal-section">
                    <h3><i class="fas fa-user-graduate"></i> Student Portal</h3>
                    <div class="portal-links">
                        <a href="login.php" class="portal-btn login-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="btn-text">Student Login</span>
                            <small class="btn-subtitle">Access your account</small>
                        </a>
                        <a href="register.php" class="portal-btn register-btn">
                            <i class="fas fa-user-plus"></i>
                            <span class="btn-text">New Registration</span>
                            <small class="btn-subtitle">Create student account</small>
                        </a>
                    </div>
                </div>
                
                <div class="portal-section">
                    <h3><i class="fas fa-chalkboard-teacher"></i> Staff Portal</h3>
                    <div class="portal-links">
                        <a href="staff/login.php" class="portal-btn login-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="btn-text">Staff Login</span>
                            <small class="btn-subtitle">Access staff portal</small>
                        </a>
                        <a href="staff/register.php" class="portal-btn register-btn">
                            <i class="fas fa-user-plus"></i>
                            <span class="btn-text">Staff Registration</span>
                            <small class="btn-subtitle">Join as staff</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
