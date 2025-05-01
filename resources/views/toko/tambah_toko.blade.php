<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Toko - RE:FOOD</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}" />
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
  <header class="navbar">
    <div class="logo">RE:<span class="highlight">FOOD</span></div>
    <div class="nav-right">
      <div class="notification-icon">
        <i data-feather="bell" class="icon-bell"></i>
        <span class="active-dot"></span>
      </div>
      <span class="user-role">Admin</span>
      <img src="{{ asset('person-with-blue-shirt-that-says-name-person_1029948-7040.png') }}" alt="User Avatar" class="avatar">
    </div>
  </header>

  <!-- Popup Notifikasi -->
  <div class="notification-popup" id="notificationPopup">
    <p>Tidak ada notifikasi baru.</p>
  </div>

  <main class="container">
    <div class="back-arrow">&larr; Tambah Toko</div>

    <form class="form-box" method="POST" enctype="multipart/form-data" action="{{ route('toko.store') }}">
      @csrf
      <div class="form-group">
        <label for="nama">Nama Toko</label>
        <input type="text" id="nama" name="nama" placeholder="cth. Feast Food & Restaurant" />
      </div>
      
      <div class="form-group">
        <label for="alamat">Alamat Toko</label>
        <input type="text" id="alamat" name="alamat" placeholder="cth. Jl. Tikus No. 1" />
      </div>
      
      <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <input type="text" id="deskripsi" name="deskripsi" placeholder="cth. Feast Food & Restaurant merupakan restoran ..." />
      </div>
      
      <div class="form-group">
        <label for="logo">Foto/Logo Toko</label>
        <input type="file" id="logo" name="logo" accept="image/*" onchange="previewImage(event)" />
        <div class="preview-box">
          <img id="logo-preview" src="#" alt="Preview Logo" style="display: none;" />
        </div>
      </div>

      <div class="button-group">
        <button type="button" class="cancel-btn">Batal</button>
        <button type="submit" class="save-btn">Simpan Toko</button>
      </div>
    </form>

    @if(session('success'))
      <div class="form-box">
        <h3>Data Tersimpan:</h3>
        <p><strong>Nama:</strong> {{ session('data.nama') }}</p>
        <p><strong>Alamat:</strong> {{ session('data.alamat') }}</p>
        <p><strong>Deskripsi:</strong> {{ session('data.deskripsi') }}</p>
      </div>
    @endif
  </main>

  <!-- Script: Preview dan Notifikasi -->
  <script>
    feather.replace();

    function previewImage(event) {
      const input = event.target;
      const preview = document.getElementById('logo-preview');
      
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    const notifIcon = document.querySelector('.notification-icon');
    const notifPopup = document.getElementById('notificationPopup');

    notifIcon.addEventListener('click', () => {
      notifPopup.style.display = notifPopup.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
      if (!notifIcon.contains(e.target) && !notifPopup.contains(e.target)) {
        notifPopup.style.display = 'none';
      }
    });
  </script>
</body>
</html>
