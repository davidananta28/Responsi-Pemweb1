<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home/index.php");
    exit;
}
$page = 'admin';

include '../../../config/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$faksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM faksi WHERE id='$id'"));
if (!$faksi) {
    header("Location: admin.php#kelola-faksi");
    exit;
}
include '../includes/header.php';
?>
<link rel="stylesheet" href="../../../public/assets/css/form-admin.css">

<div class="form-admin-container">
    <div class="form-admin-card">
        <div class="form-admin-header">
            <h2>&#128393; EDIT FAKSI / HOUSE</h2>
            <p>Ubah informasi faksi yang sudah tersimpan di arsip Maester's Citadel.</p>
        </div>

        <form action="../../controllers/AdminController.php" method="POST" enctype="multipart/form-data" class="admin-main-form">
            <input type="hidden" name="id" value="<?php echo $faksi['id']; ?>">
            <input type="hidden" name="poster_lama" value="<?php echo $faksi['poster']; ?>">

            <div class="upload-zone-section">
                <label class="form-label">Poster Faksi</label>
                <div class="poster-preview-container">
                    <img src="../../../public/assets/img/<?php echo $faksi['poster']; ?>" onerror="this.src='https://placehold.co/130x190/1A1A1A/C5A55A?text=Sigil'" id="poster-preview" alt="Poster Preview">
                    <label for="poster-input" class="btn-upload-badge">Ubah Poster</label>
                    <input type="file" id="poster-input" name="poster" accept="image/*" style="display: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="nama_faksi">Nama Faksi</label>
                <input type="text" id="nama_faksi" name="nama_faksi" value="<?php echo $faksi['nama_faksi']; ?>" required>
            </div>

            <div class="form-group">
                <label for="motto">Motto Faksi</label>
                <input type="text" id="motto" name="motto" value="<?php echo $faksi['motto']; ?>" required>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="kastil">Kastil Utama</label>
                    <input type="text" id="kastil" name="wilayah" value="<?php echo $faksi['wilayah']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="senjata">Senjata Pusaka</label>
                    <input type="text" id="senjata" name="senjata" value="<?php echo $faksi['senjata']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi & Sejarah Lengkap</label>
                <textarea id="deskripsi" name="deskripsi" rows="6" required><?php echo $faksi['deskripsi']; ?></textarea>
            </div>

            <div class="form-actions">
                <a href="admin.php#kelola-faksi" class="btn-cancel">Batal</a>
                <button type="submit" name="edit_faksi" class="btn-submit">&#128190; Simpan Perubahan</button>
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