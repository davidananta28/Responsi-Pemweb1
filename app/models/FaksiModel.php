<?php
class FaksiModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getAllFaksi()
    {
        $query = "SELECT * FROM faksi ORDER BY id ASC";
        return mysqli_query($this->db, $query);
    }

    // Mengambil satu data faksi berdasarkan ID
    public function getFaksiById($id)
    {
        $id = intval($id);
        $query = "SELECT * FROM faksi WHERE id = '$id'";
        $result = mysqli_query($this->db, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
}
