<?php
session_start();
$page = 'film';

include '../../../config/koneksi.php';
$semua_film = mysqli_query($koneksi, "SELECT * FROM film ORDER BY id DESC");

include '../includes/header.php';
?>

<section class="page-section">
    <div class="section-box">
        <div class="section-header">
            <h2>SEMUA FILM & SERIES</h2>
        </div>
        <div class="grid-container grid-3" style="max-width: 900px;">
            <?php if ($semua_film && mysqli_num_rows($semua_film) > 0): ?>
                <?php while ($fl = mysqli_fetch_assoc($semua_film)): ?>
                    <div class="card">
                        <a href="film-detail.php?id=<?php echo $fl['id']; ?>">
                            <img src="../../../public/assets/img/<?php echo $fl['poster']; ?>" alt="<?php echo $fl['judul']; ?>" onerror="this.src='../../../public/assets/img/got.png'">
                            <div class="card-title">
                                <h3><?php echo htmlspecialchars($fl['judul']); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: #aaa; grid-column: span 3; text-align: center;">Belum ada data film yang ditambahkan.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>