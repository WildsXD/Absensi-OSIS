<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Absen Hari Ini - Anggota</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/common.css" rel="stylesheet">
</head>
<body>
  <header class="navbar navbar-expand-lg border-bottom border-soft">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Absensi OSIS</a>
      <div class="d-flex align-items-center gap-3">
        <a class="nav-link" href="./dashboard-member.php">Dashboard</a>
        <a class="nav-link" href="./profile-member.php">Profil</a>
        <a href="#" data-logout class="btn btn-outline-light btn-sm">Logout</a>
      </div>
    </div>
  </header>

  <main class="container py-4">
    <h1 class="h4 mb-3">Absen Hari Ini</h1>
    <div id="mAlert"></div>
    <div class="card rounded-3xl">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label text-white">Status</label>
            <select id="mStatus" class="form-select">
              <option>Hadir</option><option>Izin</option><option>Sakit</option><option>Alpha</option>
            </select>
          </div>
          <div class="col-md-6 d-flex align-items-end">
            <button class="btn btn-primary" id="doAbsen">
              <span class="me-1">Kirim</span>
            </button>
            <div class="spinner-border text-info ms-2 d-none" id="mSpin" style="width:1.6rem;height:1.6rem"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="card rounded-3xl mt-3">
      <div class="card-body">
        <h6 class="text-white">Riwayat</h6>
        <div class="table-responsive mt-2">
          <table class="table table-dark table-hover">
            <thead><tr><th>Tanggal</th><th>Status</th></tr></thead>
            <tbody id="mBody"></tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/common.js"></script>
  <script>
    function renderMe() {
      const me = getCurrentUser();
      const recs = attendanceForUser(me.id);
      mBody.innerHTML = recs.map(r => `<tr><td>${r.date}</td><td>${r.status}</td></tr>`).join('') || '<tr><td colspan="2" class="text-center text-muted">Belum ada data</td></tr>';
    }
    document.addEventListener('DOMContentLoaded', () => {
      guardPage('member');
      renderMe();
      doAbsen.addEventListener('click', () => {
        const me = getCurrentUser();
        mSpin.classList.remove('d-none');
        setTimeout(() => {
          markAttendance(me.id, mStatus.value);
          mSpin.classList.add('d-none');
          showAlert('#mAlert', 'Absensi berhasil dikirim.', 'success');
          renderMe();
        }, 700);
      });
    });
  </script>
</body>
</html>
