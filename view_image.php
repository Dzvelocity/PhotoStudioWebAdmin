<?php
require 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM items WHERE id = $id");
$item = $result->fetch_assoc();

if (!$item) {
    echo "Item tidak ditemukan.";
    exit();
}

$images = explode(',', $item['image']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Image</title>
</head>
<body>
    <h2 align="center">Foto</h2>
    <table width="100%" height="100%">
        <tr>
            <td align="center" valign="middle">
                <?php foreach ($images as $img): ?>
                    <img src="<?php echo $img; ?>" width="500"><br><br>
                <?php endforeach; ?>
                <a href="home.php">Kembali ke Home</a>
            </td>
        </tr>
    </table>
</body>
</html>
