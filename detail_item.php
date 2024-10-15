<?php
require 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM items WHERE id = $id");
$item = $result->fetch_assoc();

if (!$item) {
    echo "Item tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Item</title>
</head>
<body>
    <h2>Detail Item</h2>
    <p><strong>Nama Customer:</strong> <?php echo $item['customer_name']; ?></p>
    <p><strong>Nomor HP:</strong> <?php echo $item['phone_number']; ?></p>
    <p><strong>Tanggal Foto:</strong> <?php echo $item['photo_date']; ?></p>
    <p><strong>Foto:</strong></p>
        <?php 
        $images = explode(',', $item['image']); 
        foreach ($images as $img): ?>
            <img src="<?php echo $img; ?>" width="300"><br>
        <?php endforeach; ?>
    <p><strong>Jumlah File:</strong> <?php echo $item['num_files']; ?></p>
    <p><strong>Jumlah Cetak:</strong> <?php echo $item['num_print']; ?></p>
    <p><strong>Harga:</strong> <?php echo 'Rp ' . number_format($item['price'], 0, ',', '.'); ?></p>
    <a href="home.php">Kembali ke Home</a>
</body>
</html>
