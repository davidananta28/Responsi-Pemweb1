<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home/index.php");
    exit;
}
$page = 'admin';

// --- LOGIKA PENGAMBILAN DATA ---
include '../../../config/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$anggota = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM anggota_faksi WHERE id='$id'"));
if (!$anggota) {
    header("Location: admin.php#kelola-anggota");
    exit;
}

$semua_faksi = mysqli_query($koneksi, "SELECT * FROM faksi ORDER BY nama_faksi ASC");
// -------------------------------
include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/form-admin.css">

<div class="form-admin-container">
    <div class="form-admin-card">
        <div class="form-admin-header">
            <h2>&#128393; EDIT ANGGOTA FAKSI</h2>
            <p>Ubah informasi karakter, ksatria, atau penguasa yang sudah terdaftar.</p>
        </div>

        <form action="../../controllers/AdminController.php" method="POST" enctype="multipart/form-data" class="admin-main-form">
            <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
            <input type="hidden" name="foto_lama" value="<?php echo $anggota['foto_karakter']; ?>">

            <div class="upload-zone-section">
                <label class="form-label">Potret Karakter</label>
                <div class="poster-preview-container">
                    <img src="../../../public/assets/img/<?php echo $anggota['foto_karakter']; ?>" onerror="this.src='https://placehold.co/130x190/1A1A1A/C5A55A?text=Foto'" id="foto-preview" alt="Foto Preview">
                    <label for="foto-input" class="btn-upload-badge">Ubah Foto</label>
                    <input type="file" id="foto-input" name="foto_karakter" accept="image/*" style="display: none;">
                </div>
                <p class="upload-note">Format: JPG/PNG (Rasio Potret/Vertikal disarankan, Max: 2MB)</p>
            </div>

            <div class="form-group">
                <label for="nama_karakter">Nama Lengkap Karakter</label>
                <input type="text" id="nama_karakter" name="nama_karakter" value="<?php echo $anggota['nama_karakter']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gelar">Gelar / Jabatan Utama</label>
                <input type="text" id="gelar" name="gelar" value="<?php echo $anggota['gelar']; ?>" required>
            </div>

            <div class="form-group">
                <label for="id_faksi">Afiliasi Faksi / House</label>
                <select id="id_faksi" name="id_faksi" required>
                    <option value="0">Tidak Berafiliasi (Free Folk / Sellsword)</option>
                    <?php while ($f = mysqli_fetch_assoc($semua_faksi)): ?>
                        <option value="<?php echo $f['id']; ?>" <?php echo ($anggota['id_faksi'] == $f['id']) ? 'selected' : ''; ?>>
                            <?php echo $f['nama_faksi']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bio">Biografi Singkat (Opsional)</label>
                <textarea id="bio" name="bio" rows="4"><?php echo $anggota['bio']; ?></textarea>
            </div>

            <div class="form-actions">
                <a href="admin.php#kelola-anggota" class="btn-cancel">Batal</a>
                <button type="submit" name="edit_anggota" class="btn-submit">&#128190; Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('foto-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('foto-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<?php include '../includes/footer.php'; ?>