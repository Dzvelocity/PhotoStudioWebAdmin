<?php
class GetStartedController {
    public function __construct() {
    }

    public function index() {
        if (isset($_SESSION['username'])) {
            header('Location: index.php?page=home');
            exit();
        }
        
        require_once 'views/start/get_started.php';
    }
}