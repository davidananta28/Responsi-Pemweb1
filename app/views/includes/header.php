<?php
// Pastikan session dimulai agar kita bisa membaca $_SESSION['role']
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($page)) {
    $page = 'beranda';
}
// Hide header on auth pages
if ($page != 'login' && $page != 'register'):
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Game of Thrones | <?php echo ucfirst($page); ?></title>
        <link rel="stylesheet" href="../../../public/assets/css/style.css">
        <link rel="stylesheet" href="../../../public/assets/css/navbar.css">
        <link rel="stylesheet" href="../../../public/assets/css/footer.css">
    </head>

    <body>
        <header>
            <a href="../home/index.php" class="logo">
                <img src="../../../public/assets/img/logo.png" alt="Game of Thrones">
            </a>

            <nav class="desktop-nav">
                <a href="<?php echo ($page == 'admin' || $page == 'profile') ? '../home/' : ''; ?>index.php" class="<?php echo ($page == 'beranda') ? 'active' : ''; ?>">BERANDA</a>
                <a href="<?php echo ($page == 'admin' || $page == 'profile') ? '../home/' : ''; ?>film.php" class="<?php echo ($page == 'film' || $page == 'film-detail') ? 'active' : ''; ?>">FILM</a>
                <a href="<?php echo ($page == 'admin' || $page == 'profile') ? '../home/' : ''; ?>faksi.php" class="<?php echo ($page == 'faksi') ? 'active' : ''; ?>">FAKSI</a>
            </nav>

            <div class="header-icons">
                <div class="profile-dropdown">
                    <button class="profile-btn">
                        <img src="../../../public/assets/img/profile.png" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                    </button>
                    <div class="dropdown-content">

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="<?php echo ($page == 'admin') ? '' : '../admin/'; ?>admin.php" style="color: var(--accent);">Admin Panel</a>
                        <?php endif; ?>
                        <?php if ($page != 'profile'): ?>
                            <a href="../profile/profile.php">Profil Saya</a>
                        <?php endif; ?>
                        <a href="../auth/logout.php">Logout</a>
                    </div>
                </div>
            </div>
            <button class="mobile-menu-btn">&#9776;</button>
        </header>

        <nav class="mobile-nav">
            <a href="<?php echo ($page == 'admin' || $page == 'profile') ? '../home/' : ''; ?>index.php" class="<?php echo ($page == 'beranda') ? 'active' : ''; ?>">BERANDA</a>
            <a href="<?php echo ($page == 'admin' || $page == 'profile') ? '../home/' : ''; ?>film.php" class="<?php echo ($page == 'film') ? 'active' : ''; ?>">FILM</a>
            <a href="<?php echo ($page == 'admin' || $page == 'profile') ? '../home/' : ''; ?>faksi.php" class="<?php echo ($page == 'faksi') ? 'active' : ''; ?>">FAKSI</a>

            <?php if ($page != 'profile'): ?>
            <a href="../profile/profile.php">Profil Saya</a>
        <?php endif; ?>
            <a href="../auth/logout.php" style="color: #d9534f;">Logout</a>
        </nav>
    <?php endif; ?>