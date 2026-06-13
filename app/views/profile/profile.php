<?php
session_start();

// Proteksi: harus login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$page = 'profile';

// --- LOGIKA PENGAMBILAN DATA ---
include '../../../config/koneksi.php';
$id_user = intval($_SESSION['user_id']);

$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT users.*, faksi.nama_faksi 
        FROM users 
        LEFT JOIN faksi ON users.id_faksi = faksi.id 
        WHERE users.id = '$id_user'"));

if (!$user) {
    header("Location: ../auth/logout.php");
    exit;
}
// -------------------------------

include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/profile.css">

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header-bg"></div>

        <div class="profile-avatar-wrapper">
            <img src="../../../public/assets/img/<?php echo !empty($user['foto_profil']) ? $user['foto_profil'] : 'profile.png'; ?>" alt="Profile Picture" class="profile-avatar" onerror="this.src='../../../public/assets/img/profile.png'">
        </div>

        <div class="profile-info">
            <h1 class="profile-name"><?php echo htmlspecialchars($user['nama_lengkap']); ?></h1>
            <p class="profile-title"><?php echo !empty($user['gelar']) ? htmlspecialchars($user['gelar']) : '-'; ?></p>
            <p class="profile-status">"<?php echo !empty($user['kutipan']) ? htmlspecialchars($user['kutipan']) : 'Belum ada kutipan favorit'; ?>"</p>
        </div>

        <div class="profile-details">
            <div class="detail-group">
                <label>Username</label>
                <div class="detail-value"><?php echo htmlspecialchars($user['username']); ?></div>
            </div>
            <div class="detail-group">
                <label>Email Address</label>
                <div class="detail-value"><?php echo htmlspecialchars($user['email']); ?></div>
            </div>
            <div class="detail-group">
                <label>Faksi Favorit</label>
                <div class="detail-value text-gold"><?php echo !empty($user['nama_faksi']) ? htmlspecialchars($user['nama_faksi']) : 'Belum Memilih'; ?></div>
            </div>
        </div>

        <div class="profile-actions">
            <a href="../admin/edit-profile.php" class="btn-profile-edit">Edit Profil</a>
            <a href="../auth/logout.php" class="btn-profile-logout">Logout</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
