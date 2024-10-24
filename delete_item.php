<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $id); 

    if ($stmt->execute()) {
        header('Location: home.php'); 
        exit();
    } else {
        echo "Gagal menghapus item: " . $stmt->error;
    }
} else {
    echo "ID item tidak ditentukan.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deletse Item</title>
</head>
<body>
    <h2>Delete Item</h2>
    <p>ID item tidak ditemukan atau tidak valid.</p>
    <a href="home.php">Kembali ke Home</a>
</body>
</html>
