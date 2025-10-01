<?php
session_start();
$errors = $_SESSION['register_errors'] ?? [];
unset($_SESSION['register_errors']);

?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Pendaftaran Anggota - Absensi OSIS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/common.css" rel="stylesheet">
</head>
<body class="py-5">
  <main class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">
        <div class="card rounded-3xl card-glow-purple fade-in slide-up">
          <div class="card-body p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center">
              <h1 class="h4 mb-0 typing-caret text-white">Pendaftaran Anggota</h1>
              <a href="../index.php" class="btn btn-outline-light btn-sm">Kembali ke Login</a>
            </div>
            <p class="text-muted mt-2">Lengkapi data berikut untuk mendaftar sebagai anggota OSIS.</p>

            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger">
                <?= implode('<br>', $errors) ?>
              </div>
            <?php endif; ?>

            <form id="formRegister" method="POST" action="../core/proses-register.php" enctype="multipart/form-data">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label text-white">NIS</label>
                  <input type="text" class="form-control" name="nis" required>
                </div>
                <div class="col-md-8">
                  <label class="form-label text-white">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama_lengkap" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label text-white">Email</label>
                  <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label text-white">Password</label>
                  <input type="password" class="form-control" name="password" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label text-white">Jurusan</label>
                  <select name="jurusan" class="form-select" required>
                    <option value="RPL">RPL</option>
                    <option value="TBSM">TBSM</option>
                    <option value="ATPH">ATPH</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label text-white">Jabatan</label>
                  <input type="text" class="form-control" name="jabatan" placeholder="Anggota / Sekretaris / Bendahara" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label text-white">Upload Foto (opsional)</label>
                  <input type="file" class="form-control" name="foto">
                </div>
              </div>

              <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-secondary">
                  <span class="me-1">Daftar</span>
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
