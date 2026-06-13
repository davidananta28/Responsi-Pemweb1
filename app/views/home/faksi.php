<?php
session_start();
$page = 'faksi';

include '../../../config/koneksi.php';
$semua_faksi = mysqli_query($koneksi, "SELECT * FROM faksi ORDER BY id ASC");

include '../includes/header.php';
?>

<section class="page-section">
    <div class="section-box">
        <div class="section-header">
            <h2>PILIH FAKSIMU</h2>
        </div>
        <div class="grid-container grid-5">
            <?php if ($semua_faksi && mysqli_num_rows($semua_faksi) > 0): ?>
                <?php while ($f = mysqli_fetch_assoc($semua_faksi)): ?>
                    <div class="card">
                        <a href="faksi-detail.php?id=<?php echo $f['id']; ?>">
                            <img src="../../../public/assets/img/<?php echo $f['poster']; ?>" alt="<?php echo $f['nama_faksi']; ?>" onerror="this.src='../../../public/assets/img/stark.png'">
                            <div class="card-title">
                                <h3><?php echo htmlspecialchars($f['nama_faksi']); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: #aaa; grid-column: span 5; text-align: center;">Belum ada data faksi yang ditambahkan.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>