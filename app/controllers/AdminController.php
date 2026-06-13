<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/home/index.php");
    exit;
}

include '../../config/koneksi.php';
include '../models/AdminModel.php';

$adminModel = new AdminModel($koneksi);

function uploadGambar($file, $target_dir = "../../../public/assets/img/")
{
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $nama_file = time() . '_' . basename($file["name"]);
    $target_file = $target_dir . $nama_file;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return false;
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $nama_file;
    }
    return false;
}

function sistemUpdateGambar($file, $gambar_lama, $target_dir = "../../../public/assets/img/")
{
    $gambar_baru = uploadGambar($file, $target_dir);

    if ($gambar_baru) {
        if (!empty($gambar_lama) && $gambar_lama != 'placeholder.jpg' && file_exists($target_dir . $gambar_lama)) {
            unlink($target_dir . $gambar_lama);
        }
        return $gambar_baru;
    }

    return $gambar_lama;
}

if (isset($_POST['tambah_faksi'])) {
    $nama_faksi = $_POST['nama_faksi'];
    $motto      = $_POST['motto'];
    $wilayah    = $_POST['wilayah'];
    $senjata    = $_POST['senjata'];
    $deskripsi  = $_POST['deskripsi'];

    $poster = uploadGambar($_FILES['poster']);
    if (!$poster) {
        $poster = 'placeholder.jpg'; // Gambar default jika gagal upload
    }

    $simpan = $adminModel->tambahFaksi($nama_faksi, $motto, $wilayah, $senjata, $deskripsi, $poster);

    if ($simpan) {
        header("Location: ../views/admin/admin.php#kelola-faksi");
        exit;
    } else {
        echo "Gagal menambahkan faksi: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['edit_faksi'])) {
    $id         = intval($_POST['id']);
    $nama_faksi = $_POST['nama_faksi'];
    $motto      = $_POST['motto'];
    $wilayah    = $_POST['wilayah']; // Note: Sebelumnya di form kita pakai name="wilayah" untuk Kastil Utama
    $senjata    = $_POST['senjata'];
    $deskripsi  = $_POST['deskripsi'];

    $poster_lama = $_POST['poster_lama'];

    $poster = sistemUpdateGambar($_FILES['poster'], $poster_lama);

    $simpan = $adminModel->editFaksi($id, $nama_faksi, $motto, $wilayah, $senjata, $deskripsi, $poster);

    if ($simpan) {
        header("Location: ../views/admin/admin.php#kelola-faksi");
        exit;
    } else {
        echo "Gagal memperbarui faksi: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['tambah_film'])) {
    $judul    = $_POST['judul'];
    $durasi   = $_POST['durasi']; // Berisi 'Jumlah Episode'
    $tahun    = $_POST['tahun'];
    $sinopsis = $_POST['sinopsis'];

    $poster = uploadGambar($_FILES['poster']);
    $banner = uploadGambar($_FILES['banner_hero']);

    if (!$poster) {
        $poster = 'placeholder.jpg';
    }
    if (!$banner) {
        $banner = 'placeholder.jpg';
    }

    $simpan = $adminModel->tambahFilm($judul, $durasi, $tahun, $sinopsis, $poster, $banner);

    if ($simpan) {
        header("Location: ../views/admin/admin.php#kelola-film");
        exit;
    } else {
        echo "Gagal menambahkan season: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['edit_film'])) {
    $id       = intval($_POST['id']);
    $judul    = $_POST['judul'];
    $durasi   = $_POST['durasi'];
    $tahun    = $_POST['tahun'];
    $sinopsis = $_POST['sinopsis'];

    $poster_lama = $_POST['poster_lama'];
    $banner_lama = $_POST['banner_lama'];

    $poster = sistemUpdateGambar($_FILES['poster'], $poster_lama);
    $banner = sistemUpdateGambar($_FILES['banner_hero'], $banner_lama);

    $simpan = $adminModel->editFilm($id, $judul, $durasi, $tahun, $sinopsis, $poster, $banner);

    if ($simpan) {
        header("Location: ../views/admin/admin.php#kelola-film");
        exit;
    } else {
        echo "Gagal memperbarui season: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['tambah_anggota'])) {
    $nama_karakter = $_POST['nama_karakter'];
    $gelar         = $_POST['gelar'];
    $id_faksi      = $_POST['id_faksi'];
    $bio           = isset($_POST['bio']) ? $_POST['bio'] : '';

    $foto = uploadGambar($_FILES['foto_karakter']);
    if (!$foto) {
        $foto = 'placeholder.jpg';
    }

    $simpan = $adminModel->tambahAnggota($nama_karakter, $gelar, $id_faksi, $bio, $foto);

    if ($simpan) {
        header("Location: ../views/admin/admin.php#kelola-anggota");
        exit;
    } else {
        echo "Gagal menambahkan anggota: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['edit_anggota'])) {
    $id            = intval($_POST['id']);
    $nama_karakter = $_POST['nama_karakter'];
    $gelar         = $_POST['gelar'];
    $id_faksi      = $_POST['id_faksi'];
    $bio           = isset($_POST['bio']) ? $_POST['bio'] : '';

    $foto_lama = $_POST['foto_lama'];
    $foto = sistemUpdateGambar($_FILES['foto_karakter'], $foto_lama);

    $simpan = $adminModel->editAnggota($id, $nama_karakter, $gelar, $id_faksi, $bio, $foto);

    if ($simpan) {
        header("Location: ../views/admin/admin.php#kelola-anggota");
        exit;
    } else {
        echo "Gagal memperbarui anggota: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['tambah_episode'])) {
    $id_film   = $_POST['id_film'];
    $eps_num   = $_POST['eps_num'];
    $durasi    = $_POST['durasi'];
    $judul_eps = $_POST['judul_eps'];
    $video_url = $_POST['video_url'];
    $deskripsi = $_POST['deskripsi'];

    $thumbnail = uploadGambar($_FILES['thumbnail']);
    if (!$thumbnail) {
        $thumbnail = 'placeholder.jpg';
    }

    $simpan = $adminModel->tambahEpisode($id_film, $eps_num, $durasi, $judul_eps, $video_url, $deskripsi, $thumbnail);

    if ($simpan) {
        header("Location: ../views/admin/admin.php#kelola-episode");
        exit;
    } else {
        echo "Gagal menambahkan episode: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['edit_episode'])) {
    $id        = intval($_POST['id']);
    $id_film   = $_POST['id_film'];
    $eps_num   = $_POST['eps_num'];
    $durasi    = $_POST['durasi'];
    $judul_eps = $_POST['judul_eps'];
    $video_url = $_POST['video_url'];
    $deskripsi = $_POST['deskripsi'];

    $thumbnail_lama = $_POST['thumbnail_lama'];
    $thumbnail = sistemUpdateGambar($_FILES['thumbnail'], $thumbnail_lama);

    $simpan = $adminModel->editEpisode($id, $id_film, $eps_num, $durasi, $judul_eps, $video_url, $deskripsi, $thumbnail);

    if ($simpan) {
        header("Location: ../views/admin/admin.php#kelola-episode");
        exit;
    } else {
        echo "Gagal memperbarui episode: " . mysqli_error($koneksi);
    }
}

if (isset($_GET['hapus']) && isset($_GET['id'])) {
    $tipe = $_GET['hapus'];
    $id   = intval($_GET['id']);

    switch ($tipe) {
        case 'faksi':
            $adminModel->hapusFaksi($id);
            $tab = 'kelola-faksi';
            break;
        case 'film':
            $adminModel->hapusFilm($id);
            $tab = 'kelola-film';
            break;
        case 'episode':
            $adminModel->hapusEpisode($id);
            $tab = 'kelola-episode';
            break;
        case 'anggota':
            $adminModel->hapusAnggota($id);
            $tab = 'kelola-anggota';
            break;
        case 'user':
            $adminModel->hapusUser($id);
            $tab = 'kelola-user';
            break;
        default:
            $tab = 'dashboard';
    }

    header("Location: ../views/admin/admin.php#$tab");
    exit;
}
