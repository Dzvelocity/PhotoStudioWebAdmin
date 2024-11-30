<?php
class GetStartedController {
    public function __construct() {
        // Jika memerlukan inisialisasi tambahan
    }

    public function index() {
        // Jika sudah login, redirect ke home
        if (isset($_SESSION['username'])) {
            header('Location: index.php?page=home');
            exit();
        }
        
        require_once 'views/start/get_started.php';
    }
}