<?php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../models/FaksiModel.php';
require_once __DIR__ . '/../models/FilmModel.php';

class HomeController
{
    public function index()
    {
        global $koneksi;

        $faksiModel = new FaksiModel($koneksi);
        $filmModel  = new FilmModel($koneksi);

        $faksi_beranda = $faksiModel->getLimitFaksi(5);
        $film_beranda  = $filmModel->getLimitFilm(3);

        $page = 'beranda';

        require_once __DIR__ . '/../views/home/index.php';
    }
}
