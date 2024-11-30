<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0; /* Tetap sama */
        }
        .edit-container {
            background-color: white; /* Ubah dari #e3e3e3 menjadi putih */
            padding: 40px; /* Sesuaikan dengan halaman add */
            border-radius: 10px;
            width: 70%;
            max-width: 800px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 5px;
        }
        .form-group input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .image-upload-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .image-upload-item {
            text-align: center;
            width: 200px;
        }
        .image-upload-item img {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .button-group button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-group button[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }
        .button-group button[type="button"] {
            background-color: #f0f0f0;
            color: black;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2 style="text-align: center;">Edit Item</h2><br>

        <?php if (!empty($error)): ?>
            <div style="color: red; text-align: center; margin-bottom: 15px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label for="customer_name">Nama Customer</label>
                    <input type="text" name="customer_name" value="<?php echo htmlspecialchars($itemData['customer_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="num_files">Jumlah File</label>
                    <input type="number" name="num_files" value="<?php echo htmlspecialchars($itemData['num_files']); ?>" required min="0">
                </div>
                <div class="form-group">
                    <label for="phone_number">Nomor HP</label>
                    <input type="tel" id="phone_number" name="phone_number" pattern="[0-9]+" value="<?php echo htmlspecialchars($itemData['phone_number']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="num_print">Jumlah Cetak</label>
                    <input type="number" name="num_print" value="<?php echo htmlspecialchars($itemData['num_print']); ?>" required min="0">
                </div>
                <div class="form-group">
                    <label for="photo_date">Tanggal Foto</label>
                    <input type="date" name="photo_date" value="<?php echo htmlspecialchars($itemData['photo_date']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="number" name="price" value="<?php echo htmlspecialchars($itemData['price']); ?>" required>
                </div>
            </div>

            <div class="image-upload-section">
                <?php
                $images = !empty($itemData['image']) ? explode(',', $itemData['image']) : [];
                foreach ($images as $index => $img): 
                ?>
                    <div class="image-upload-item">
                        <img src="uploads/<?php echo htmlspecialchars($img); ?>" alt="Image <?php echo $index + 1; ?>">
                        <input type="file" name="image_<?php echo $index; ?>" accept=".jpg,.jpeg,.png">
                    </div>
                <?php 
                endforeach; 
                ?>
            </div>

            <div class="button-group">
                <a href="index.php?page=home">
                    <button type="button">Kembali ke Home</button>
                </a>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>