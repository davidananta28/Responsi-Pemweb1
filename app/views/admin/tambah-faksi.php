<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home/index.php");
    exit;
}
$page = 'admin';
include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/form-admin.css">

<div class="form-admin-container">
    <div class="form-admin-card">
        <div class="form-admin-header">
            <h2>&#128737; TAMBAH FAKSI / HOUSE BARU</h2>
            <p>Lengkapi seluruh informasi faksi agar sesuai dengan arsip di Maester's Citadel.</p>
        </div>

        <form action="../../controllers/AdminController.php" method="POST" enctype="multipart/form-data" class="admin-main-form">

            <div class="upload-zone-section">
                <label class="form-label">Poster Faksi</label>
                <div class="poster-preview-container">
                    <img src="../../../public/assets/img/placeholder.jpg" id="poster-preview" alt="Poster Preview">
                    <label for="poster-input" class="btn-upload-badge">Pilih Poster</label>
                    <input type="file" id="poster-input" name="poster" accept="image/*" required style="display: none;">
                </div>
                <p class="upload-note">Format: JPG/PNG (Rasio Vertikal disarankan, Max: 2MB)</p>
            </div>

            <div class="form-group">
                <label for="nama_faksi">Nama Faksi</label>
                <input type="text" id="nama_faksi" name="nama_faksi" placeholder="Contoh: HOUSE STARK" required>
            </div>

            <div class="form-group">
                <label for="motto">Motto Faksi</label>
                <input type="text" id="motto" name="motto" placeholder="Contoh: Winter is Coming" required>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="wilayah">Wilayah Utama</label>
                    <input type="text" id="wilayah" name="wilayah" placeholder="Contoh: The North" required>
                </div>
                <div class="form-group">
                    <label for="senjata">Senjata Pusaka</label>
                    <input type="text" id="senjata" name="senjata" placeholder="Contoh: Ice (Valyrian Steel)">
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi & Sejarah Lengkap</label>
                <textarea id="deskripsi" name="deskripsi" rows="6" placeholder="Masukkan deskripsi lengkap tentang sejarah, asal-usul, dan keturunan faksi..." required></textarea>
            </div>

            <div class="form-actions">
                <a href="admin.php#kelola-faksi" class="btn-cancel">Batal</a>
                <button type="submit" name="tambah_faksi" class="btn-submit">&#128737; Simpan Data Faksi</button>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('poster-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('poster-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?php include '../includes/footer.php'; ?>