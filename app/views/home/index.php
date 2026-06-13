<?php
session_start();
$page = 'beranda';

// --- LOGIKA PENGAMBILAN DATA ---
include '../../../config/koneksi.php';

// Langsung ambil data dari database (Maksimal 5 faksi dan 3 film)
$faksi_beranda = mysqli_query($koneksi, "SELECT * FROM faksi ORDER BY id ASC LIMIT 5");
$film_beranda  = mysqli_query($koneksi, "SELECT * FROM film ORDER BY id DESC LIMIT 3");
// -------------------------------

include '../includes/header.php';
?>

<section class="hero" style="background: linear-gradient(to right, rgba(13,13,13,0.9) 10%, rgba(13,13,13,0.3) 60%, rgba(13,13,13,0.8) 100%), url('../../../public/assets/img/background-kursi.png') no-repeat center center / cover;">
    <div class="hero-content">
        <h1>THE IRON THRONE:<br>A HISTORY OF<br>BLOOD</h1>
        <p style="margin-bottom: 0;">Saksikan kisah pengkhianatan dan kehormatan yang membentuk Westeros. Perjuangan mematikan untuk tahta yang akan menentukan nasib seluruh kerajaan.</p>
        <div id="text-lebih-banyak" class="text-expandable">
            <p style="margin-top: 5px; margin-bottom: 0;">Lembar demi lembar sejarah kelam telah ditulis dengan darah para raja dan ksatria yang gugur demi ambisi. Di balik dinding-dinding kastil yang megah, konspirasi rahasia tengah disusun...</p>
        </div>
        <button id="btn-selengkapnya" class="btn-primary" style="cursor: pointer; outline: none; background: rgba(13, 13, 13, 0.5); border: 1px solid var(--accent); text-align: center; margin-top: 25px;">&#9432; INFO SELENGKAPNYA</button>
    </div>
</section>

<section class="page-section">
    <div class="section-box">
        <div class="section-header">
            <h2>PILIH FAKSIMU</h2>
            <a href="faksi.php" class="view-all">Lihat Semua</a>
        </div>
        <div class="grid-container grid-5">
            <?php if ($faksi_beranda && mysqli_num_rows($faksi_beranda) > 0): ?>
                <?php while ($f = mysqli_fetch_assoc($faksi_beranda)): ?>
                    <div class="card">
                        <a href="faksi-detail.php?id=<?php echo $f['id']; ?>">
                            <img src="../../../public/assets/img/<?php echo $f['poster']; ?>" alt="<?php echo $f['nama_faksi']; ?>" onerror="this.src='../../../public/assets/img/stark.png'">
                            <div class="card-title">
                                <h3><?php echo htmlspecialchars($f['nama_faksi']); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="page-section">
    <div class="section-box">
        <div class="section-header">
            <h2>FILM</h2>
            <a href="film.php" class="view-all">Lihat Semua</a>
        </div>
        <div class="grid-container grid-3" style="max-width: 900px;">
            <?php if ($film_beranda && mysqli_num_rows($film_beranda) > 0): ?>
                <?php while ($fl = mysqli_fetch_assoc($film_beranda)): ?>
                    <div class="card">
                        <a href="film-detail.php?id=<?php echo $fl['id']; ?>">
                            <img src="../../../public/assets/img/<?php echo $fl['poster']; ?>" alt="<?php echo $fl['judul']; ?>" onerror="this.src='../../../public/assets/img/got.png'">
                            <div class="card-title">
                                <h3><?php echo htmlspecialchars($fl['judul']); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.getElementById('btn-selengkapnya').addEventListener('click', function() {
        var teksTambahan = document.getElementById('text-lebih-banyak');
        var tombol = document.getElementById('btn-selengkapnya');
        teksTambahan.classList.toggle('show');
        if (teksTambahan.classList.contains('show')) {
            tombol.innerHTML = '&#9432; SEMBUNYIKAN';
        } else {
            tombol.innerHTML = '&#9432; INFO SELENGKAPNYA';
        }
    });
</script>

<?php include '../includes/footer.php'; ?>