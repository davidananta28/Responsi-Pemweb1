<?php
// Include koneksi dan model yang dibutuhkan
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../models/FaksiModel.php';

class FaksiController
{
    public function index()
    {
        global $koneksi;

        // 1. Panggil Model
        $faksiModel = new FaksiModel($koneksi);

        // 2. Ambil data
        $semua_faksi = $faksiModel->getAllFaksi();

        // Siapkan variabel untuk View
        $page = 'faksi';

        // 3. Lempar data ke View (View dipanggil di sini)
        require_once __DIR__ . '/../views/home/faksi.php';
    }
}
