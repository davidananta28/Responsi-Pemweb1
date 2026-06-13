<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../../../config/koneksi.php';

if (isset($_POST['edit_profile'])) {
    $id_user      = intval($_SESSION['user_id']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $gelar        = mysqli_real_escape_string($koneksi, $_POST['gelar']);
    $kutipan      = mysqli_real_escape_string($koneksi, $_POST['kutipan']);
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $id_faksi     = intval($_POST['id_faksi']);

    $foto_lama = $_POST['foto_lama'];
    $foto_profil = $foto_lama;

    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../../public/assets/img/";
        $nama_file = time() . '_' . basename($_FILES['foto_profil']['name']);
        $target_file = $target_dir . $nama_file;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)) {
                if (!empty($foto_lama) && $foto_lama != 'profile.png' && file_exists($target_dir . $foto_lama)) {
                    unlink($target_dir . $foto_lama);
                }
                $foto_profil = $nama_file;
            }
        }
    }

    $cek = mysqli_query($koneksi, "SELECT id FROM users WHERE (username='$username' OR email='$email') AND id != '$id_user'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['error'] = "Username atau Email sudah digunakan penghuni Realm lain!";
        header("Location: ../admin/edit-profile.php");
        exit;
    }

    $query = "UPDATE users SET 
              nama_lengkap='$nama_lengkap', 
              gelar='$gelar', 
              kutipan='$kutipan', 
              username='$username', 
              email='$email', 
              id_faksi='$id_faksi', 
              foto_profil='$foto_profil' 
              WHERE id='$id_user'";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Profil berhasil diperbarui!";
        header("Location: profile.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal memperbarui profil: " . mysqli_error($koneksi);
        header("Location: ../admin/edit-profile.php");
        exit;
    }
}

header("Location: profile.php");
exit;
