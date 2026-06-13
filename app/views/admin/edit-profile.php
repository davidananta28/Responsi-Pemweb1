<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$page = 'profile';

include '../../../config/koneksi.php';
$id_user = $_SESSION['user_id'];

$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id_user'"));
$semua_faksi = mysqli_query($koneksi, "SELECT * FROM faksi ORDER BY nama_faksi ASC");
include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/edit-profile.css">

<div class="edit-profile-container">
    <div class="edit-profile-card">
        <div class="edit-profile-header">
            <h2>EDIT PROFIL</h2>
            <p>"A wolf doesn't concern himself with the opinion of sheep."</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: rgba(217, 83, 79, 0.2); color: #d9534f; padding: 10px; border-left: 3px solid #d9534f; margin-bottom: 15px; font-size: 14px;">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div style="background: rgba(92, 184, 92, 0.2); color: #5cb85c; padding: 10px; border-left: 3px solid #5cb85c; margin-bottom: 15px; font-size: 14px;">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="../profile/proses-profile.php" method="POST" enctype="multipart/form-data" class="edit-profile-form">
            <input type="hidden" name="foto_lama" value="<?php echo $user['foto_profil']; ?>">

            <div class="avatar-upload-section">
                <div class="avatar-preview-wrapper">
                    <img src="../../../public/assets/img/<?php echo $user['foto_profil']; ?>" alt="Profile Preview" id="avatar-preview" class="current-avatar" onerror="this.src='../../../public/assets/img/profile.png'">
                    <label for="avatar-input" class="change-avatar-badge">
                        <span>&#128247;</span>
                    </label>
                </div>
                <input type="file" id="avatar-input" name="foto_profil" accept="image/*" style="display: none;">
                <p class="upload-note">Format: JPG, PNG. Maksimal 2MB</p>
            </div>

            <div class="form-group">
                <label for="fullname">Nama Lengkap</label>
                <div class="input-wrapper">
                    <input type="text" id="fullname" name="nama_lengkap" value="<?php echo $user['nama_lengkap']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="title">Gelar (Title)</label>
                <div class="input-wrapper">
                    <input type="text" id="title" name="gelar" value="<?php echo $user['gelar']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="status">Kutipan / Status</label>
                <div class="input-wrapper">
                    <input type="text" id="status" name="kutipan" value="<?php echo htmlspecialchars($user['kutipan']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="faction">Faksi / House Favorit</label>
                <div class="input-wrapper">
                    <select id="faction" name="id_faksi">
                        <option value="0">Pilih Faksi</option>
                        <?php while ($f = mysqli_fetch_assoc($semua_faksi)): ?>
                            <option value="<?php echo $f['id']; ?>" <?php echo ($user['id_faksi'] == $f['id']) ? 'selected' : ''; ?>>
                                <?php echo $f['nama_faksi']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="../profile/profile.php" class="btn-cancel">Batal</a>
                <button type="submit" name="edit_profile" class="btn-save">&#9876; Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('avatar-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<?php include '../includes/footer.php'; ?>