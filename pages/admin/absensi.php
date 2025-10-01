<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Absensi Manual - Absensi OSIS</title>
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
        <h1 class="h4 mb-3">Absensi Manual</h1>
        <p class="text-muted">Pilih status atau gunakan simulasi "Scan" untuk menandai kehadiran.</p>

        <div id="absenAlert"></div>

        <div class="card rounded-3xl">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label text-white">NIS / Email</label>
                <input class="form-control" id="scanInput" placeholder="cth: 000001 atau email">
              </div>
              <div class="col-md-4">
                <label class="form-label">Status</label>
                <select id="status" class="form-select">
                  <option>Hadir</option><option>Izin</option><option>Sakit</option><option>Alpha</option>
                </select>
              </div>
              <div class="col-md-4 d-flex align-items-end gap-2 text-end">
                <button class="btn btn-secondary" id="btnSubmit">
                  <span class="me-1">Simpan</span>
                </button>
                <div class="spinner-border text-info d-none" id="spinner" role="status" style="width:1.6rem;height:1.6rem"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="card rounded-3xl mt-3">
          <div class="card-body">
            <h6 class="mb-3 text-white">Riwayat Hari Ini</h6>
            <div class="table-responsive">
              <table class="table table-dark table-hover">
                <thead>
                  <tr><th>Nama</th><th>NIS</th><th>Jurusan</th><th>Status</th><th>Tanggal</th></tr>
                </thead>
                <tbody id="todayBody"></tbody>
              </table>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/common.js"></script>
  <script>
    function renderToday() {
      const users = getUsers();
      const map = Object.fromEntries(users.map(u => [u.id, u]));
      const today = new Date().toISOString().slice(0,10);
      const list = getAttendance().filter(a => a.date === today);
      todayBody.innerHTML = list.map(a => {
        const u = map[a.userId] || { name: '-', nis: '-', jurusan: '-' };
        return `<tr><td>${u.name}</td><td>${u.nis}</td><td>${u.jurusan}</td><td>${a.status}</td><td>${a.date}</td></tr>`;
      }).join('');
    }

    function processMark(user, status) {
      spinner.classList.remove('d-none');
      setTimeout(() => {
        markAttendance(user.id, status);
        spinner.classList.add('d-none');
        showAlert('#absenAlert', `Absensi ${user.name} (${status}) berhasil.`, 'success');
        renderToday();
      }, 700);
    }

    document.addEventListener('DOMContentLoaded', () => {
      guardPage('admin');
      document.querySelectorAll('.sidebar .nav-link').forEach(a => {
        if (a.href.endsWith('absensi.php')) a.classList.add('active');
      });
      renderToday();

      btnScan.addEventListener('click', () => {
        const q = scanInput.value.trim();
        if (!q) return;
        const users = getUsers();
        const user = users.find(u => u.nis === q || u.email === q);
        if (!user) {
          showAlert('#absenAlert', 'Pengguna tidak ditemukan.', 'danger'); return;
        }
        processMark(user, status.value);
      });

      btnSubmit.addEventListener('click', () => {
        const q = scanInput.value.trim();
        const users = getUsers();
        const user = users.find(u => u.nis === q || u.email === q);
        if (!user) {
          showAlert('#absenAlert', 'Pengguna tidak ditemukan.', 'danger'); return;
        }
        processMark(user, status.value);
      });
    });
  </script>
</body>
</html>
