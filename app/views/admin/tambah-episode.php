<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home/index.php");
    exit;
}
$page = 'admin';

include '../../../config/koneksi.php';
$semua_film = mysqli_query($koneksi, "SELECT id, judul FROM film ORDER BY id DESC");

include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/form-admin.css">

<div class="form-admin-container">
    <div class="form-admin-card">
        <div class="form-admin-header">
            <h2>&#128250; TAMBAH EPISODE BARU</h2>
            <p>Tambahkan catatan episode dan tautan video ke dalam arsip kerajaan.</p>
        </div>

        <form action="../../controllers/AdminController.php" method="POST" enctype="multipart/form-data" class="admin-main-form">

            <div class="form-group">
                <label for="id_film">Pilih Season / Series</label>
                <select id="id_film" name="id_film" required>
                    <option value="" disabled selected>-- Pilih Season --</option>
                    <?php while ($fl = mysqli_fetch_assoc($semua_film)): ?>
                        <option value="<?php echo $fl['id']; ?>"><?php echo $fl['judul']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="eps_num">Nomor Episode</label>
                    <input type="number" id="eps_num" name="eps_num" min="1" placeholder="Contoh: 1" required>
                </div>
                <div class="form-group">
                    <label for="durasi">Durasi Episode</label>
                    <input type="text" id="durasi" name="durasi" placeholder="Contoh: 1j 1m" required>
                </div>
            </div>

            <div class="form-group">
                <label for="judul_eps">Judul Episode</label>
                <input type="text" id="judul_eps" name="judul_eps" placeholder="Contoh: Winter Is Coming" required>
            </div>

            <div class="form-group">
                <label for="url_youtube">Tautan Video YouTube</label>
                <input type="url" id="url_youtube" name="video_url" placeholder="Contoh: https://www.youtube.com/watch?v=..." required>
                <p class="upload-note" style="margin-top: 5px; color: #888; font-size: 0.85rem;">*Masukkan link penuh dari YouTube</p>
            </div>

            <div class="upload-zone-section">
                <label class="form-label">Thumbnail Episode</label>
                <div class="poster-preview-container" style="width: 300px; height: 170px; border-radius: 8px;">
                    <img src="../../../public/assets/img/placeholder.jpg" id="thumb-preview" alt="Thumbnail Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                    <label for="thumb-input" class="btn-upload-badge">Pilih Gambar</label>
                    <input type="file" id="thumb-input" name="thumbnail" accept="image/*" required style="display: none;">
                </div>
                <p class="upload-note">Rekomendasi rasio 16:9 (Format: JPG, PNG, Max: 2MB)</p>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Episode</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Tuliskan ringkasan kejadian penting di episode ini..." required></textarea>
            </div>

            <div class="form-actions">
                <a href="admin.php#kelola-episode" class="btn-cancel">Batal</a>
                <button type="submit" name="tambah_episode" class="btn-submit">&#128190; Simpan Episode</button>
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