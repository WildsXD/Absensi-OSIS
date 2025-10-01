<?php
session_start();
include '../../database/connect.php';

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_lengkap']);
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?? '';

    if (empty($nama) || empty($email) || empty($password)) {
        $errors[] = "Semua field wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid!";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $errors[] = "Email sudah terdaftar!";
        }
        $check->close();
    }

    if (count($errors) === 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $role = "admin";
        $insert = $conn->prepare("INSERT INTO users (nama_lengkap, email, password, role) VALUES (?, ?, ?, ?)");
        $insert->bind_param("ssss", $nama, $email, $hash, $role);

        if ($insert->execute()) {
            $success = "Admin baru berhasil ditambahkan!";
        } else {
            $errors[] = "Gagal menambahkan admin.";
        }
        $insert->close();
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tambah Admin - Absensi OSIS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/common.css" rel="stylesheet">
</head>
<body class="d-flex">
  <?php include './partials/sidebarAdmin.php'; ?>

  <main class="p-4 flex-grow-1">
    <div class="container">
      <h2 class="mb-3 text-white">Tambah Admin Baru</h2>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label text-white">Nama Lengkap</label>
          <input type="text" class="form-control" name="nama_lengkap" required>
        </div>
        <div class="mb-3">
          <label class="form-label text-white">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
          <label class="form-label text-white">Password</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Admin</button>
        <a href="./dashboard-admin.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </main>
</body>
</html>
