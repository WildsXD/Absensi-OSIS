<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kelola Anggota - Absensi OSIS</title>
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
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h1 class="h4 mb-1">Kelola Anggota</h1>
            <p class="text-muted mb-0">Tambah, ubah, atau hapus data anggota.</p>
          </div>
          <button class="btn btn-secondary hover-glow" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah Anggota</button>
        </div>

        <div class="card mt-3 rounded-3xl">
          <div class="card-body">
            <div class="row g-2 align-items-end">
              <div class="col-md-6">
                <label class="form-label">Pencarian</label>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari nama atau NIS...">
              </div>
              <div class="col-md-3">
                <label class="form-label">Filter Jurusan</label>
                <select id="filterJurusan" class="form-select">
                  <option value="ALL">Semua</option>
                  <option>RPL</option>
                  <option>TBSM</option>
                  <option>ATPH</option>
                </select>
              </div>
              <div class="col-md-3">
                <button class="btn btn-outline-light w-100" id="resetFilters">Reset</button>
              </div>
            </div>
            <div class="table-responsive mt-3">
              <table class="table table-dark table-hover align-middle">
                <thead>
                  <tr>
                    <th>Nama</th><th>NIS</th><th>Jurusan</th><th>Jabatan</th><th style="width:140px">Aksi</th>
                  </tr>
                </thead>
                <tbody id="memberBody"></tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <div class="modal modal-zoom fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content rounded-3xl">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Anggota</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="addAlert"></div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">NIS</label>
              <input class="form-control" id="addNis">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input class="form-control" id="addNama">
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input class="form-control" id="addEmail" type="email">
            </div>
            <div class="col-md-6">
              <label class="form-label">Password</label>
              <input class="form-control" id="addPassword" type="password">
            </div>
            <div class="col-md-6">
              <label class="form-label">Jurusan</label>
              <select id="addJurusan" class="form-select">
                <option>RPL</option><option>TBSM</option><option>ATPH</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Jabatan</label>
              <input class="form-control" id="addJabatan" placeholder="Anggota">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-secondary" id="btnAddMember">
            <span class="me-1">Simpan</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-zoom fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content rounded-3xl">
        <div class="modal-header">
          <h5 class="modal-title">Edit Anggota</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="editAlert"></div>
          <input type="hidden" id="editId">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">NIS</label>
              <input class="form-control" id="editNis">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input class="form-control" id="editNama">
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input class="form-control" id="editEmail" type="email">
            </div>
            <div class="col-md-6">
              <label class="form-label">Jurusan</label>
              <select id="editJurusan" class="form-select">
                <option>RPL</option><option>TBSM</option><option>ATPH</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Jabatan</label>
              <input class="form-control" id="editJabatan">
            </div>
            <div class="col-md-6">
              <label class="form-label">Password (biarkan kosong jika tidak diubah)</label>
              <input class="form-control" id="editPassword" type="password" placeholder="••••••••">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-secondary" id="btnUpdateMember">Update</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/common.js"></script>
  <script>
    const bodyEl = document.getElementById('memberBody');

    function renderTable() {
      const q = document.getElementById('searchInput').value.toLowerCase();
      const jur = document.getElementById('filterJurusan').value;
      const list = getUsers().filter(u => u.role !== 'admin');
      const filtered = list.filter(u => {
        const matchesText = (u.name.toLowerCase().includes(q) || u.nis.toLowerCase().includes(q));
        const matchesJur = (jur === 'ALL' || u.jurusan === jur);
        return matchesText && matchesJur;
      });
      bodyEl.innerHTML = filtered.map(u => `
        <tr>
          <td>${u.name}</td>
          <td>${u.nis}</td>
          <td>${u.jurusan}</td>
          <td>${u.jabatan || 'Anggota'}</td>
          <td>
            <div class="btn-group btn-group-sm">
              <button class="btn btn-outline-light" data-id="${u.id}" data-action="edit">Edit</button>
              <button class="btn btn-outline-light" data-id="${u.id}" data-action="delete">Hapus</button>
            </div>
          </td>
        </tr>
      `).join('');
    }

    document.addEventListener('DOMContentLoaded', () => {
      guardPage('admin');
      document.querySelectorAll('.sidebar .nav-link').forEach(a => {
        if (a.href.endsWith('kelola-anggota.php')) a.classList.add('active');
      });

      renderTable();
      document.getElementById('searchInput').addEventListener('input', renderTable);
      document.getElementById('filterJurusan').addEventListener('change', renderTable);
      document.getElementById('resetFilters').addEventListener('click', () => {
        searchInput.value = ''; filterJurusan.value = 'ALL'; renderTable();
      });

      // Add member
      document.getElementById('btnAddMember').addEventListener('click', () => {
        const data = {
          nis: addNis.value.trim(),
          name: addNama.value.trim(),
          email: addEmail.value.trim(),
          password: addPassword.value,
          jurusan: addJurusan.value,
          jabatan: addJabatan.value || 'Anggota',
          photo: ''
        };
        if (!data.nis || !data.name || !/^\S+@\S+\.\S+$/.test(data.email) || !data.password) {
          showAlert('#addAlert', 'Mohon lengkapi data dengan benar.', 'danger'); return;
        }
        addMember(data);
        showAlert('#addAlert', 'Anggota ditambahkan.', 'success');
        renderTable();
        setTimeout(() => document.querySelector('#modalAdd .btn-close').click(), 600);
      });

      // Row actions
      bodyEl.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        const id = btn.dataset.id;
        const action = btn.dataset.action;
        const user = getUsers().find(u => u.id === id);
        if (action === 'edit') {
          editId.value = id;
          editNis.value = user.nis;
          editNama.value = user.name;
          editEmail.value = user.email;
          editJurusan.value = user.jurusan;
          editJabatan.value = user.jabatan || 'Anggota';
          const m = new bootstrap.Modal('#modalEdit'); m.show();
        } else if (action === 'delete') {
          if (confirm('Yakin hapus anggota ini?')) {
            deleteMember(id); renderTable();
          }
        }
      });

      // Update member
      document.getElementById('btnUpdateMember').addEventListener('click', () => {
        const id = editId.value;
        const patch = {
          nis: editNis.value.trim(),
          name: editNama.value.trim(),
          email: editEmail.value.trim(),
          jurusan: editJurusan.value,
          jabatan: editJabatan.value || 'Anggota',
        };
        const newPass = editPassword.value;
        if (newPass) patch.password = newPass;
        if (!patch.nis || !patch.name || !/^\S+@\S+\.\S+$/.test(patch.email)) {
          showAlert('#editAlert', 'Mohon isi data dengan benar.', 'danger'); return;
        }
        updateMember(id, patch);
        showAlert('#editAlert', 'Perubahan disimpan.', 'success');
        renderTable();
        setTimeout(() => document.querySelector('#modalEdit .btn-close').click(), 600);
      });
    });
  </script>
</body>
</html>
