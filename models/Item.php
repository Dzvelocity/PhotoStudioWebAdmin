<?php
require_once 'config/db.php';

class Item {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAllItems($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $row['images'] = $row['image'] ? explode(',', $row['image']) : [];
            $items[] = $row;
        }
        
        return $items;
    }
    
    public function getItemById($id, $user_id = null) {
        if ($user_id === null) {
            $stmt = $this->conn->prepare("SELECT * FROM items WHERE id = ?");
            $stmt->bind_param("i", $id);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $id, $user_id);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    public function getItemImages($id) {
        $stmt = $this->conn->prepare("SELECT image FROM items WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        
        return !empty($item['image']) ? explode(',', $item['image']) : [];
    }
    
    public function addItem($data, $user_id) {
        $conn = Database::getConnection();
        
        $stmt = $conn->prepare("INSERT INTO items (
            user_id,
            customer_name, 
            phone_number, 
            photo_date, 
            image, 
            num_files, 
            num_print, 
            price
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param(
            "issssiid", 
            $user_id, 
            $data['customer_name'], 
            $data['phone_number'], 
            $data['photo_date'], 
            $data['image'], 
            $data['num_files'], 
            $data['num_print'], 
            $data['price']
        );
        
        $result = $stmt->execute();
        
        if (!$result) {
            error_log("Error adding item: " . $stmt->error);
        }
        
        return $result;
    }
    
    public function deleteItem($id, $user_id) {
        $stmt = $this->conn->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        
        $result = $stmt->execute();
        
        if (!$result) {
            error_log("Error deleting item: " . $stmt->error);
        }
        
        return $result;
    }
    
    public function updateItem($data) {
        $existingItem = $this->getItemById($data['id']);
        $existingImages = !empty($existingItem['image']) ? explode(',', $existingItem['image']) : [];
        
        $newUploadedImages = $existingImages; 
    
        for ($i = 0; $i < count($existingImages); $i++) {
            if (isset($_FILES['image_' . $i]) && $_FILES['image_' . $i]['error'] == UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                
                if (!empty($existingImages[$i]) && file_exists($uploadDir . $existingImages[$i])) {
                    unlink($uploadDir . $existingImages[$i]);
                }
    
                $fileName = time() . '_' . basename($_FILES['image_' . $i]['name']);
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image_' . $i]['tmp_name'], $uploadPath)) {
                    $newUploadedImages[$i] = $fileName; 
                }
            }
        }
    
        $imageString = implode(',', $newUploadedImages);
    
        $sql = "UPDATE items SET 
                customer_name=?, 
                phone_number=?, 
                photo_date=?, 
                image=?, 
                num_files=?, 
                num_print=?, 
                price=? 
                WHERE id=?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssiidi", 
            $data['customer_name'], 
            $data['phone_number'], 
            $data['photo_date'], 
            $imageString, 
            $data['num_files'], 
            $data['num_print'], 
            $data['price'],
            $data['id']
        );
    
        $result = $stmt->execute();
    
        if (!$result) {
            error_log("Update item error: " . $stmt->error);
        }
    
        return $result;
    }
}
?>
