<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ubah Toko - RE:FOOD</title>
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

  <div class="notification-popup" id="notificationPopup">
    <p>Tidak ada notifikasi baru.</p>
  </div>

  <main class="container">
    <div class="back-arrow">&larr; Ubah detail toko</div>

    <form class="form-box" method="POST" enctype="multipart/form-data" action="{{ route('toko.update', $toko->id ?? 1) }}">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="nama">Nama Toko</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $toko->nama ?? 'Rumah Makan Hindia') }}" />
      </div>
      <div class="form-group">
        <label for="alamat">Alamat Toko</label>
        <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $toko->alamat ?? 'Jl. Tupperware No. 17') }}" />
      </div>
      <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi', $toko->deskripsi ?? 'Rumah Makan Hindia menyediakan berbagai macam makanan dan minuman dengan rasa lezat.') }}" />
      </div>
      <div class="form-group">
        <label for="logo">Foto/Logo Toko</label>
        <input type="file" id="logo" name="logo" accept="image/*" onchange="previewImage(event)" />
        <div class="preview-box">
          <img id="logo-preview" src="#" alt="Preview Logo" style="display: none;" />
        </div>
      </div>
      <div class="button-group">
        <button type="button" class="delete-btn">Hapus Toko</button>
        <button type="button" class="cancel-btn">Batal</button>
        <button type="submit" class="save-btn">Simpan Perubahan</button>
      </div>
    </form>

    @if(session('success'))
      <div class="form-box">
        <h3>Perubahan Disimpan:</h3>
        <p><strong>Nama:</strong> {{ session('data.nama') }}</p>
        <p><strong>Alamat:</strong> {{ session('data.alamat') }}</p>
        <p><strong>Deskripsi:</strong> {{ session('data.deskripsi') }}</p>
      </div>
    @endif
  </main>

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
