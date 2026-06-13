<?php

class UserModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function register($fullname, $username, $email, $password)
    {
        $fullname = mysqli_real_escape_string($this->db, $fullname);
        $username = mysqli_real_escape_string($this->db, $username);
        $email    = mysqli_real_escape_string($this->db, $email);

        $cek = mysqli_query($this->db, "SELECT * FROM users WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            return "Username atau Email sudah digunakan penghuni Realm lain!";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (nama_lengkap, username, email, password, role) 
                  VALUES ('$fullname', '$username', '$email', '$hashed_password', 'user')";

        if (mysqli_query($this->db, $query)) {
            return true;
        } else {
            return "Gagal bergabung: " . mysqli_error($this->db);
        }
    }

    public function login($username, $password)
    {
        $username = mysqli_real_escape_string($this->db, $username);

        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($this->db, $query);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                return $user; // Sukses, kembalikan data user
            }
        }
        return false; // Gagal login
    }
}
