<?php
session_start();

require_once 'config/db.php';

function autoloadController($className) {
    $filename = 'controllers/' . $className . '.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
}
spl_autoload_register('autoloadController');

$page = $_GET['page'] ?? 'get_started';
$action = $_GET['action'] ?? 'index';

$publicPages = ['get_started', 'user'];
$publicActions = ['login', 'register'];

if (!in_array($page, $publicPages) || 
    ($page === 'user' && !in_array($action, $publicActions))) {
    if (!isset($_SESSION['username'])) {
        header('Location: index.php?page=user&action=login');
        exit();
    }
}

try {
    switch ($page) {
        case 'get_started':
            $controller = new GetStartedController();
            $controller->index();
            break;
        case 'home':
            $controller = new HomeController();
            $controller->index();
            break;
        case 'user':
            $controller = new UserController();
            if ($action == 'login') {
                $controller->login();
            } elseif ($action == 'logout') {
                $controller->logout();
            } elseif ($action == 'register') {
                $controller->register();
            }
            break;
        case 'item':
            $controller = new ItemController();
            if ($action === 'add') {
                $controller->add();
            } elseif ($action === 'edit') {
                $controller->edit();
            } elseif ($action === 'delete') {
                $controller->delete();
            } elseif ($action === 'detail') {
                $controller->detail();
            } elseif ($action === 'view_image') {
                $controller->view_image();
            }
            break;
        default:
            header('Location: index.php?page=get_started');
            exit();
    }
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>