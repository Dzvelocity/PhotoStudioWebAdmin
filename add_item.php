<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$error = "";

if (isset($_POST['submit'])) {
    $customer_name = $_POST['customer_name'];
    $phone_number = $_POST['phone_number'];
    $photo_date = $_POST['photo_date'];
    $num_files = (int)$_POST['num_files'];
    $num_print = (int)$_POST['num_print'];
    $price = (float)$_POST['price'];

    if (!is_numeric($phone_number) || $phone_number < 0) {
        $error .= "Nomor HP tidak sesuai.<br>";
    }

    if (!is_numeric($price) || $price < 0) {
        $error .= "Harga tidak sesuai.<br>";
    }

    if (isset($_FILES['image'])) {
        $images = $_FILES['image'];
        $imageCount = count($images['name']);

        if ($imageCount > 15) {
            $error .= "Hanya dapat mengunggah maksimal 15 foto.<br>";
        } elseif ($imageCount > 0) {
            $imageNames = [];
            $targetDir = "uploads/";

            for ($i = 0; $i < $imageCount; $i++) {
                $image = $images['name'][$i];
                $target = $targetDir . basename($image);
                $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

                if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                    $error .= "Hanya file JPEG dan PNG yang diperbolehkan.<br>";
                    break; 
                }

                if (move_uploaded_file($images['tmp_name'][$i], $target)) {
                    $imageNames[] = $target; 
                }
            }

            $imageNamesString = implode(',', $imageNames);
        } else {
            $error .= "Anda harus mengunggah file gambar.<br>";
        }
    }

    if (empty($error)) {
        $sql = "INSERT INTO items (customer_name, phone_number, photo_date, image, num_files, num_print, price) 
                VALUES ('$customer_name', '$phone_number', '$photo_date', '$imageNamesString', $num_files, $num_print, $price)";

        if ($conn->query($sql) === TRUE) {
            header('Location: home.php');
            exit();
        } else {
            $error .= "Gagal menyimpan item: " . $conn->error . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Item</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div style="background-color: #e3e3e3; padding: 20px; border-radius: 10px; width: 50%;">
            <h2 style="text-align: center;">Tambah Item</h2>

            <?php if (!empty($error)): ?>
                <div style="color: red; text-align: center;">
                    <?php echo $error; ?>
                </div><br>
            <?php endif; ?>

            <form method="POST" action="add_item.php" enctype="multipart/form-data">
                <table align="center">
                    <tr>
                        <td>
                            <label for="customer_name">Nama Customer</label><br>
                            <input type="text" id="customer_name" name="customer_name" required value="<?php echo isset($customer_name) ? $customer_name : ''; ?>"><br><br>
                        </td>
                        <td style="padding-left: 20px;">
                            <label for="num_files">Jumlah File</label><br>
                            <input type="number" id="num_files" name="num_files" required min="0" value="<?php echo isset($num_files) ? $num_files : ''; ?>"><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="phone_number">Nomor HP</label><br>
                            <input type="text" id="phone_number" name="phone_number" required value="<?php echo isset($phone_number) ? $phone_number : ''; ?>"><br><br>
                        </td>
                        <td style="padding-left: 20px;">
                            <label for="num_print">Jumlah Cetak</label><br>
                            <input type="number" id="num_print" name="num_print" required min="0" value="<?php echo isset($num_print) ? $num_print : ''; ?>"><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="photo_date">Tanggal Foto</label><br>
                            <input type="date" id="photo_date" name="photo_date" required value="<?php echo isset($photo_date) ? $photo_date : ''; ?>"><br><br>
                        </td>
                        <td style="padding-left: 20px;">
                            <label for="price">Harga</label><br>
                            <input type="number" id="price" name="price" required min="0" value="<?php echo isset($price) ? $price : ''; ?>"><br><br>
                        </td>
                    </tr>
                </table>
                <br>

                <div style="text-align: center;">
                    <label for="image">Upload Foto (maks. 10 foto)</label><br>
                    <input type="file" id="image" name="image[]" multiple required style="margin-left: 70px;"><br><br>
                </div>
                <br>

                <div style="text-align: center;">
                    <a href="home.php" style="text-decoration: none;">
                            <button type="button">Kembali ke Home</button>
                        </a>
                    <button type="submit" name="submit">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</body>
</html>
