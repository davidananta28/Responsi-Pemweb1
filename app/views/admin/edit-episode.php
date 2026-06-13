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

$eps = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM episode WHERE id='$id'"));
if (!$eps) {
    header("Location: admin.php#kelola-episode");
    exit;
}

$semua_film = mysqli_query($koneksi, "SELECT id, judul FROM film ORDER BY id DESC");
// -------------------------------
include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/form-admin.css">

<div class="form-admin-container">
    <div class="form-admin-card">
        <div class="form-admin-header">
            <h2>&#128393; EDIT EPISODE</h2>
            <p>Ubah catatan episode dan tautan video yang sudah ada di dalam arsip kerajaan.</p>
        </div>

        <form action="../../controllers/AdminController.php" method="POST" enctype="multipart/form-data" class="admin-main-form">
            <input type="hidden" name="id" value="<?php echo $eps['id']; ?>">
            <input type="hidden" name="thumbnail_lama" value="<?php echo $eps['thumbnail']; ?>">

            <div class="form-group">
                <label for="id_film">Pilih Season / Series</label>
                <select id="id_film" name="id_film" required>
                    <?php while ($fl = mysqli_fetch_assoc($semua_film)): ?>
                        <option value="<?php echo $fl['id']; ?>" <?php echo ($eps['id_film'] == $fl['id']) ? 'selected' : ''; ?>>
                            <?php echo $fl['judul']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="eps_num">Nomor Episode</label>
                    <input type="number" id="eps_num" name="eps_num" min="1" value="<?php echo $eps['eps_num']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="durasi">Durasi Episode</label>
                    <input type="text" id="durasi" name="durasi" value="<?php echo $eps['durasi']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="judul_eps">Judul Episode</label>
                <input type="text" id="judul_eps" name="judul_eps" value="<?php echo $eps['judul_eps']; ?>" required>
            </div>

            <div class="form-group">
                <label for="url_youtube">Tautan Video YouTube</label>
                <input type="url" id="url_youtube" name="video_url" value="<?php echo $eps['video_url']; ?>" required>
            </div>

            <div class="upload-zone-section">
                <label class="form-label">Thumbnail Episode</label>
                <div class="poster-preview-container" style="width: 300px; height: 170px; border-radius: 8px;">
                    <img src="../../../public/assets/img/<?php echo $eps['thumbnail']; ?>" id="thumb-preview" alt="Thumbnail Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;" onerror="this.src='https://placehold.co/300x170/1A1A1A/C5A55A?text=Ep'">
                    <label for="thumb-input" class="btn-upload-badge">Ubah Gambar</label>
                    <input type="file" id="thumb-input" name="thumbnail" accept="image/*" style="display: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Episode</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required><?php echo $eps['deskripsi']; ?></textarea>
            </div>

            <div class="form-actions">
                <a href="admin.php#kelola-episode" class="btn-cancel">Batal</a>
                <button type="submit" name="edit_episode" class="btn-submit">&#128190; Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('thumb-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('thumb-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<?php include '../includes/footer.php'; ?>