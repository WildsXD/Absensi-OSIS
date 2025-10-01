<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Profil Anggota - Absensi OSIS</title>
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
        <a class="nav-link" href="./absensi.php">Absen Hari Ini</a>
        <a href="#" data-logout class="btn btn-outline-light btn-sm">Logout</a>
      </div>
    </div>
  </header>

  <main class="container py-4">
    <h1 class="h4 mb-3">Profil Anggota</h1>
    <div class="row g-3">
      <div class="col-md-5">
        <div class="card rounded-3xl fade-in">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-circle bg-dark border border-soft" style="width:72px;height:72px;"></div>
              <div>
                <div class="fs-5" id="pName">-</div>
                <div class="text-muted" id="pJur">-</div>
              </div>
            </div>
            <hr class="hr-soft">
            <div class="row">
              <div class="col-4 text-muted">NIS</div><div class="col-8" id="pNis">-</div>
              <div class="col-4 text-muted">Email</div><div class="col-8" id="pEmail">-</div>
              <div class="col-4 text-muted">Jabatan</div><div class="col-8" id="pJab">-</div>
            </div>
            <hr class="hr-soft">
            <div class="small text-muted">Edit Password</div>
            <div id="mpAlert"></div>
            <div class="input-group mt-2">
              <input type="password" id="mpNewPass" class="form-control" placeholder="Password baru">
              <button class="btn btn-secondary" id="mpSave">Simpan</button>
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
                <tbody id="mpBody"></tbody>
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
    function renderProfile() {
      const me = getCurrentUser();
      pName.textContent = me.name; pNis.textContent = me.nis; pEmail.textContent = me.email; pJur.textContent = me.jurusan; pJab.textContent = me.jabatan || 'Anggota';
      const list = attendanceForUser(me.id);
      mpBody.innerHTML = list.map(r => `<tr><td>${r.date}</td><td>${r.status}</td></tr>`).join('') || '<tr><td colspan="2" class="text-center text-muted">Belum ada data</td></tr>';
    }
    document.addEventListener('DOMContentLoaded', () => {
      guardPage('member');
      renderProfile();
      mpSave.addEventListener('click', () => {
        const p = mpNewPass.value;
        if (!p || p.length < 6) { showAlert('#mpAlert', 'Minimal 6 karakter.', 'danger'); return; }
        const me = getCurrentUser();
        const users = getUsers().map(u => u.id === me.id ? { ...u, password: p } : u);
        localStorage.setItem('ao_users', JSON.stringify(users));
        setCurrentUser(users.find(u => u.id === me.id));
        showAlert('#mpAlert', 'Password berhasil diubah.', 'success');
        mpNewPass.value = '';
      });
    });
  </script>
</body>
</html>
