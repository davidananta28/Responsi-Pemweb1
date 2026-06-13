<?php
session_start();

// --- PROTEKSI KEAMANAN ---
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home/index.php");
    exit;
}

$page = 'admin';

// --- PENERAPAN KONSEP MVC (MODEL PEMANGGIL) ---
include '../../../config/koneksi.php';
include '../../models/FilmModel.php';
include '../../models/FaksiModel.php';
include '../../models/AdminModel.php';

// 1. Inisialisasi Model
$filmModel  = new FilmModel($koneksi);
$faksiModel = new FaksiModel($koneksi);
$adminModel = new AdminModel($koneksi);

// 2. Ambil Data dari Model
$stats         = $adminModel->getDashboardStats();
$semua_film    = $filmModel->getAllFilm();
$semua_faksi   = $faksiModel->getAllFaksi();
$semua_episode = $adminModel->getAllEpisodeDetail();
$semua_anggota = $adminModel->getAllAnggotaDetail();
$semua_user    = $adminModel->getAllUserDetail();
// ----------------------------------------------

include '../includes/header.php';
?>

<link rel="stylesheet" href="../../../public/assets/css/admin.css">

<div class="admin-container">

    <aside class="admin-sidebar">
        <div class="sidebar-title">
            <span>&#9876;</span> PANEL KENDALI
        </div>
        <nav class="sidebar-nav">
            <a href="#dashboard" class="sidebar-link active" onclick="switchTab('dashboard')">&#128202; Dashboard</a>
            <a href="#kelola-film" class="sidebar-link" onclick="switchTab('kelola-film')">&#127916; Kelola Film</a>
            <a href="#kelola-episode" class="sidebar-link" onclick="switchTab('kelola-episode')">&#128250; Kelola Episode</a>
            <a href="#kelola-faksi" class="sidebar-link" onclick="switchTab('kelola-faksi')">&#128737; Kelola Faksi</a>
            <a href="#kelola-anggota" class="sidebar-link" onclick="switchTab('kelola-anggota')">&#128100; Kelola Anggota</a>
            <a href="#kelola-user" class="sidebar-link" onclick="switchTab('kelola-user')">&#128101; Kelola Pengguna</a>
        </nav>
    </aside>

    <main class="admin-main">

        <section id="tab-dashboard" class="admin-section active">
            <div class="admin-header-title">
                <h2>Selamat Datang, Hand of the King</h2>
                <p>Kelola dan pantau seluruh data kedamaian serta konflik di Westeros.</p>
            </div>

            <div class="stats-grid">
                <div class="stats-card">
                    <div class="stats-icon">&#127916;</div>
                    <div class="stats-info">
                        <h3><?php echo $stats['film']; ?></h3>
                        <p>Total Season</p>
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon">&#128737;</div>
                    <div class="stats-info">
                        <h3><?php echo $stats['faksi']; ?></h3>
                        <p>Total Faksi / House</p>
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon">&#128101;</div>
                    <div class="stats-info">
                        <h3><?php echo $stats['user']; ?></h3>
                        <p>Total Pengguna sworn</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="tab-kelola-film" class="admin-section">
            <div class="admin-header-title-flex">
                <div>
                    <h2>Kelola Film & Season</h2>
                    <p>Tambah, ubah, atau hapus daftar tayangan per season.</p>
                </div>
                <button class="btn-admin-add" onclick="window.location.href='tambah-film.php'">+ Tambah Season Baru</button>
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Season</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($film = mysqli_fetch_assoc($semua_film)): ?>
                            <tr>
                                <td><img src="../../../public/assets/img/<?php echo $film['poster']; ?>" alt="Poster" class="table-img" onerror="this.src='https://placehold.co/40x60/1A1A1A/C5A55A?text=GoT'"></td>
                                <td><strong><?php echo $film['judul']; ?></strong></td>
                                <td><?php echo $film['kategori']; ?></td>
                                <td><?php echo $film['tahun']; ?></td>
                                <td class="text-gold">&#9733; <?php echo $film['rating']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action-edit" onclick="window.location.href='edit-film.php?id=<?php echo $film['id']; ?>'">&#128393; Edit</button>
                                        <a href="../../controllers/AdminController.php?hapus=film&id=<?php echo $film['id']; ?>" class="btn-action-delete" onclick="return confirm('Yakin ingin menghapus season ini? Semua episode terkait akan ikut terhapus.')">&#128465; Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="tab-kelola-episode" class="admin-section">
            <div class="admin-header-title-flex">
                <div>
                    <h2>Kelola Episode</h2>
                    <p>Manajemen daftar episode dan tautan video untuk setiap season.</p>
                </div>
                <button class="btn-admin-add" onclick="window.location.href='tambah-episode.php'">+ Tambah Episode</button>
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Eps</th>
                            <th>Thumbnail</th>
                            <th>Judul Episode</th>
                            <th>Season (Induk)</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($eps = mysqli_fetch_assoc($semua_episode)): ?>
                            <tr>
                                <td><?php echo $eps['eps_num']; ?></td>
                                <td><img src="../../../public/assets/img/<?php echo $eps['thumbnail']; ?>" alt="Thumb" style="width: 80px; height: 45px; object-fit: cover; border-radius: 4px;" onerror="this.src='https://placehold.co/80x45/1A1A1A/C5A55A?text=Eps'"></td>
                                <td><strong><?php echo $eps['judul_eps']; ?></strong></td>
                                <td><?php echo $eps['nama_film'] ? $eps['nama_film'] : 'Film Dihapus'; ?></td>
                                <td><?php echo $eps['durasi']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action-edit" onclick="window.location.href='edit-episode.php?id=<?php echo $eps['id']; ?>'">&#128393; Edit</button>
                                        <a href="../../controllers/AdminController.php?hapus=episode&id=<?php echo $eps['id']; ?>" class="btn-action-delete" onclick="return confirm('Yakin ingin menghapus episode ini?')">&#128465; Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="tab-kelola-faksi" class="admin-section">
            <div class="admin-header-title-flex">
                <div>
                    <h2>Kelola Faksi / Great Houses</h2>
                    <p>Manajemen data aliansi agung di tanah Westeros.</p>
                </div>
                <button class="btn-admin-add" onclick="window.location.href='tambah-faksi.php'">+ Tambah Faksi Baru</button>
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Lambang</th>
                            <th>Nama House / Faksi</th>
                            <th>Kutipan / Motto</th>
                            <th>Wilayah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($faksi = mysqli_fetch_assoc($semua_faksi)): ?>
                            <tr>
                                <td><img src="../../../public/assets/img/<?php echo $faksi['poster']; ?>" alt="Sigil" class="table-img-contain" onerror="this.src='https://placehold.co/50x50/1A1A1A/C5A55A?text=Sigil'"></td>
                                <td><strong><?php echo $faksi['nama_faksi']; ?></strong></td>
                                <td>"<?php echo $faksi['motto']; ?>"</td>
                                <td><?php echo $faksi['wilayah']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action-edit" onclick="window.location.href='edit-faksi.php?id=<?php echo $faksi['id']; ?>'">&#128393; Edit</button>
                                        <a href="../../controllers/AdminController.php?hapus=faksi&id=<?php echo $faksi['id']; ?>" class="btn-action-delete" onclick="return confirm('Yakin ingin menghapus faksi ini?')">&#128465; Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="tab-kelola-anggota" class="admin-section">
            <div class="admin-header-title-flex">
                <div>
                    <h2>Kelola Anggota Faksi</h2>
                    <p>Manajemen data karakter, ksatria, dan penguasa di setiap House.</p>
                </div>
                <button class="btn-admin-add" onclick="window.location.href='tambah-anggota.php'">+ Tambah Anggota</button>
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Potret</th>
                            <th>Nama Karakter</th>
                            <th>Gelar / Peran</th>
                            <th>Faksi (House)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($anggota = mysqli_fetch_assoc($semua_anggota)): ?>
                            <tr>
                                <td><img src="../../../public/assets/img/<?php echo $anggota['foto_karakter']; ?>" alt="Foto" class="table-img" onerror="this.src='https://placehold.co/40x60/1A1A1A/C5A55A?text=Foto'"></td>
                                <td><strong><?php echo $anggota['nama_karakter']; ?></strong></td>
                                <td><?php echo $anggota['gelar']; ?></td>
                                <td><?php echo $anggota['nama_faksi'] ? $anggota['nama_faksi'] : 'Tidak Berafiliasi'; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action-edit" onclick="window.location.href='edit-anggota.php?id=<?php echo $anggota['id']; ?>'">&#128393; Edit</button>
                                        <a href="../../controllers/AdminController.php?hapus=anggota&id=<?php echo $anggota['id']; ?>" class="btn-action-delete" onclick="return confirm('Yakin ingin menghapus anggota ini?')">&#128465; Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="tab-kelola-user" class="admin-section">
            <div class="admin-header-title">
                <h2>Kelola Pengguna (Users)</h2>
                <p>Daftar seluruh ksatria dan rakyat yang terdaftar di dalam sistem database.</p>
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Faksi Terpilih</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($semua_user)): ?>
                            <tr>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['nama_lengkap']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['nama_faksi'] ? $user['nama_faksi'] : 'Belum Memilih'; ?></td>
                                <td>
                                    <?php if ($user['role'] == 'admin'): ?>
                                        <span class="status-badge warning" style="color:#000;">Admin</span>
                                    <?php else: ?>
                                        <span class="status-badge success">User</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($user['role'] == 'admin'): ?>
                                            <button class="btn-action-delete" style="opacity: 0.5; cursor: not-allowed;" disabled>Ban</button>
                                        <?php else: ?>
                                            <a href="../../controllers/AdminController.php?hapus=user&id=<?php echo $user['id']; ?>" class="btn-action-delete" onclick="return confirm('Yakin ingin menghapus pengguna ini secara permanen?')">&#128465; Ban</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</div>

<script>
    function switchTab(tabId) {
        const sections = document.querySelectorAll('.admin-section');
        sections.forEach(sec => sec.classList.remove('active'));

        const links = document.querySelectorAll('.sidebar-link');
        links.forEach(link => link.classList.remove('active'));

        document.getElementById('tab-' + tabId).classList.add('active');
        event.currentTarget.classList.add('active');
    }

    window.onload = function() {
        if (window.location.hash) {
            let tabId = window.location.hash.substring(1);
            let targetTab = document.getElementById('tab-' + tabId);
            if (targetTab) {
                switchTab(tabId);
                document.querySelectorAll('.sidebar-link').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + tabId) {
                        link.classList.add('active');
                    }
                });
            }
        }
    }
</script>

<?php include '../includes/footer.php'; ?>