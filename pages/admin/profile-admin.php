<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Profil Admin - Absensi OSIS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/common.css" rel="stylesheet">
</head>
<body>
  <header class="navbar navbar-expand-lg border-bottom border-soft">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Absensi OSIS</a>
      <button class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="d-flex align-items-center gap-3">
        <span class="badge badge-cyan" data-user-role>ADMIN</span>
        <a href="#" data-logout class="btn btn-outline-light btn-sm">Logout</a>
      </div>
    </div>
  </header>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menu</h5>
      <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
      <?php include './partials/sidebarAdmin.php'; ?>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 d-none d-md-block p-0">
        <?php include './partials/sidebarAdmin.php'; ?>
      </div>
      <main class="col-md-9 p-4">
        <h1 class="h4 mb-3">Profil Admin</h1>
        <div class="row g-3">
          <div class="col-md-5">
            <div class="card rounded-3xl fade-in">
              <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-circle bg-dark border border-soft" style="width:72px;height:72px;"></div>
                  <div>
                    <div class="fs-5 text-white" data-user-name>Administrator</div>
                    <div class="text-muted">OSIS Admin</div>
                  </div>
                </div>
                <hr class="hr-soft">
                <div class="small text-muted">Ubah Password</div>
                <div id="pwdAlert"></div>
                <div class="input-group mt-2">
                  <input type="password" id="newPass" class="form-control" placeholder="Password baru">
                  <button class="btn btn-secondary" id="savePass">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="card rounded-3xl">
              <div class="card-body">
                <h6 class="text-white">Riwayat Absensi Pribadi</h6>
                <div class="table-responsive mt-2">
                  <table class="table table-dark table-hover">
                    <thead><tr><th>Tanggal</th><th>Status</th></tr></thead>
                    <tbody id="meBody"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div> 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/common.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      guardPage('admin');
      document.querySelectorAll('.sidebar .nav-link').forEach(a => {
        if (a.href.endsWith('profile-admin.php')) a.classList.add('active');
      });
      const me = getCurrentUser();
      const list = attendanceForUser(me.id);
      meBody.innerHTML = list.map(r => `<tr><td>${r.date}</td><td>${r.status}</td></tr>`).join('') || '<tr><td colspan="2" class="text-center text-muted">Belum ada data</td></tr>';

      savePass.addEventListener('click', () => {
        const p = newPass.value;
        if (!p || p.length < 6) { showAlert('#pwdAlert', 'Minimal 6 karakter.', 'danger'); return; }
        const users = getUsers().map(u => u.id === me.id ? { ...u, password: p } : u);
        localStorage.setItem('ao_users', JSON.stringify(users));
        const updated = users.find(u => u.id === me.id);
        setCurrentUser(updated);
        showAlert('#pwdAlert', 'Password berhasil diubah.', 'success');
        newPass.value = '';
      });
    });
  </script>
</body>
</html>
