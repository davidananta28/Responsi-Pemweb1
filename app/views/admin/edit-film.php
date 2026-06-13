<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home/index.php");
    exit;
}
$page = 'admin';

include '../../../config/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$film = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM film WHERE id='$id'"));
if (!$film) {
    header("Location: admin.php#kelola-film");
    exit;
}
include '../includes/header.php';
?>
<link rel="stylesheet" href="../../../public/assets/css/form-admin.css">

<div class="form-admin-container">
    <div class="form-admin-card">
        <div class="form-admin-header">
            <h2>&#128393; EDIT FILM / SERI</h2>
            <p>Ubah detail informasi kronik visual yang sudah ada.</p>
        </div>

        <form action="../../controllers/AdminController.php" method="POST" enctype="multipart/form-data" class="admin-main-form">
            <input type="hidden" name="id" value="<?php echo $film['id']; ?>">
            <input type="hidden" name="poster_lama" value="<?php echo $film['poster']; ?>">
            <input type="hidden" name="banner_lama" value="<?php echo $film['banner_hero']; ?>">

            <div class="form-grid-2" style="margin-bottom: 25px;">
                <div class="upload-zone-section" style="margin-bottom: 0;">
                    <label class="form-label">Poster Vertikal</label>
                    <div class="poster-preview-container">
                        <img src="../../../public/assets/img/<?php echo $film['poster']; ?>" id="poster-preview" alt="Poster Preview" onerror="this.src='https://placehold.co/150x220/1A1A1A/C5A55A?text=Poster'">
                        <label for="poster-input" class="btn-upload-badge">Ubah Poster</label>
                        <input type="file" id="poster-input" name="poster" accept="image/*" style="display: none;">
                    </div>
                </div>

                <div class="upload-zone-section" style="margin-bottom: 0;">
                    <label class="form-label">Background Banner (Hero)</label>
                    <div class="poster-preview-container" style="width: 200px; height: 112px;">
                        <img src="../../../public/assets/img/<?php echo $film['banner_hero']; ?>" id="banner-preview" alt="Banner Preview" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://placehold.co/200x112/1A1A1A/C5A55A?text=Banner'">
                        <label for="banner-input" class="btn-upload-badge">Ubah Banner</label>
                        <input type="file" id="banner-input" name="banner_hero" accept="image/*" style="display: none;">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="judul">Judul Film / Seri</label>
                <input type="text" id="judul" name="judul" value="<?php echo $film['judul']; ?>" required>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="kategori">Kategori Konten</label>
                    <select id="kategori" name="kategori" required>
                        <option value="Movie" <?php echo ($film['kategori'] == 'Movie') ? 'selected' : ''; ?>>Movie</option>
                        <option value="TV" <?php echo ($film['kategori'] == 'TV') ? 'selected' : ''; ?>>TV (Serial TV)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="durasi">Durasi / Jumlah Season</label>
                    <input type="text" id="durasi" name="durasi" value="<?php echo $film['durasi']; ?>" required>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="tahun">Tahun Rilis</label>
                    <input type="number" id="tahun" name="tahun" value="<?php echo $film['tahun']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating Konten</label>
                    <input type="text" id="rating" name="rating" value="<?php echo $film['rating']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="peringatan">Peringatan Usia & Konten</label>
                <input type="text" id="peringatan" name="peringatan" value="<?php echo $film['peringatan']; ?>" required>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="pemeran">Pemeran Utama</label>
                    <input type="text" id="pemeran" name="pemeran" value="<?php echo $film['pemeran']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" value="<?php echo $film['genre']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="tags">Karakteristik (Serial Ini)</label>
                <input type="text" id="tags" name="tags" value="<?php echo $film['tags']; ?>" required>
            </div>

            <div class="form-group">
                <label for="sinopsis">Sinopsis / Deskripsi Cerita</label>
                <textarea id="sinopsis" name="sinopsis" rows="5" required><?php echo $film['sinopsis']; ?></textarea>
            </div>

            <div class="form-actions">
                <a href="admin.php#kelola-film" class="btn-cancel">Batal</a>
                <button type="submit" name="edit_film" class="btn-submit">&#128190; Simpan Perubahan</button>
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