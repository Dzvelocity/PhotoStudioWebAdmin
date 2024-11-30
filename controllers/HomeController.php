<?php
require_once 'models/Item.php';
require_once 'models/User.php';

class HomeController {
    public function index() {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php?page=user&action=login');
            exit();
        }
        
        if (!isset($_SESSION['user_id'])) {
            $userModel = new User(); 
            $user_id = $userModel->getUserIdByUsername($_SESSION['username']);
            
            if ($user_id) {
                $_SESSION['user_id'] = $user_id;
            } else {
                session_destroy();
                header('Location: index.php?page=user&action=login');
                exit();
            }
        }
        
        $itemModel = new Item();
        $items = $itemModel->getAllItems($_SESSION['user_id']);
        require 'views/items/index.php';
    }
}
?>