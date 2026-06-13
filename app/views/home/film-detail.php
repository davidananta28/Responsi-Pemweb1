<?php
session_start();
$page = 'film-detail';

include '../../../config/koneksi.php';
include '../../models/FilmModel.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$filmModel = new FilmModel($koneksi);
$film = $filmModel->getFilmById($id); // Ambil detail film

if (!$film) {
    header("Location: film.php"); // Jika ID tidak ada, kembalikan ke daftar film
    exit;
}

// Ambil episode dari database berdasarkan id_film
$query_eps = mysqli_query($koneksi, "SELECT * FROM episode WHERE id_film = '$id' ORDER BY eps_num ASC");

include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/film-detail.css">
    <div class="film-detail-hero" style="background-image: linear-gradient(to right, #111111 10%, rgba(17, 17, 17, 0) 100%), url('../../../public/assets/img/<?php echo $film['banner_hero']; ?>');">
        <div class="hero-content">
            <h1 class="film-title-large"><?php echo strtoupper($film['judul']); ?></h1>
            <a href="#episodes" class="btn-gold">&#9654; MULAI EPISODE</a>
        </div>
    </div>

    <div class="meta-grid">
        <div class="meta-left">
            <div class="meta-tags">
                <span class="badge"><?php echo $film['kategori']; ?></span>
                <span><?php echo $film['durasi']; ?></span> • <span><?php echo $film['tahun']; ?></span> • <span class="rating">&#9733; <?php echo $film['rating']; ?></span>
            </div>
            <p class="meta-warning"><?php echo $film['peringatan']; ?></p>
            <p class="meta-synopsis"><?php echo $film['sinopsis']; ?></p>
        </div>
        <div class="meta-right meta-info-list">
            <p>Pemeran: <span><?php echo $film['pemeran']; ?></span></p>
            <p>Genre: <span><?php echo $film['genre']; ?></span></p>
            <p>Karakteristik: <span><?php echo $film['tags']; ?></span></p>
        </div>
    </div>

    <div id="episodes" class="episodes-section">
        <div class="episodes-header">
            <h3>Daftar Episode</h3>
        </div>

        <div class="episode-list">
            <?php if (mysqli_num_rows($query_eps) > 0): ?>
                <?php while ($eps = mysqli_fetch_assoc($query_eps)): ?>
                    <div class="episode-item">
                        <div class="ep-num"><?php echo $eps['eps_num']; ?></div>
                        <img class="ep-thumb" src="../../../public/assets/img/<?php echo $eps['thumbnail']; ?>" alt="Ep <?php echo $eps['eps_num']; ?>" onerror="this.src='https://placehold.co/300x170/242730/C5A55A?text=Episode'">
                        <div class="ep-info">
                            <div class="ep-title-row">
                                <h4><?php echo $eps['judul_eps']; ?></h4>
                                <span><?php echo $eps['durasi']; ?></span>
                            </div>
                            <p class="ep-desc"><?php echo $eps['deskripsi']; ?></p>
                            <a href="<?php echo $eps['video_url']; ?>" target="_blank" style="color:var(--accent); font-size:12px; text-decoration:none; margin-top:5px; display:inline-block;">&#9654; Tonton Video</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color:#aaa;">Belum ada episode yang dirilis untuk serial ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>