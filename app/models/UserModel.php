<?php
// app/models/UserModel.php

class UserModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    // Fungsi Mendaftar User Baru
    public function register($fullname, $username, $email, $password)
    {
        // Membersihkan input agar aman dari SQL Injection
        $fullname = mysqli_real_escape_string($this->db, $fullname);
        $username = mysqli_real_escape_string($this->db, $username);
        $email    = mysqli_real_escape_string($this->db, $email);

        // Cek apakah username atau email sudah pernah dipakai
        $cek = mysqli_query($this->db, "SELECT * FROM users WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            return "Username atau Email sudah digunakan penghuni Realm lain!";
        }

        // Enkripsi password (Wajib agar aman)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan data ke database
        $query = "INSERT INTO users (nama_lengkap, username, email, password, role) 
                  VALUES ('$fullname', '$username', '$email', '$hashed_password', 'user')";

        if (mysqli_query($this->db, $query)) {
            return true;
        } else {
            return "Gagal bergabung: " . mysqli_error($this->db);
        }
    }

    // Fungsi Cek Login
    public function login($username, $password)
    {
        $username = mysqli_real_escape_string($this->db, $username);

        // Cari user berdasarkan username
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($this->db, $query);

        // Jika username ditemukan
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Cocokkan password yang diketik dengan password acak di database
            if (password_verify($password, $user['password'])) {
                return $user; // Sukses, kembalikan data user
            }
        }
        return false; // Gagal login
    }
}
