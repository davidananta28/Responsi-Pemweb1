<?php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../models/FilmModel.php';

class FilmController
{
    public function index()
    {
        global $koneksi;

        // 1. Panggil Model
        $filmModel = new FilmModel($koneksi);

        // 2. Ambil semua data film
        $semua_film = $filmModel->getAllFilm();

        // Siapkan nama halaman untuk Header
        $page = 'film';

        // 3. Lempar data ke View
        require_once __DIR__ . '/../views/home/film.php';
    }
}
