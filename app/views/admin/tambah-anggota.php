<?php
session_start();
// Proteksi halaman, hanya admin yang boleh masuk
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home/index.php");
    exit;
}
$page = 'admin';

// --- LOGIKA PENGAMBILAN DATA (MVC) ---
include '../../../config/koneksi.php';
// Ambil daftar faksi untuk dropdown
$semua_faksi = mysqli_query($koneksi, "SELECT * FROM faksi ORDER BY nama_faksi ASC");
// -------------------------------------

include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/form-admin.css">

<div class="form-admin-container">
    <div class="form-admin-card">
        <div class="form-admin-header">
            <h2>&#128101; TAMBAH ANGGOTA FAKSI</h2>
            <p>Daftarkan ksatria, penguasa, atau tokoh penting ke dalam sebuah House.</p>
        </div>

        <form action="../../controllers/AdminController.php" method="POST" enctype="multipart/form-data" class="admin-main-form">

            <div class="upload-zone-section">
                <label class="form-label">Potret Karakter</label>
                <div class="poster-preview-container">
                    <img src="../../../public/assets/img/placeholder.jpg" id="foto-preview" alt="Foto Preview">
                    <label for="foto-input" class="btn-upload-badge">Pilih Foto</label>
                    <input type="file" id="foto-input" name="foto_karakter" accept="image/*" required style="display: none;">
                </div>
                <p class="upload-note">Format: JPG/PNG (Rasio Potret/Vertikal disarankan, Max: 2MB)</p>
            </div>

            <div class="form-group">
                <label for="nama_karakter">Nama Lengkap Karakter</label>
                <input type="text" id="nama_karakter" name="nama_karakter" placeholder="Contoh: Eddard Stark / Jon Snow" required>
            </div>

            <div class="form-group">
                <label for="gelar">Gelar / Peran (Title)</label>
                <input type="text" id="gelar" name="gelar" placeholder="Contoh: Lord of Winterfell / Lord Commander" required>
            </div>

            <div class="form-group">
                <label for="id_faksi">Pengabdian / Faksi (House)</label>
                <select id="id_faksi" name="id_faksi" required>
                    <option value="" disabled selected>-- Pilih Faksi Tempat Karakter Bernaung --</option>
                    <option value="0">Tidak Berafiliasi (Free Folk / Sellsword)</option>
                    <?php while ($f = mysqli_fetch_assoc($semua_faksi)): ?>
                        <option value="<?php echo $f['id']; ?>"><?php echo $f['nama_faksi']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bio">Biografi Singkat (Opsional)</label>
                <textarea id="bio" name="bio" rows="4" placeholder="Catatan khusus mengenai karakter ini..."></textarea>
            </div>

            <div class="form-actions">
                <a href="admin.php#kelola-anggota" class="btn-cancel">Batal</a>
                <button type="submit" name="tambah_anggota" class="btn-submit">&#128101; Daftarkan Karakter</button>
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