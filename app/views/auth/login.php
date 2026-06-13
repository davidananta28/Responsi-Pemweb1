<?php
session_start();
// Redirect ke home jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: ../home/index.php");
    exit;
}
$page = 'login';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game of Thrones | Login</title>
    <link rel="stylesheet" href="../../../public/assets/css/auth.css">
</head>

<body class="auth-body">
    <div class="auth-card">
        <div class="sword-decor"></div>
        <div class="auth-header">
            <h2>ENTER THE REALM</h2>
            <p class="quote">"Chaos isn't a pit. Chaos is a ladder."</p>
        </div>

        <!-- Tangkap Pesan Error dari Controller -->
        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: rgba(217, 83, 79, 0.2); color: #d9534f; padding: 10px; border-left: 3px solid #d9534f; margin-bottom: 15px; font-size: 14px; text-align: center;">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Form dilempar ke AuthController dengan parameter action=login -->
        <form class="auth-form" action="../../controllers/AuthController.php?action=login" method="POST">
            <div class="form-group">
                <label>USERNAME</label>
                <div class="input-wrapper">
                    <img src="../../../public/assets/img/username.png" class="icon" alt="User Icon">
                    <input type="text" name="username" placeholder="jon_snow" required>
                </div>
            </div>
            <div class="form-group">
                <label>PASSWORD</label>
                <div class="input-wrapper">
                    <img src="../../../public/assets/img/password.png" class="icon" alt="Lock Icon">
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" name="login" class="btn-auth">
                <img src="../../../public/assets/img/login.png" class="btn-icon" alt="Gold Icon">
                ENTER THE KINGDOM
            </button>
            <div class="auth-footer">
                <div class="or-divider"><span>OR</span></div>
                <div class="auth-footer-link">
                    Not a member of the realm yet? <a href="register.php">JOINS NOW</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>