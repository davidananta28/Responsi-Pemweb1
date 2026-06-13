<?php
session_start();

// Panggil koneksi dan model (Perhatikan arah mundur foldernya)
include '../../config/koneksi.php';
include '../models/UserModel.php';

class AuthController
{
    private $userModel;

    public function __construct($koneksi)
    {
        $this->userModel = new UserModel($koneksi);
    }

    // Aksi Register
    public function register()
    {
        if (isset($_POST['register'])) {
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $email    = $_POST['email'];
            $password = $_POST['password'];
            $confirm  = $_POST['confirm_password'];

            // Validasi Password
            if ($password !== $confirm) {
                $_SESSION['error'] = "Password konfirmasi tidak cocok!";
                header("Location: ../views/auth/register.php");
                exit;
            }

            // Panggil Model
            $proses = $this->userModel->register($fullname, $username, $email, $password);

            if ($proses === true) {
                $_SESSION['success'] = "Berhasil bergabung! Silakan Sign In.";
                header("Location: ../views/auth/register.php");
            } else {
                $_SESSION['error'] = $proses;
                header("Location: ../views/auth/register.php");
            }
            exit;
        }
    }

    // Aksi Login
    public function login()
    {
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Panggil Model
            $user = $this->userModel->login($username, $password);

            if ($user) {
                // Set Sesi Login
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];

                // Redirect berdasarkan Role
                if ($user['role'] == 'admin') {
                    header("Location: ../views/admin/admin.php");
                } else {
                    header("Location: ../views/home/index.php");
                }
            } else {
                $_SESSION['error'] = "Username atau Password salah!";
                header("Location: ../views/auth/login.php");
            }
            exit;
        }
    }

    // Aksi Logout
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: ../views/auth/login.php");
        exit;
    }
}

// =======================================================
// ROUTING SEDERHANA CONTROLLER
// =======================================================
$auth = new AuthController($koneksi);

// Tangkap 'action' dari URL untuk menentukan fungsi mana yang dijalankan
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'register') {
        $auth->register();
    } elseif ($_GET['action'] == 'login') {
        $auth->login();
    } elseif ($_GET['action'] == 'logout') {
        $auth->logout();
    }
}
