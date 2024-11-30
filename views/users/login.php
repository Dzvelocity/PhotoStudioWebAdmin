
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div style="background-color: #f3f3f3; padding: 20px; border-radius: 10px;">
            <h2 style="text-align: center;">Login</h2>

            <?php if (isset($error)): ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <div style="text-align: center;">
                    <input type="text" name="username" placeholder="Username" required><br><br>
                    <input type="password" name="password" placeholder="Password" required><br><br>
                    <input type="submit" name="login" value="Login">
                </div>
            </form>
            <p style="text-align: center;">Don't have an account? <a href="index.php?page=user&action=register">Register here</a>.</p>
        </div>
    </div>
</body>
</html>
