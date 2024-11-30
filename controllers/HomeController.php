<?php
require_once 'models/Item.php';
require_once 'models/User.php';

class HomeController {
    public function index() {
        // Periksa apakah user sudah login
        if (!isset($_SESSION['username'])) {
            header('Location: index.php?page=user&action=login');
            exit();
        }
        
        // Tambahkan pengecekan user_id
        if (!isset($_SESSION['user_id'])) {
            // Jika user_id tidak ada, coba ambil dari database
            $userModel = new User(); // Pastikan Anda sudah mengimpor model User
            $user_id = $userModel->getUserIdByUsername($_SESSION['username']);
            
            if ($user_id) {
                $_SESSION['user_id'] = $user_id;
            } else {
                // Jika tidak bisa mendapatkan user_id, logout paksa
                session_destroy();
                header('Location: index.php?page=user&action=login');
                exit();
            }
        }
        
        // Lanjutkan dengan proses sebelumnya
        $itemModel = new Item();
        $items = $itemModel->getAllItems($_SESSION['user_id']);
        require 'views/items/index.php';
    }
}
?>