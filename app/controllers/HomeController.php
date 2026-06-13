<?php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../models/FaksiModel.php';
require_once __DIR__ . '/../models/FilmModel.php';

class HomeController
{
    public function index()
    {
        global $koneksi;

        // 1. Panggil Model
        $faksiModel = new FaksiModel($koneksi);
        $filmModel  = new FilmModel($koneksi);

        // 2. Ambil data (5 Faksi, 3 Film)
        $faksi_beranda = $faksiModel->getLimitFaksi(5);
        $film_beranda  = $filmModel->getLimitFilm(3);

        // Siapkan nama halaman untuk Header
        $page = 'beranda';

        // 3. Lempar data ke View
        require_once __DIR__ . '/../views/home/index.php';
    }
}
