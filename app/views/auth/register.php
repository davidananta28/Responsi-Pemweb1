<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../home/index.php");
    exit;
}
$page = 'register';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game of Thrones | Register</title>
    <link rel="stylesheet" href="../../../public/assets/css/auth.css">
</head>

<body class="auth-body">
    <div class="auth-card register-card">
        <div class="sword-decor"></div>
        <div class="auth-header">
            <h2>JOIN THE REALM</h2>
            <p class="quote">"Leave one wolf alive and the sheep are never safe."</p>
        </div>

        <!-- Tangkap Pesan Error/Success dari Controller -->
        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: rgba(217, 83, 79, 0.2); color: #d9534f; padding: 10px; border-left: 3px solid #d9534f; margin-bottom: 15px; font-size: 14px;">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div style="background: rgba(92, 184, 92, 0.2); color: #5cb85c; padding: 10px; border-left: 3px solid #5cb85c; margin-bottom: 15px; font-size: 14px;">
                <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Form dilempar ke AuthController dengan parameter action=register -->
        <form class="auth-form" action="../../controllers/AuthController.php?action=register" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>FULL NAME</label>
                    <div class="input-wrapper">
                        <img src="../../../public/assets/img/name.png" class="icon" alt="User Icon">
                        <input type="text" name="fullname" placeholder="Your_name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>USERNAME</label>
                    <div class="input-wrapper">
                        <img src="../../../public/assets/img/username.png" class="icon" alt="User Icon">
                        <input type="text" name="username" placeholder="Your_Username" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>EMAIL</label>
                <div class="input-wrapper">
                    <img src="../../../public/assets/img/mail.png" class="icon" alt="Email Icon">
                    <input type="email" name="email" placeholder="Your_Email@email.com" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>PASSWORD</label>
                    <div class="input-wrapper">
                        <img src="../../../public/assets/img/password.png" class="icon" alt="Lock Icon">
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>CONFIRM</label>
                    <div class="input-wrapper">
                        <img src="../../../public/assets/img/password.png" class="icon" alt="Lock Icon">
                        <input type="password" name="confirm_password" placeholder="••••••••" required>
                    </div>
                </div>
            </div>
            <button type="submit" name="register" class="btn-auth">
                <img src="../../../public/assets/img/register.png" class="btn-icon" alt="Gold Icon">
                JOIN THE REALM
            </button>
            <div class="auth-footer">
                <div class="or-divider"><span>OR</span></div>
                <div class="auth-footer-link">
                    Already sworn Realm? <a href="login.php">SIGNS IN</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>