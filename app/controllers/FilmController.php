<?php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../models/FilmModel.php';

class FilmController
{
    public function index()
    {
        global $koneksi;

        $filmModel = new FilmModel($koneksi);

        $semua_film = $filmModel->getAllFilm();

        $page = 'film';

        require_once __DIR__ . '/../views/home/film.php';
    }
}
