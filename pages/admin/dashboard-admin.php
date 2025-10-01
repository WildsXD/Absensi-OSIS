<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard Admin - Absensi OSIS</title>
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
        <h1 class="h4 mb-3">Dashboard Admin</h1>
        <p class="text-muted">Ringkasan aktivitas dan statistik OSIS.</p>

        <div class="row g-3">
          <div class="col-12 col-md-4">
            <div class="card rounded-3xl card-glow-cyan">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-1 text-white">Total Anggota RPL</h6>
                  <span class="badge badge-cyan">RPL</span>
                </div>
                <div class="fs-3 text-white" id="statRPL">0</div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="card rounded-3xl card-glow-cyan">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-1 text-white">Total Anggota TBSM</h6>
                  <span class="badge badge-cyan">TBSM</span>
                </div>
                <div class="fs-3 text-white" id="statTBSM">0</div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="card rounded-3xl card-glow-cyan">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-1 text-white">Total Anggota ATPH</h6>
                  <span class="badge badge-cyan">ATPH</span>
                </div>
                <div class="fs-3 text-white " id="statATPH">0</div>
              </div>
            </div>
          </div>

   
          <div class="col-12">
            <div class="card rounded-3xl card-glow-purple">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="mb-0 text-white ">Kehadiran Hari Ini</h6>
                  <a href="./laporan.php" class="btn btn-secondary btn-sm">Lihat Laporan Mingguan</a>
                </div>
                <hr class="hr-soft my-3">
                <div class="row text-center">
                  <div class="col-6 col-md-3">
                    <div class="text-muted">Total</div>
                    <div class="fs-4 text-white" id="kTotal">0</div>
                  </div>
                  <div class="col-6 col-md-3">
                    <div class="text-muted">Hadir</div>
                    <div class="fs-4 text-success" id="kHadir">0</div>
                  </div>
                  <div class="col-6 col-md-3 mt-3 mt-md-0">
                    <div class="text-muted">Izin</div>
                    <div class="fs-4 text-info" id="kIzin">0</div>
                  </div>
                  <div class="col-6 col-md-3 mt-3 mt-md-0">
                    <div class="text-muted">Sakit / Alpha</div>
                    <div class="fs-6"><span class="text-warning" id="kSakit">0</span> / <span class="text-danger" id="kAlpha">0</span></div>
                  </div>
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
      // Sidebar active link
      const here = location.pathname.split('/').pop();
      document.querySelectorAll('.sidebar .nav-link').forEach(a => {
        if (a.getAttribute('href').endsWith(here)) a.classList.add('active');
      });
      // Stats
      const s = statsAnggotaByJurusan();
      document.getElementById('statRPL').textContent = s.RPL;
      document.getElementById('statTBSM').textContent = s.TBSM;
      document.getElementById('statATPH').textContent = s.ATPH;

      const k = kehadiranHariIni();
      kTotal.textContent = k.total; kHadir.textContent = k.hadir; kIzin.textContent = k.izin; kSakit.textContent = k.sakit; kAlpha.textContent = k.alpha;
    });
  </script>
</body>
</html>
