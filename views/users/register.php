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

            <form method="POST" action="">
                <div style="text-align: center;">
                    <input type="text" name="username" placeholder="Username" 
                        value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" 
                        required><br><br>
                    
                    <input type="password" name="password" placeholder="Password" required><br><br>
                    
                    <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required><br><br>
                    
                    <?php 
                    // Tampilkan error jika ada
                    if (!empty($errors)): ?>
                        <div style="color: red; margin-bottom: 10px;">
                            <?php foreach ($errors as $error): ?>
                                <p><?= htmlspecialchars($error) ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <input type="submit" value="Register">
                </div>
            </form>
            <p style="text-align: center;">Already have an account? <a href="index.php?page=user&action=login">Login here</a>.</p>
        </div>
    </div>
</body>
</html>