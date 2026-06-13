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
            <h2>&#127916; TAMBAH SEASON BARU</h2>
            <p>Tambahkan arsip Season Game of Thrones / House of the Dragon.</p>
        </div>

        <form action="../../controllers/AdminController.php" method="POST" enctype="multipart/form-data" class="admin-main-form">

            <input type="hidden" name="kategori" value="TV Series">
            <input type="hidden" name="rating" value="N/A">
            <input type="hidden" name="peringatan" value="18+ (Kekerasan Intens, Konten Dewasa)">
            <input type="hidden" name="pemeran" value="HBO Ensemble Cast">
            <input type="hidden" name="genre" value="Fantasy, Drama, Action">
            <input type="hidden" name="tags" value="Game of Thrones, Westeros">

            <div class="form-grid-2" style="margin-bottom: 25px;">
                <div class="upload-zone-section" style="margin-bottom: 0;">
                    <label class="form-label">Poster Season (Vertikal)</label>
                    <div class="poster-preview-container">
                        <img src="../../../public/assets/img/placeholder.jpg" id="poster-preview" alt="Poster Preview">
                        <label for="poster-input" class="btn-upload-badge">Pilih Poster</label>
                        <input type="file" id="poster-input" name="poster" accept="image/*" required style="display: none;">
                    </div>
                    <p class="upload-note" style="text-align:center;">Format: JPG/PNG (Rasio 2:3)</p>
                </div>

                <div class="upload-zone-section" style="margin-bottom: 0;">
                    <label class="form-label">Background Banner (Horizontal)</label>
                    <div class="poster-preview-container" style="width: 200px; height: 112px;">
                        <img src="../../../public/assets/img/placeholder.jpg" id="banner-preview" alt="Banner Preview" style="width: 100%; height: 100%; object-fit: cover;">
                        <label for="banner-input" class="btn-upload-badge">Pilih Banner</label>
                        <input type="file" id="banner-input" name="banner_hero" accept="image/*" required style="display: none;">
                    </div>
                    <p class="upload-note" style="text-align:center;">Format: JPG/PNG (Rasio Lebar 16:9)</p>
                </div>
            </div>

            <div class="form-group">
                <label for="judul">Nama Season / Judul Seri</label>
                <input type="text" id="judul" name="judul" placeholder="Contoh: Game of Thrones: Season 1" required>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="tahun">Tahun Rilis</label>
                    <input type="number" id="tahun" name="tahun" min="1990" max="2030" placeholder="Contoh: 2011" required>
                </div>
                <div class="form-group">
                    <label for="durasi">Jumlah Episode</label>
                    <input type="text" id="durasi" name="durasi" placeholder="Contoh: 10 Episode" required>
                </div>
            </div>

            <div class="form-group">
                <label for="sinopsis">Sinopsis Season</label>
                <textarea id="sinopsis" name="sinopsis" rows="5" placeholder="Tuliskan ringkasan cerita untuk Season ini..." required></textarea>
            </div>

            <div class="form-actions">
                <a href="admin.php#kelola-film" class="btn-cancel">Batal</a>
                <button type="submit" name="tambah_film" class="btn-submit">&#128190; Simpan Season</button>
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

    document.getElementById('banner-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('banner-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?php include '../includes/footer.php'; ?>