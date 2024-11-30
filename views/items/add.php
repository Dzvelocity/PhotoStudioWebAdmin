<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Item</title>
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
        .form-container {
            background-color: white;
            padding: 40px; 
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 650px; 
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px; 
        }
        .form-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px; 
            margin-bottom: 20px; 
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-upload {
            text-align: center;
            margin-bottom: 25px;
        }
        .form-upload label {
            display: block;
            margin-bottom: 10px;
        }
        .form-upload input[type="file"] {
            display: block;
            margin-left: 230px; 
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .button-group button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button-group button[type="button"] {
            background-color: #f0f0f0;
            color: black;
        }
        .button-group button[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h2>Tambah Item</h2>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=item&action=add" enctype="multipart/form-data">
            <div class="form-group">
                <div>
                    <label for="customer_name">Nama Customer</label>
                    <input type="text" id="customer_name" name="customer_name" required 
                           value="<?php echo isset($customer_name) ? htmlspecialchars($customer_name) : ''; ?>">
                </div>
                <div>
                    <label for="num_files">Jumlah File</label>
                    <input type="number" id="num_files" name="num_files" required min="0" 
                           value="<?php echo isset($num_files) ? htmlspecialchars($num_files) : ''; ?>">
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label for="phone_number">Nomor HP</label>
                    <input type="tel" id="phone_number" name="phone_number" pattern="[0-9]+" required 
                           value="<?php echo isset($phone_number) ? htmlspecialchars($phone_number) : ''; ?>">
                </div>
                <div>
                    <label for="num_print">Jumlah Cetak</label>
                    <input type="number" id="num_print" name="num_print" required min="0" 
                           value="<?php echo isset($num_print) ? htmlspecialchars($num_print) : ''; ?>">
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label for="photo_date">Tanggal Foto</label>
                    <input type="date" id="photo_date" name="photo_date" required 
                           value="<?php echo isset($photo_date) ? htmlspecialchars($photo_date) : ''; ?>">
                </div>
                <div>
                    <label for="price">Harga</label>
                    <input type="number" id="price" name="price" required min="0" 
                           value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>">
                </div>
            </div>

            <div class="form-upload">
                <label for="image">Upload Foto (maks. 5 foto)</label>
                <input type="file" id="image" name="image[]" multiple required accept=".jpg,.jpeg,.png">
            </div>

            <div class="button-group">
                <button type="button" onclick="window.location.href='index.php?page=home'">Kembali</button>
                <button type="submit" name="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>