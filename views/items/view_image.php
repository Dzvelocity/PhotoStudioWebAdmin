<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .image-item {
            text-align: center;
        }
        .image-item img {
            max-width: 500px;  
            max-height: 500px; 
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .button-group {
            margin-top: 50px;
        }
        .button-group a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="image-gallery">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="image-item">
                    <img src="<?php echo htmlspecialchars($image); ?>" alt="Foto Item">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada gambar</p>
        <?php endif; ?>
    </div>

    <div class="button-group">
        <a href="index.php?page=home">Kembali ke Home</a>
    </div>
</body>
</html>