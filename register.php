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
        $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        $conn->query($insertQuery);
    
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
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div style="background-color: #f3f3f3; padding: 20px; border-radius: 10px;">
            <h2 style="text-align: center;">Register</h2>

            <?php if ($message): ?>
                <p style="color: red; text-align: center;"><?php echo $message; ?></p> 
            <?php endif; ?>

            <form method="POST" action="">
                <div style="text-align: center;">
                    <input type="text" name="username" placeholder="Username" required><br><br>
                    <input type="password" name="password" placeholder="Password" required><br><br>
                    <input type="submit" value="Register">
                </div>
            </form>
            <p style="text-align: center;">Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </div>
</body>
</html>
