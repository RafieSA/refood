# 🍽️ REFOOD - Platform Pengurangan Limbah Makanan

![REFOOD Platform](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Supabase-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![WCAG 2.1 AA](https://img.shields.io/badge/WCAG-2.1_AA-green?style=for-the-badge)

> **Platform berbasis web yang menghubungkan restoran dengan pelanggan untuk mengurangi limbah makanan melalui sistem klaim diskon berbatas waktu.**

---

## 📌 Ringkasan Proyek

**REFOOD** adalah solusi inovatif untuk mengatasi masalah food waste di Indonesia dengan cara menghubungkan restoran yang memiliki makanan mendekati tanggal kedaluwarsa dengan konsumen melalui sistem diskon menarik.

### 🎯 Latar Belakang

Indonesia menghasilkan **23-48 juta ton limbah makanan per tahun**, dengan sektor restoran menjadi kontributor signifikan. REFOOD hadir sebagai platform yang:
- **Membantu restoran** mengurangi kerugian dari makanan tidak terjual
- **Membantu konsumen** mendapatkan makanan berkualitas dengan harga terjangkau
- **Membantu lingkungan** mengurangi dampak limbah makanan

### 📊 Informasi Proyek

| Item | Detail |
|------|--------|
| **Nama Proyek** | REFOOD - Food Waste Reduction Platform |
| **Tipe** | Web Application (Full-Stack) |
| **Konteks Awal** | Tugas Besar Proyek Perangkat Lunak (Semester 6) |
| **Institusi** | Telkom University Bandung - S1 Sistem Informasi |
| **Status Saat Ini** | Portfolio untuk Sertifikasi BNSP Web Developer |
| **Tanggal Pengembangan** | Oktober 2025 (Polish & Finalization Phase) |
| **Live Demo** | [Coming Soon] |
| **Repository** | [github.com/RafieSA/refood](https://github.com/RafieSA/refood) |

---

## ✨ Fitur Utama

### 🔍 Pencarian & Filtering Cerdas
- **Autocomplete Search**: Pencarian real-time yang mulai bekerja setelah 2+ karakter
- **Filter Kategori**: Filter berdasarkan jenis masakan (Indonesian, Western, Asian, dll)
- **Filter Diskon**: Filter berdasarkan persentase diskon (10%+, 20%+, 30%+)
- **Dynamic Results**: Hasil filtering langsung terlihat tanpa reload

### ⭐ Sistem Rating & Review Dinamis
- **Rating Dinamis**: Perhitungan rating otomatis dari database (bukan hardcode)
- **Jumlah Review Akurat**: Menampilkan jumlah review real dari setiap restoran
- **4-Way Sorting**: Urutkan review berdasarkan:
  - Terbaru → Terlama
  - Rating Tertinggi → Rating Terendah
- **Form Review**: Submit review dengan validasi restaurant_id

### 📱 Mobile-First & Responsive
- **Bottom Navigation**: Navigasi fixed di bawah untuk mobile (<768px)
- **Swipe Gestures**: Swipe kanan untuk kembali (threshold 100px)
- **Pull-to-Refresh**: Tarik ke bawah untuk reload (threshold 80px)
- **Touch-Friendly**: Semua tombol minimum 44×44px (WCAG AAA)
- **Responsive Breakpoints**: Optimal di mobile, tablet, dan desktop

### ♿ Aksesibilitas Lengkap (WCAG 2.1 Level AA)

#### Keyboard Navigation
- `Alt + A` → Buka pengaturan aksesibilitas
- `Alt + H` → Mulai tur fitur
- `Alt + 1/2/3` → Focus ke search/category/discount filter
- `ESC` → Tutup semua modal
- `Tab / Shift+Tab` → Navigasi elemen

#### Screen Reader Support
- ARIA labels lengkap pada semua elemen interaktif
- ARIA live regions untuk pengumuman dinamis
- Semantic HTML structure (h1 → h2 → h3)
- Alt text deskriptif pada semua gambar

#### Visual Accessibility
- **Mode Kontras Tinggi**: Background hitam, text putih, link biru terang
- **Pengaturan Ukuran Font**: 4 pilihan (Small, Medium, Large, XLarge)
- **Focus Indicators**: Outline hijau 3px (kuning di mode kontras tinggi)
- **Skip to Content Link**: Visible on focus untuk screen reader users

### 🎨 UI/UX Modern

- **Welcome Modal**: Panduan 3-step untuk first-time visitors
- **Feature Tour**: Tur interaktif 5-step dengan tooltip & dark overlay
- **Loading States**: Spinner button + full-screen overlay saat submit
- **Toast Notifications**: Notifikasi modern dengan progress bar & auto-dismiss
- **Image Gallery**: Lightbox modal untuk melihat gambar full-size
- **Back to Top Button**: Muncul setelah scroll 300px
- **Pagination**: 10 items per page dengan maintain sort & filter params

### 🌐 Lokalisasi Indonesia

- **Primary UI**: Semua text user-facing dalam Bahasa Indonesia
- **Balanced Approach**: Technical terms tetap dalam English (Rating, Login, Email)
- **Time References**: Tetap English ("5 hours ago") - standar apps
- **Screen Reader**: Announcement dalam Bahasa Indonesia
- **Coverage**: ~95% UI text translated (150+ strings)

### ⚡ Performance Optimization

- **Database Indexing**: 8 indexes strategis (60-80% faster queries)
- **CSS/JS Minification**: Terser configuration (60-70% size reduction)
- **Code Splitting**: Vendor bundle terpisah dari app code
- **Lazy Loading**: Images dengan `loading="lazy"` attribute
- **Asset Optimization**: Vite build dengan compression

---

## 🛠️ Tech Stack

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Tailwind CSS v3 (utility-first framework)
- **JavaScript** - ES6+ Vanilla JS (zero jQuery dependency)
- **Blade** - Laravel template engine
- **Vite** - Modern build tool dengan HMR

### Backend
- **Laravel 11** - PHP framework (MVC architecture)
- **PHP 8.2+** - Modern PHP dengan type hints
- **Composer** - Dependency management

### Database
- **PostgreSQL** - Relational database via Supabase
- **Supabase** - Backend-as-a-Service platform
- **Eloquent ORM** - Laravel database abstraction

### Tools & Libraries
- **Git/GitHub** - Version control
- **NPM** - Node package manager
- **Laravel Mix/Vite** - Asset compilation
- **PostCSS** - CSS transformation
- **Autoprefixer** - Cross-browser CSS compatibility

---

---

## 🚀 Instalasi & Setup

### Prasyarat

Pastikan sistem Anda memiliki:
- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** >= 9.x
- **PostgreSQL** (atau gunakan Supabase)
- **Git**

### Langkah Instalasi

#### 1. Clone Repository
```bash
git clone https://github.com/RafieSA/refood.git
cd refood
```

#### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

#### 3. Environment Setup
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Konfigurasi Database

Edit file `.env` dengan kredensial Supabase Anda:
```env
DB_CONNECTION=pgsql
DB_HOST=db.your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

#### 5. Jalankan Migrasi Database
```bash
# Jalankan migrations (jika ada)
php artisan migrate

# Atau execute manual SQL scripts
# - database_migration_script.sql (schema setup)
# - database_sample_data_READY.sql (sample data)
# - database_indexing_optimization.sql (performance indexes)
```

#### 6. Build Assets
```bash
# Development mode (with hot reload)
npm run dev

# Production mode (minified)
npm run build
```

#### 7. Jalankan Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

### Struktur Database

**Tabel Utama:**
1. **restaurants** - Data restoran (nama, alamat, kategori, diskon, rating)
2. **coments** - Review/komentar pelanggan (nama, rating, komentar, restaurant_id)
3. **food_categories** - Kategori makanan (optional)

**Indexes untuk Performance:**
- `idx_restaurants_search` - Pencarian nama/menu restoran
- `idx_restaurants_food_type` - Filter kategori
- `idx_restaurants_discount` - Filter diskon
- `idx_coments_rating_date` - Sorting review
- Dan 4 indexes lainnya (lihat `database_indexing_optimization.sql`)

---

## 📁 Struktur Proyek

```
refood/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── RestaurantController.php    # Main controller
│   │   │   └── ComentController.php         # Review controller
│   │   └── Middleware/                      # Laravel middleware
│   └── Models/
│       ├── Restaurant.php                   # Restaurant model
│       └── Coment.php                       # Comment/Review model
├── bootstrap/
├── config/                                  # Laravel configuration
├── database/
│   ├── migrations/                          # Database migrations
│   ├── database_migration_script.sql        # Manual schema setup
│   ├── database_sample_data_READY.sql       # 52 sample reviews
│   └── database_indexing_optimization.sql   # Performance indexes
├── public/
│   ├── css/
│   │   └── accessibility.css                # Accessibility styles (323 lines)
│   ├── js/
│   │   └── accessibility.js                 # Accessibility features (601 lines)
│   └── images/                              # Restaurant images
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php               # Main layout
│   │   └── restaurants/
│   │       ├── index.blade.php             # Homepage (restaurant list)
│   │       └── detail.blade.php            # Restaurant detail page
│   ├── css/
│   └── js/
├── routes/
│   └── web.php                              # Application routes
├── storage/                                 # Laravel storage
├── tests/                                   # Test files
├── vendor/                                  # Composer dependencies
├── .env.example                             # Environment template
├── composer.json                            # PHP dependencies
├── package.json                             # Node dependencies
├── vite.config.js                           # Build configuration
├── tailwind.config.js                       # Tailwind configuration
├── CHANGELOG.md                             # Complete development log (2,200+ lines)
├── ACCESSIBILITY_GUIDE.md                   # Accessibility documentation (541 lines)
├── OPTIMIZATION_GUIDE.md                    # Performance guide (300+ lines)
├── FEATURES_ADDED.md                        # Feature documentation (400+ lines)
└── README.md                                # This file

---

<p align="center">
  <strong>Dibuat dengan ❤️ untuk mengurangi food waste di Indonesia</strong><br>
  <sub>REFOOD - Together Against Food Waste</sub>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Made%20with-Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Made with Laravel">
  <img src="https://img.shields.io/badge/Built%20for-BNSP-green?style=for-the-badge" alt="Built for BNSP">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-success?style=for-the-badge" alt="Production Ready">
</p>
