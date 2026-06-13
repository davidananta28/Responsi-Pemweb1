<?php
session_start();
$page = 'faksi';
include '../../../config/koneksi.php';
include '../../models/FaksiModel.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$faksiModel = new FaksiModel($koneksi);
$faksi = $faksiModel->getFaksiById($id);

if (!$faksi) {
    header("Location: faksi.php");
    exit;
}

$query_anggota = mysqli_query($koneksi, "SELECT * FROM anggota_faksi WHERE id_faksi = '$id'");

include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/faksi-detail.css">

<main class="faksi-detail-container">
    <section class="faksi-hero">
        <div class="faksi-hero-bg-overlay"></div>
        <div class="faksi-hero-content">
            <div class="faksi-logo-wrapper">
                <img src="../../../public/assets/img/<?php echo $faksi['poster']; ?>" alt="Sigil" class="faksi-main-logo">
            </div>
            <div class="faksi-info">
                <span class="faksi-type">FAKSI / AFILIASI WESTEROS</span>
                <h1 class="faksi-title"><?php echo strtoupper($faksi['nama_faksi']); ?></h1>
                <p class="faksi-motto">"<?php echo $faksi['motto']; ?>"</p>

                <div class="faksi-description">
                    <p><?php echo nl2br($faksi['deskripsi']); ?></p>
                </div>

                <div class="faksi-meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">Wilayah</span>
                        <span class="meta-value"><?php echo $faksi['wilayah']; ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Senjata Pusaka</span>
                        <span class="meta-value"><?php echo $faksi['senjata'] ? $faksi['senjata'] : '-'; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faksi-members-section">
        <div class="section-header">
            <h2 class="section-title">ANGGOTA FAKSI</h2>
            <p class="section-subtitle">Orang-orang berpengaruh di bawah panji <?php echo $faksi['nama_faksi']; ?></p>
            <div class="gold-divider"></div>
        </div>

        <div class="members-grid">
            <?php if (mysqli_num_rows($query_anggota) > 0): ?>
                <?php while ($anggota = mysqli_fetch_assoc($query_anggota)): ?>
                    <div class="member-card">
                        <div class="member-img-wrapper">
                            <img src="../../../public/assets/img/<?php echo $anggota['foto_karakter']; ?>" alt="<?php echo $anggota['nama_karakter']; ?>" class="member-img" onerror="this.src='https://placehold.co/200x250/1A1A1A/C5A55A?text=Foto'">
                        </div>
                        <div class="member-info">
                            <h3 class="member-name"><?php echo $anggota['nama_karakter']; ?></h3>
                            <span class="member-role"><?php echo $anggota['gelar']; ?></span>
                            <p class="member-bio"><?php echo $anggota['bio']; ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color:#aaa; text-align:center; width: 100%;">Belum ada catatan sejarah mengenai anggota faksi ini.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>