<?php
require_once 'models/Item.php';

class ItemController {
    public function add() {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php?page=user&action=login');
            exit();
        }
    
        // Pastikan user_id tersedia
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=user&action=login');
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item = new Item();
            
            // Proses upload gambar
            $uploadedImages = [];
            if (!empty($_FILES['image']['name'][0])) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                foreach ($_FILES['image']['name'] as $key => $name) {
                    if ($_FILES['image']['error'][$key] == 0) {
                        $tmpName = $_FILES['image']['tmp_name'][$key];
                        $uniqueFilename = uniqid() . '_' . $name;
                        $destination = $uploadDir . $uniqueFilename;
                        
                        if (move_uploaded_file($tmpName, $destination)) {
                            $uploadedImages[] = $uniqueFilename;
                        }
                    }
                }
            }
    
            $data = [
                'customer_name' => $_POST['customer_name'],
                'phone_number' => $_POST['phone_number'],
                'photo_date' => $_POST['photo_date'],
                'image' => implode(',', $uploadedImages),
                'num_files' => $_POST['num_files'],
                'num_print' => $_POST['num_print'],
                'price' => $_POST['price']
            ];
    
            // Tambahkan user_id dari session
            if ($item->addItem($data, $_SESSION['user_id'])) {
                header('Location: index.php?page=home');
                exit();
            } else {
                $error = "Gagal menambahkan item";
            }
        }
    
        require 'views/items/add.php';
    }

    public function edit() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=user&action=login');
            exit();
        }
    
        $item = new Item();
        $id = $_GET['id'] ?? null;
    
        // Gunakan user_id dari session
        $itemData = $item->getItemById($id, $_SESSION['user_id']);
    
        if (!$itemData) {
            header('Location: index.php?page=home&error=item_not_found');
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Siapkan data untuk diupdate
            $data = [
                'id' => $id,
                'customer_name' => $_POST['customer_name'],
                'phone_number' => $_POST['phone_number'],
                'photo_date' => $_POST['photo_date'],
                'num_files' => $_POST['num_files'],
                'num_print' => $_POST['num_print'],
                'price' => $_POST['price']
            ];
    
            // Tambahkan debugging
            error_log("Updating item: " . print_r($data, true));
            error_log("Files: " . print_r($_FILES, true));
    
            if ($item->updateItem($data)) {
                header('Location: index.php?page=home');
                exit();
            } else {
                $error = "Gagal mengupdate item";
            }
        }
    
        require 'views/items/edit.php';
    }
    
    public function detail() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=user&action=login');
            exit();
        }
    
        $item = new Item();
        $id = $_GET['id'] ?? null;
    
        // Gunakan user_id dari session
        $itemData = $item->getItemById($id, $_SESSION['user_id']);
    
        if (!$itemData) {
            header('Location: index.php?page=home&error=item_not_found');
            exit();
        }
    
        // Pastikan images selalu array, bahkan jika kosong
        $images = !empty($itemData['image']) ? 
                  array_map(function($img) { 
                      return 'uploads/' . trim($img); 
                  }, explode(',', $itemData['image'])) : 
                  [];
    
        require 'views/items/detail.php';
    }
    
    public function delete() {
        // Pastikan user sudah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=user&action=login');
            exit();
        }
    
        // Periksa apakah ID item diberikan
        if (!isset($_GET['id'])) {
            header('Location: index.php?page=home&error=invalid_item');
            exit();
        }
    
        $id = $_GET['id'];
        $item = new Item();
    
        // Ambil data item untuk pengecekan
        $itemData = $item->getItemById($id, $_SESSION['user_id']);
    
        if (!$itemData) {
            header('Location: index.php?page=home&error=item_not_found');
            exit();
        }
    
        try {
            // Ambil daftar gambar
            $images = $item->getItemImages($id);
    
            // Hapus file gambar terkait jika ada
            if (!empty($images)) {
                foreach ($images as $imageName) {
                    $imagePath = 'uploads/' . trim($imageName);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
    
            // Hapus item dari database - PERHATIKAN PERUBAHAN DI SINI
            $deleteResult = $item->deleteItem($id, $_SESSION['user_id']);
            
            if ($deleteResult) {
                header('Location: index.php?page=home&success=item_deleted');
            } else {
                header('Location: index.php?page=home&error=delete_failed');
            }
            exit();
        } catch (Exception $e) {
            // Tangani error
            header('Location: index.php?page=home&error=' . urlencode($e->getMessage()));
            exit();
        }
    }

    public function view_image() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=user&action=login');
            exit();
        }
    
        $item = new Item();
        $id = $_GET['id'] ?? null;
    
        // Gunakan user_id dari session
        $itemData = $item->getItemById($id, $_SESSION['user_id']);
    
        if (!$itemData) {
            header('Location: index.php?page=home&error=item_not_found');
            exit();
        }
    
        // Pastikan images selalu array, bahkan jika kosong
        $images = !empty($itemData['image']) ? 
                  array_map(function($img) { 
                      return 'uploads/' . trim($img); 
                  }, explode(',', $itemData['image'])) : 
                  [];
    
        require 'views/items/view_image.php';
    }
}
?>
