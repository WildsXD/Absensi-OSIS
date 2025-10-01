<?php
include '../database/connect.php';
session_start();


if ($_SESSION['role'] !== 'admin') {
    die("Akses ditolak!");
}

$nama_lengkap = trim($_POST['nama_lengkap']);
$email        = trim($_POST['email']);
$password     = $_POST['password'];


$hashPassword = md5($password);

// Simpan admin baru
$insert = $conn->prepare("
    INSERT INTO users (nama_lengkap, email, password, role) 
    VALUES (?, ?, ?, 'admin')
");
$insert->bind_param("sss", $nama_lengkap, $email, $hashPassword);

if ($insert->execute()) {
    header("Location: dashboard-admin.php?msg=Admin berhasil ditambahkan");
} else {
    header("Location: dashboard-admin.php?msg=Gagal menambah admin");
}
$insert->close();
