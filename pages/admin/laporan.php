<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Absensi - Absensi OSIS</title>
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
        <div class="d-flex flex-wrap gap-2 align-items-end justify-content-between">
          <div>
            <h1 class="h4 mb-1">Laporan Absensi</h1>
            <p class="text-muted mb-0">Rekap mingguan dan bulanan, bisa diekspor/print.</p>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-light" id="btnExport">Export PDF</button>
            <button class="btn btn-secondary" id="btnPrint">Print</button>
          </div>
        </div>

        <div class="card rounded-3xl mt-3">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label text-white ">Filter Jurusan</label>
                <select class="form-select" id="filterJurusan">
                  <option value="ALL">Semua</option>
                  <option>RPL</option><option>TBSM</option><option>ATPH</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Tanggal Acuan</label>
                <input type="date" class="form-control" id="filterTanggal">
              </div>
            </div>

            <div class="row g-3 mt-2">
              <div class="col-12">
                <div class="card rounded-3xl">
                  <div class="card-body">
                    <h6 class="mb-2 text-white">Rekap Mingguan</h6>
                    <canvas id="weeklyChart" height="120"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card rounded-3xl">
                  <div class="card-body">
                    <h6 class="mb-2 text-white">Rekap Bulanan</h6>
                    <canvas id="monthlyChart" height="100"></canvas>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
  <script src="../../assets/common.js"></script>
  <script src="../../assets/charts.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      guardPage('admin');
      document.querySelectorAll('.sidebar .nav-link').forEach(a => {
        if (a.href.endsWith('laporan.php')) a.classList.add('active');
      });
      // Buttons
      btnPrint.addEventListener('click', () => window.print());
      btnExport.addEventListener('click', () => window.print()); // Simulate export to PDF
    });
  </script>
</body>
</html>
