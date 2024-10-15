<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        echo "Item tidak ditemukan.";
        exit();
    }
}

$error = "";

if (isset($_POST['edit'])) {
    $customerName = $_POST['customer_name'];
    $phoneNumber = $_POST['phone_number'];
    $photoDate = $_POST['photo_date'];
    $price = $_POST['price']; 

    if (!is_numeric($phoneNumber) || $phoneNumber < 0) {
        $error .= "Nomor telepon tidak sesuai.<br>";
    }

    if (!is_numeric($price) || $price < 0) {
        $error .= "Harga tidak sesuai.<br>";
    }

    if (empty($error)) {
        $numFiles = (int)$_POST['num_files']; 
        $numPrint = (int)$_POST['num_print']; 

        $images = explode(',', $item['image']); 
        $uploadedImages = [];

        for ($i = 0; $i < count($images); $i++) {
            if ($_FILES['image_' . $i]['error'] == UPLOAD_ERR_OK) {
                $image = 'uploads/' . basename($_FILES['image_' . $i]['name']);
                $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

                if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                    $error .= "Hanya file JPEG dan PNG yang diperbolehkan.<br>";
                    break; 
                }

                if (move_uploaded_file($_FILES['image_' . $i]['tmp_name'], $image)) {
                    $uploadedImages[] = $image;
                }
            } else {
                $uploadedImages[] = $images[$i]; 
            }
        }

        if (empty($error)) {
            $imageString = implode(',', $uploadedImages);

            $sql = "UPDATE items SET customer_name='$customerName', phone_number='$phoneNumber', photo_date='$photoDate', image='$imageString', num_files=$numFiles, num_print=$numPrint, price=$price WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                header('Location: home.php'); 
                exit();
            } else {
                $error .= "Gagal memperbarui item: " . $conn->error . "<br>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
</head>
<body>
    <h2>Edit Item</h2>

    <?php if (!empty($error)): ?>
        <div style="color: red;">
            <?php echo $error; ?>
        </div><br>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <label for="customer_name">Nama Customer</label><br>
                    <input type="text" name="customer_name" value="<?php echo isset($customerName) ? $customerName : $item['customer_name']; ?>" required><br><br>
                </td>
                <td style="padding-left: 20px;">
                    <label for="num_files">Jumlah File</label><br>
                    <input type="number" name="num_files" value="<?php echo isset($numFiles) ? $numFiles : $item['num_files']; ?>" required><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="phone_number">Nomor HP</label><br>
                    <input type="text" name="phone_number" value="<?php echo isset($phoneNumber) ? $phoneNumber : $item['phone_number']; ?>" required><br><br>
                </td>
                <td style="padding-left: 20px;">
                    <label for="num_print">Jumlah Cetak</label><br>
                    <input type="number" name="num_print" value="<?php echo isset($numPrint) ? $numPrint : $item['num_print']; ?>" required><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="photo_date">Tanggal Foto</label><br>
                    <input type="date" name="photo_date" value="<?php echo isset($photoDate) ? $photoDate : $item['photo_date']; ?>" required><br><br>
                </td>
                <td style="padding-left: 20px;">
                    <label for="price">Harga</label><br>
                    <input type="text" name="price" value="<?php echo isset($price) ? $price : $item['price']; ?>" required><br><br>
                </td>
            </tr>
        </table>

        <label for="image">Foto:</label><br>
        <?php
        $images = explode(',', $item['image']); 
        foreach ($images as $index => $img): ?>
            <div>
                <img src="<?php echo $img; ?>" width="100"><br>
                <input type="file" name="image_<?php echo $index; ?>">
            </div>
        <?php endforeach; ?>
        <br>

        <button type="submit" name="edit">Simpan</button>
    </form>
    
    <br>
    <a href="home.php">Kembali ke Home</a>
</body>
</html>
