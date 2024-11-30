<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .detail-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 800px;
        }
        .detail-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        .detail-item label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .image-item {
            text-align: center;
            max-width: 200px;
        }
        .image-item img {
            max-width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 5px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .button-group a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-back {
            background-color: #f0f0f0;
            color: black;
        }
        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="detail-container">
        <div class="detail-header">
            <h2>Detail Item</h2><br>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <label>Nama Customer</label>
                <p><?php echo htmlspecialchars($itemData['customer_name']); ?></p>
            </div>
            <div class="detail-item">
                <label>Nomor HP</label>
                <p><?php echo htmlspecialchars($itemData['phone_number']); ?></p>
            </div>
            <div class="detail-item">
                <label>Tanggal Foto</label>
                <p><?php echo htmlspecialchars($itemData['photo_date']); ?></p>
            </div>
            <div class="detail-item">
                <label>Jumlah File</label>
                <p><?php echo htmlspecialchars($itemData['num_files']); ?></p>
            </div>
            <div class="detail-item">
                <label>Jumlah Cetak</label>
                <p><?php echo htmlspecialchars($itemData['num_print']); ?></p>
            </div>
            <div class="detail-item">
                <label>Harga</label>
                <p>Rp. <?php echo number_format($itemData['price'], 0, ',', '.'); ?></p>
            </div>
        </div>

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
            <a href="index.php?page=home" class="btn-back">Kembali</a>
            <a href="index.php?page=item&action=edit&id=<?php echo $itemData['id']; ?>" class="btn-edit">Edit</a>
        </div>
    </div>
</body>
</html>