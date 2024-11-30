<?php
require_once __DIR__ . '/../config/db.php'; 

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    
        if ($result && password_verify($password, $result['password'])) {
            return $result['id']; // Kembalikan ID user
        }
        return false;
    }

    public function getUserIdByUsername($username) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }
        
        return false;
    }

    public function checkUsernameExists($username) {
        $query = "SELECT COUNT(*) FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }

    public function register($userData) {
        try {
            $query = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            
            // Hash password
            $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
    
            $stmt->bind_param("ss", 
                $userData['username'], 
                $hashedPassword
            );
    
            $result = $stmt->execute();
            $stmt->close();
    
            return $result;
        } catch (Exception $e) {
            // Log error
            error_log("Registrasi error: " . $e->getMessage());
            return false;
        }
    }
}
?>