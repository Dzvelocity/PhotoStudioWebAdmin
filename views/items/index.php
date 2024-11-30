    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home - Photo Studio Admin</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            header {
                margin-bottom: 20px;
            }
            table {
                width: 80%;
                margin: auto;
                border-collapse: collapse;
            }
            th, td {
                padding: 8px;
                border: 1px solid #ddd;
            }
            th {
                background-color: #f2f2f2;
                text-align: center;
            }
            td {
                text-align: left;
            }
            td.text-center {
                text-align: center;
            }
            img {
                object-fit: cover;
                margin: 0 auto; 
                display: block; 
            }
            .btn-center {
                display: inline-block;
                margin: 0 auto;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header>
            <table align="center" bgcolor="#f2f2f2" width="100%" height="60">
                <tr>
                    <td style="text-align: left;">
                        <h2 style="margin: 0;">Dashboard</h2>
                    </td>
                    <td style="text-align: right;">
                        <a href="index.php?page=item&action=add">Tambah Item</a> | 
                        <form method="POST" action="index.php?page=user&action=logout" style="display: inline;">
                            <input type="submit" value="Logout" style="color: red; border: none; cursor: pointer; font-weight: bold; font-size: 15px;">
                        </form>
                    </td>
                </tr>
            </table>
        </header>
        <br>
        <p style="text-align: center; font-size: 24px;">Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
        
        <table align="center" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th style="text-align: center;">Nama Customer</th>
                <th style="text-align: center;">Nomor HP</th>
                <th style="text-align: center;">Tanggal Foto</th>
                <th style="text-align: center;">Foto</th>
                <th style="text-align: center;">Jumlah File</th>
                <th style="text-align: center;">Jumlah Cetak</th>
                <th style="text-align: center;">Harga</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($item['photo_date']); ?></td>
                            <td class="text-center">
                                <?php 
                                $images = !empty($item['image']) ? explode(',', $item['image']) : []; 
                                if (!empty($images)): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>" width="100" height="100" style="object-fit: cover;"><br>
                                    <div class="btn-center">
                                        <button type="button" onclick="window.location.href='index.php?page=item&action=view_image&id=<?php echo $item['id']; ?>'">
                                            Lihat Lainnya
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <p>Tidak ada gambar</p>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($item['num_files']); ?></td>
                            <td><?php echo htmlspecialchars($item['num_print']); ?></td>
                            <td><?php echo 'Rp ' . number_format($item['price'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <a href="index.php?page=item&action=detail&id=<?php echo $item['id']; ?>">Detail</a> | 
                                <a href="index.php?page=item&action=edit&id=<?php echo $item['id']; ?>">Edit</a> | 
                                <a href="index.php?page=item&action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No items found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </body>
    </html>