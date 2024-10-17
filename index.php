<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Started</title>
</head>
<body style="margin: 0; height: 100vh; display: flex; justify-content: center; align-items: center; background-color: LightGray;">

    <div style="text-align: center;">
        <h1>Welcome to FL Photo Studio Admin</h1>
        <p>This platform allows administrators to manage customer data, photo sessions,</p>
        <p> and additional services of FL Photo Studio.</p>
        <div>
            <a href="login.php">Login</a><br><br>
            <a href="register.php">Register</a>
        </div>
    </div>

</body>
</html>
