<?php
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../models/FaksiModel.php';

class FaksiController
{
    public function index()
    {
        global $koneksi;

        $faksiModel = new FaksiModel($koneksi);

        $semua_faksi = $faksiModel->getAllFaksi();

        $page = 'faksi';

        require_once __DIR__ . '/../views/home/faksi.php';
    }
}
