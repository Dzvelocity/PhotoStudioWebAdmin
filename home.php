<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$result = $conn->query("SELECT * FROM items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Photo Studio Admin</title>
</head>
<body>
    <header>
        <table align="center" bgcolor="#f2f2f2" width="100%" height="60">
            <tr>
                <td style="text-align: left;">
                    <h2 style="margin: 0;">Dashboard</h2>
                </td>
                <td style="text-align: right;">
                    <a href="add_item.php">Tambah Item</a> | 
                    <a href="logout.php" style="color: red;">Logout</a>
                </td>
            </tr>
        </table>
    </header>
    <br>
    <p style="text-align: center; font-size: 24px;">Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
    
    <table align="center" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Customer</th>
                <th>Nomor HP</th>
                <th>Tanggal Foto</th>
                <th>Foto</th>
                <th>Jumlah File</th>
                <th>Jumlah Cetak</th>
                <th>Harga</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($item = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $item['customer_name']; ?></td>
                        <td><?php echo $item['phone_number']; ?></td>
                        <td><?php echo $item['photo_date']; ?></td>
                        <td>
                            <?php 
                            $images = explode(',', $item['image']); 
                            if (!empty($images[0])): ?>
                                <img src="<?php echo $images[0]; ?>" width="100" height="100" style="object-fit: cover;"><br>
                            <?php endif; ?>
                            <button type="button" onclick="window.location.href='view_image.php?id=<?php echo $item['id']; ?>'">
                                Lihat Lainnya
                            </button>
                        </td>
                        <td><?php echo $item['num_files']; ?></td>
                        <td><?php echo $item['num_print']; ?></td>
                        <td><?php echo 'Rp ' . number_format($item['price'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="detail_item.php?id=<?php echo $item['id']; ?>">Detail</a>
                            <a href="edit_item.php?id=<?php echo $item['id']; ?>">Edit</a>
                            <a href="delete_item.php?id=<?php echo $item['id']; ?>" style="color: red;">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No items found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
