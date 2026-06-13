<?php
class FilmModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getAllFilm()
    {
        return mysqli_query($this->db, "SELECT * FROM film ORDER BY id DESC");
    }

    public function getLimitFilm($limit)
    {
        $limit = intval($limit);
        return mysqli_query($this->db, "SELECT * FROM film ORDER BY id DESC LIMIT $limit");
    }

    public function getFilmById($id)
    {
        $id = intval($id);
        $result = mysqli_query($this->db, "SELECT * FROM film WHERE id = '$id'");
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
}
