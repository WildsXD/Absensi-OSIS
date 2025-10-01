<?php
include '../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis          = trim($_POST['nis'] ?? ''); 
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '';
    $jurusan      = $_POST['jurusan'] ?? null;
    $jabatan      = $_POST['jabatan'] ?? null;
    $role         = 'member'; 

    $errors = [];


    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $targetFile = $targetDir . $foto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile);
    }

    if (empty($nis) || empty($nama_lengkap) || empty($email) || empty($password)) {
        $errors[] = 'NIS, Nama Lengkap, Email, dan Password wajib diisi!';
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid!';
    }

    // Validasi panjang password
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter!';
    }

    // Validasi jurusan & jabatan (wajib untuk anggota)
    if (empty($jurusan) || empty($jabatan)) {
        $errors[] = 'Jurusan dan Jabatan wajib diisi!';
    }

    // Cek apakah NIS atau Email sudah terdaftar
    $check = $conn->prepare('SELECT id FROM users WHERE nis = ? OR email = ?');
    $check->bind_param('ss', $nis, $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $errors[] = 'NIS atau Email sudah terdaftar!';
    }
    $check->close();

    // Jika tidak ada error, simpan ke DB
    if (count($errors) === 0) {
        // pakai password_hash biar lebih aman
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert = $conn->prepare('
            INSERT INTO users (nis, nama_lengkap, email, password, role, jurusan, jabatan, foto) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ');
        $insert->bind_param('ssssssss', $nis, $nama_lengkap, $email, $hashPassword, $role, $jurusan, $jabatan, $foto);

        if ($insert->execute()) {
            header('Location: ../index.php?msg=Registrasi berhasil');
            exit;
        } else {
            $errors[] = 'Gagal mendaftar. Silakan coba lagi.';
        }
        $insert->close();
    }

    // Jika ada error
    session_start();
    $_SESSION['register_errors'] = $errors;
    header('Location: ../pages/register.php');
    exit;
} else {
    header('Location: ../pages/register.php');
    exit;
}
