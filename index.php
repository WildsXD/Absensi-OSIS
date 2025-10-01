<?php
session_start();
$errors = $_SESSION['login_errors'] ?? [];
unset($_SESSION['login_errors']);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login Sistem Absensi OSIS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/common.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-5">
  <main class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-7 col-lg-5">
        <div class="card rounded-3xl card-glow-cyan fade-in slide-up p-2">
          <div class="card-body p-4">
            <h1 class="h3 mb-3 typing-caret text-white" id="loginTitle">Login Sistem Absensi OSIS</h1>
            <p class="text-muted">Silakan masuk menggunakan Email atau NIS dan password Anda.</p>
            
            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger fade show" role="alert">
                <?= implode('<br>', $errors) ?>
              </div>
            <?php endif; ?>
 <?php if (isset($_GET['msg'])): ?>
  <div id="autoAlert" class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_GET['msg']) ?>
  </div>
  <script>
    setTimeout(() => {
      const alert = document.getElementById('autoAlert');
      if (alert) {
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 500); 
      }
    }, 3000);
  </script>
<?php endif; ?>


            <form id="loginForm" class="mt-3" method="POST" action="./core/proses-login.php">
              <div class="mb-3">
                <label class="form-label text-white">Email atau NIS</label>
                <input type="text" class="form-control" name="emailNis" placeholder="user@gmail.com" required>
              </div>
              <div class="mb-2">
                <label class="form-label text-white">Password</label>
                <input type="password" class="form-control" name="password" placeholder="••••••••" required>
              </div>
              <div class="d-flex align-items-center justify-content-between mt-3">
                <a class="link" href="./pages/register.php">Belum punya akun? Daftar</a>
                <button class="btn btn-primary hover-glow" type="submit">
                  <span class="me-1">Login</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Typing animation
      typeText(document.getElementById('loginTitle'), 'Login Absensi OSIS', 24);
    });
  </script>
</body>
</html>
