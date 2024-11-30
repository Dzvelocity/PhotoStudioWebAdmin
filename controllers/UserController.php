<?php
require_once 'models/User.php';

class UserController {
    private $user;

    // Konstruktor untuk menginisialisasi model User
    public function __construct() {
        $this->user = new User();
    }

    public function checkLoggedIn() {
        if (isset($_SESSION['username'])) {
            header('Location: index.php?page=home');
            exit();
        }
    }
    
    public function login() {
        $this->checkLoggedIn();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user_id = $this->user->authenticate($username, $password);
            if ($user_id) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user_id; // Tambahkan baris ini
                header('Location: index.php?page=home');
                exit();
            } else {
                $error = "Invalid login credentials.";
            }
        }
        require 'views/users/login.php';
    }

    private function validateRegistrationData($data) {
        $errors = [];
    
        // Validasi username
        if (empty($data['username'])) {
            $errors[] = "Username harus diisi";
        } elseif (strlen($data['username']) < 4) {
            $errors[] = "Username minimal 4 karakter";
        } elseif ($this->user->checkUsernameExists($data['username'])) {
            $errors[] = "Username sudah terdaftar";
        }
    
        // Validasi password
        if (empty($data['password'])) {
            $errors[] = "Password harus diisi";
        } elseif (strlen($data['password']) < 6) {
            $errors[] = "Password minimal 6 karakter";
        } 
        
        // Validasi konfirmasi password
        if (empty($data['confirm_password'])) {
            $errors[] = "Konfirmasi password harus diisi";
        } elseif ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Konfirmasi password tidak cocok";
        }
    
        return $errors;
    }
    public function register() {
        $this->checkLoggedIn();

        // Proses registrasi
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi input
            $errors = $this->validateRegistrationData($_POST);

            if (empty($errors)) {
                // Siapkan data untuk disimpan
                $userData = [
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'role' => 'user' // Default role
                ];

                // Proses registrasi
                if ($this->user->register($userData)) {
                    // Redirect ke halaman login dengan pesan sukses
                    $_SESSION['success_message'] = "Registrasi berhasil. Silakan login.";
                    header('Location: index.php?page=user&action=login');
                    exit();
                } else {
                    $error = "Gagal melakukan registrasi";
                }
            }
        }

        // Tampilkan view registrasi
        require 'views/users/register.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?page=user&action=login');
    }
}
?>