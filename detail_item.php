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
    <div align="center">
        <h2>Detail Item</h2>
    </div>
    
    <table align="center" border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td><strong>Nama Customer:</strong></td>
            <td><?php echo $item['customer_name']; ?></td>
        </tr>
        <tr>
            <td><strong>Nomor HP:</strong></td>
            <td><?php echo $item['phone_number']; ?></td>
        </tr>
        <tr>
            <td><strong>Tanggal Foto:</strong></td>
            <td><?php echo $item['photo_date']; ?></td>
        </tr>
        <tr>
            <td><strong>Foto:</strong></td>
            <td>
                <?php 
                $images = explode(',', $item['image']); 
                foreach ($images as $img): ?>
                    <img src="<?php echo $img; ?>" width="300"><br>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td><strong>Jumlah File:</strong></td>
            <td><?php echo $item['num_files']; ?></td>
        </tr>
        <tr>
            <td><strong>Jumlah Cetak:</strong></td>
            <td><?php echo $item['num_print']; ?></td>
        </tr>
        <tr>
            <td><strong>Harga:</strong></td>
            <td><?php echo 'Rp ' . number_format($item['price'], 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <a href="home.php">Kembali ke Home</a>
            </td>
        </tr>
    </table>
</body>
</html>
