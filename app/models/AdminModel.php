<?php
// app/models/AdminModel.php

class AdminModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    // Mengambil total angka untuk Dashboard
    public function getDashboardStats()
    {
        $film  = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT COUNT(*) as total FROM film"))['total'];
        $faksi = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT COUNT(*) as total FROM faksi"))['total'];
        $user  = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT COUNT(*) as total FROM users WHERE role='user'"))['total'];

        return [
            'film' => $film,
            'faksi' => $faksi,
            'user' => $user
        ];
    }

    // Mengambil data Episode beserta Nama Season/Film-nya (JOIN)
    public function getAllEpisodeDetail()
    {
        $query = "SELECT episode.*, film.judul AS nama_film 
                  FROM episode 
                  LEFT JOIN film ON episode.id_film = film.id 
                  ORDER BY episode.id_film ASC, episode.eps_num ASC";
        return mysqli_query($this->db, $query);
    }

    // Mengambil data Anggota beserta Nama Faksi-nya (JOIN)
    public function getAllAnggotaDetail()
    {
        $query = "SELECT anggota_faksi.*, faksi.nama_faksi 
                  FROM anggota_faksi 
                  LEFT JOIN faksi ON anggota_faksi.id_faksi = faksi.id 
                  ORDER BY faksi.nama_faksi ASC, anggota_faksi.nama_karakter ASC";
        return mysqli_query($this->db, $query);
    }

    // Mengambil data User beserta Faksi favoritnya (JOIN)
    public function getAllUserDetail()
    {
        $query = "SELECT users.*, faksi.nama_faksi 
                  FROM users 
                  LEFT JOIN faksi ON users.id_faksi = faksi.id 
                  ORDER BY users.created_at DESC";
        return mysqli_query($this->db, $query);
    }

    // Menambahkan faksi baru ke database
    public function tambahFaksi($nama_faksi, $motto, $wilayah, $senjata, $deskripsi, $poster)
    {
        // Hindari SQL Injection
        $nama_faksi = mysqli_real_escape_string($this->db, $nama_faksi);
        $motto      = mysqli_real_escape_string($this->db, $motto);
        $wilayah    = mysqli_real_escape_string($this->db, $wilayah);
        $senjata    = mysqli_real_escape_string($this->db, $senjata);
        $deskripsi  = mysqli_real_escape_string($this->db, $deskripsi);

        $query = "INSERT INTO faksi (nama_faksi, motto, wilayah, senjata, deskripsi, poster) 
                  VALUES ('$nama_faksi', '$motto', '$wilayah', '$senjata', '$deskripsi', '$poster')";

        return mysqli_query($this->db, $query);
    }

    // Memperbarui data faksi yang sudah ada
    public function editFaksi($id, $nama_faksi, $motto, $wilayah, $senjata, $deskripsi, $poster)
    {
        $id         = intval($id); // Pastikan ID berupa angka
        $nama_faksi = mysqli_real_escape_string($this->db, $nama_faksi);
        $motto      = mysqli_real_escape_string($this->db, $motto);
        $wilayah    = mysqli_real_escape_string($this->db, $wilayah);
        $senjata    = mysqli_real_escape_string($this->db, $senjata);
        $deskripsi  = mysqli_real_escape_string($this->db, $deskripsi);

        $query = "UPDATE faksi SET 
                  nama_faksi='$nama_faksi', 
                  motto='$motto', 
                  wilayah='$wilayah', 
                  senjata='$senjata', 
                  deskripsi='$deskripsi', 
                  poster='$poster' 
                  WHERE id='$id'";

        return mysqli_query($this->db, $query);
    }

    public function tambahFilm($judul, $durasi, $tahun, $sinopsis, $poster, $banner)
    {
        $judul    = mysqli_real_escape_string($this->db, $judul);
        $durasi   = mysqli_real_escape_string($this->db, $durasi);
        $tahun    = intval($tahun);
        $sinopsis = mysqli_real_escape_string($this->db, $sinopsis);

        $query = "INSERT INTO film (judul, sinopsis, poster, banner_hero, durasi, tahun) 
                  VALUES ('$judul', '$sinopsis', '$poster', '$banner', '$durasi', '$tahun')";
        return mysqli_query($this->db, $query);
    }

    public function editFilm($id, $judul, $durasi, $tahun, $sinopsis, $poster, $banner)
    {
        $id       = intval($id);
        $judul    = mysqli_real_escape_string($this->db, $judul);
        $durasi   = mysqli_real_escape_string($this->db, $durasi);
        $tahun    = intval($tahun);
        $sinopsis = mysqli_real_escape_string($this->db, $sinopsis);

        $query = "UPDATE film SET 
                  judul='$judul', sinopsis='$sinopsis', poster='$poster', banner_hero='$banner', durasi='$durasi', tahun='$tahun' 
                  WHERE id='$id'";
        return mysqli_query($this->db, $query);
    }

    // ==========================================
    // HAPUS DATA
    // ==========================================
    public function hapusFaksi($id)
    {
        $id = intval($id);
        return mysqli_query($this->db, "DELETE FROM faksi WHERE id='$id'");
    }

    public function hapusFilm($id)
    {
        $id = intval($id);
        // Hapus juga episode-episode yang terkait dengan film ini
        mysqli_query($this->db, "DELETE FROM episode WHERE id_film='$id'");
        return mysqli_query($this->db, "DELETE FROM film WHERE id='$id'");
    }

    public function hapusUser($id)
    {
        $id = intval($id);
        return mysqli_query($this->db, "DELETE FROM users WHERE id='$id' AND role != 'admin'");
    }

    // ==========================================
    // ANGGOTA FAKSI (CRUD)
    // ==========================================
    public function getAnggotaById($id)
    {
        $id = intval($id);
        $result = mysqli_query($this->db, "SELECT * FROM anggota_faksi WHERE id='$id'");
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }

    public function tambahAnggota($nama_karakter, $gelar, $id_faksi, $bio, $foto)
    {
        $nama_karakter = mysqli_real_escape_string($this->db, $nama_karakter);
        $gelar         = mysqli_real_escape_string($this->db, $gelar);
        $id_faksi      = intval($id_faksi);
        $bio           = mysqli_real_escape_string($this->db, $bio);

        $query = "INSERT INTO anggota_faksi (nama_karakter, gelar, id_faksi, bio, foto_karakter) 
                  VALUES ('$nama_karakter', '$gelar', '$id_faksi', '$bio', '$foto')";
        return mysqli_query($this->db, $query);
    }

    public function editAnggota($id, $nama_karakter, $gelar, $id_faksi, $bio, $foto)
    {
        $id            = intval($id);
        $nama_karakter = mysqli_real_escape_string($this->db, $nama_karakter);
        $gelar         = mysqli_real_escape_string($this->db, $gelar);
        $id_faksi      = intval($id_faksi);
        $bio           = mysqli_real_escape_string($this->db, $bio);

        $query = "UPDATE anggota_faksi SET 
                  nama_karakter='$nama_karakter', gelar='$gelar', id_faksi='$id_faksi', bio='$bio', foto_karakter='$foto' 
                  WHERE id='$id'";
        return mysqli_query($this->db, $query);
    }

    public function hapusAnggota($id)
    {
        $id = intval($id);
        return mysqli_query($this->db, "DELETE FROM anggota_faksi WHERE id='$id'");
    }

    // ==========================================
    // EPISODE (CRUD)
    // ==========================================
    public function getEpisodeById($id)
    {
        $id = intval($id);
        $result = mysqli_query($this->db, "SELECT * FROM episode WHERE id='$id'");
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }

    public function tambahEpisode($id_film, $eps_num, $durasi, $judul_eps, $video_url, $deskripsi, $thumbnail)
    {
        $id_film   = intval($id_film);
        $eps_num   = intval($eps_num);
        $durasi    = mysqli_real_escape_string($this->db, $durasi);
        $judul_eps = mysqli_real_escape_string($this->db, $judul_eps);
        $video_url = mysqli_real_escape_string($this->db, $video_url);
        $deskripsi = mysqli_real_escape_string($this->db, $deskripsi);

        $query = "INSERT INTO episode (id_film, eps_num, durasi, judul_eps, video_url, deskripsi, thumbnail) 
                  VALUES ('$id_film', '$eps_num', '$durasi', '$judul_eps', '$video_url', '$deskripsi', '$thumbnail')";
        return mysqli_query($this->db, $query);
    }

    public function editEpisode($id, $id_film, $eps_num, $durasi, $judul_eps, $video_url, $deskripsi, $thumbnail)
    {
        $id        = intval($id);
        $id_film   = intval($id_film);
        $eps_num   = intval($eps_num);
        $durasi    = mysqli_real_escape_string($this->db, $durasi);
        $judul_eps = mysqli_real_escape_string($this->db, $judul_eps);
        $video_url = mysqli_real_escape_string($this->db, $video_url);
        $deskripsi = mysqli_real_escape_string($this->db, $deskripsi);

        $query = "UPDATE episode SET 
                  id_film='$id_film', eps_num='$eps_num', durasi='$durasi', judul_eps='$judul_eps', 
                  video_url='$video_url', deskripsi='$deskripsi', thumbnail='$thumbnail' 
                  WHERE id='$id'";
        return mysqli_query($this->db, $query);
    }

    public function hapusEpisode($id)
    {
        $id = intval($id);
        return mysqli_query($this->db, "DELETE FROM episode WHERE id='$id'");
    }
}
