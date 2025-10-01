<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard Anggota - Absensi OSIS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/common.css" rel="stylesheet">
</head>
<body>
  <header class="navbar navbar-expand-lg border-bottom border-soft">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Absensi OSIS</a>
      <div class="d-flex align-items-center gap-3">
        <a class="nav-link" href="./absensi.php">Absen Hari Ini</a>
        <a class="nav-link" href="./profile-member.php">Profil</a>
        <a href="#" data-logout class="btn btn-outline-light btn-sm">Logout</a>
      </div>
    </div>
  </header>

  <main class="container py-4">
    <h1 class="h4 mb-3">Dashboard Anggota</h1>
    <div class="row g-3">
      <div class="col-12 col-md-6">
        <div class="card rounded-3xl fade-in card-glow-cyan">
          <div class="card-body">
            <h6 class="text-white">Profil Singkat</h6>
            <hr class="hr-soft">
            <div class="row">
              <div class="col-4 text-muted">Nama</div><div class="col-8" id="mName">-</div>
              <div class="col-4 text-muted">NIS</div><div class="col-8" id="mNis">-</div>
              <div class="col-4 text-muted">Jurusan</div><div class="col-8" id="mJur">-</div>
              <div class="col-4 text-muted">Jabatan</div><div class="col-8" id="mJab">-</div>
            </div>
            <div class="mt-3">
              <a href="./absensi.php" class="btn btn-primary hover-glow">Absen Hari Ini</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="card rounded-3xl">
          <div class="card-body">
            <h6 class="text-white">Riwayat Absensi</h6>
            <div class="table-responsive mt-2">
              <table class="table table-dark table-hover">
                <thead><tr><th>Tanggal</th><th>Status</th></tr></thead>
                <tbody id="hisBody"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/common.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      guardPage('member');
      const me = getCurrentUser();
      mName.textContent = me.name; mNis.textContent = me.nis; mJur.textContent = me.jurusan; mJab.textContent = me.jabatan || 'Anggota';
      const recs = attendanceForUser(me.id);
      hisBody.innerHTML = recs.map(r => `<tr><td>${r.date}</td><td>${r.status}</td></tr>`).join('') || '<tr><td colspan="2" class="text-center text-muted">Belum ada data</td></tr>';
    });
  </script>
</body>
</html>
