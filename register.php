<?php
session_start(); 
require 'db.php'; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $insertQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();

        header("Location: login.php");
        exit();
    } else {
        $message = "Akun sudah pernah terdaftar!"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    
    <?php if ($message): ?>
        <p style="color: red;"><?php echo $message; ?></p> 
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
