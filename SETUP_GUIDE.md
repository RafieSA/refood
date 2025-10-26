# 📘 Panduan Setup Refood dengan Supabase

> **Proyek**: Refood - Food Waste Reduction Platform  
> **Nama**: Rafie  
> **Mata Kuliah**: Pelatihan dan Sertifikasi - Web Developer Jobhun (KKNI Level 6)  
> **Program Studi**: S1 Sistem Informasi, Telkom University (Angkatan 2022)  
> **Tanggal**: 24 Oktober 2025

---

## 🎯 Tujuan

Menghubungkan aplikasi Laravel Refood yang sudah di-clone dari GitHub dengan project Supabase baru dan membuat ulang skema database.

---

## ✅ Checklist Progress

- [x] Clone repository dari GitHub
- [x] Analisis struktur database dari model Laravel
- [x] Generate SQL schema untuk Supabase
- [x] Buat file .env.example sebagai template
- [ ] **Eksekusi SQL schema di Supabase** ← **LANGKAH SELANJUTNYA**
- [ ] Konfigurasi file .env
- [ ] Install dependencies Laravel
- [ ] Test koneksi database

---

## 📋 Langkah-langkah Setup

### **STEP 1: Eksekusi SQL Schema di Supabase** ⭐

1. **Buka Supabase Dashboard**
   - Login ke: https://supabase.com/dashboard
   - Pilih project Refood yang sudah Anda buat

2. **Buka SQL Editor**
   - Klik menu **"SQL Editor"** di sidebar kiri
   - Atau langsung ke: `https://supabase.com/dashboard/project/YOUR_PROJECT_ID/sql`

3. **Copy SQL Schema**
   - Buka file `supabase_schema.sql` di folder project ini
   - Copy seluruh isi file tersebut

4. **Execute SQL**
   - Paste script SQL ke dalam SQL Editor
   - Klik tombol **"Run"** atau tekan `Ctrl + Enter`
   - Tunggu hingga muncul pesan sukses

5. **Verifikasi Tabel Berhasil Dibuat**
   - Klik menu **"Table Editor"** di sidebar
   - Anda harus melihat tabel-tabel berikut:
     - ✓ users
     - ✓ admins
     - ✓ super_admins
     - ✓ restaurants
     - ✓ articles
     - ✓ coments
     - ✓ discount_claims
     - ✓ migrations

---

### **STEP 2: Dapatkan Credential Supabase**

1. **Database Credentials**
   - Di dashboard Supabase, klik **Settings** → **Database**
   - Catat informasi berikut:
     ```
     Host: db.xxxxxxxxxxxxx.supabase.co
     Database name: postgres
     Port: 5432
     User: postgres
     Password: [password yang Anda set saat membuat project]
     ```

2. **API Credentials**
   - Klik **Settings** → **API**
   - Catat informasi berikut:
     ```
     Project URL: https://xxxxxxxxxxxxx.supabase.co
     anon public key: eyJhbGc...
     ```

---

### **STEP 3: Konfigurasi Laravel .env**

Di terminal VS Code, jalankan command berikut:

```bash
# Copy file .env.example menjadi .env
cp .env.example .env
```

Kemudian edit file `.env` dan isi dengan credential Supabase Anda:

```env
DB_CONNECTION=pgsql
DB_HOST=db.xxxxxxxxxxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your_actual_password_here

SUPABASE_URL=https://xxxxxxxxxxxxx.supabase.co
SUPABASE_KEY=your_anon_key_here
```

---

### **STEP 4: Install Dependencies Laravel**

Jalankan command berikut di terminal:

```bash
# Install PHP dependencies
composer install

# Generate application key
php artisan key:generate

# Install Node.js dependencies (untuk Tailwind CSS)
npm install
```

---

### **STEP 5: Test Koneksi Database**

Jalankan command untuk test koneksi:

```bash
php artisan migrate:status
```

Jika berhasil, Anda akan melihat output yang menunjukkan status migrations.

---

## 🗂️ Struktur Database

### **Tabel Utama:**

1. **users** - User authentication (Laravel default)
2. **admins** - Restaurant admin accounts (UUID)
3. **super_admins** - System super admin (UUID)
4. **restaurants** - Restaurant data with discount info (UUID)
5. **articles** - News/blog articles (UUID)
6. **coments** - User reviews/comments
7. **discount_claims** - Discount claim requests (UUID)

### **Relasi:**
- `restaurants.admin_id` → `admins.id` (FK)
- `discount_claims.restaurant_id` → `restaurants.id` (FK)

### **Default Account:**
- **Super Admin**
  - Email: `superadmin@example.com`
  - Password: `12345678`

---

## 🔧 Command Terminal yang Berguna

```bash
# Cek status migrations
php artisan migrate:status

# Jalankan Laravel development server
php artisan serve

# Compile assets (Tailwind CSS)
npm run dev

# Build production assets
npm run build

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## 📦 File-file Penting yang Dibuat

1. **`supabase_schema.sql`** - Complete SQL schema untuk Supabase
2. **`.env.example`** - Template konfigurasi environment
3. **`SETUP_GUIDE.md`** - Dokumentasi ini

---

## ⚠️ Catatan Penting

1. **Jangan commit file .env** - File ini berisi credential rahasia
2. **Password harus diganti** - Super admin default menggunakan password "12345678"
3. **Row Level Security (RLS)** - Sudah dikonfigurasi di schema SQL
4. **UUID sebagai Primary Key** - Tabel admins, restaurants, articles, dll menggunakan UUID

---

## 🐛 Troubleshooting

### Error: "could not find driver"
```bash
# Install PostgreSQL extension untuk PHP
# Windows: aktifkan extension=pdo_pgsql di php.ini
# Linux: sudo apt-get install php-pgsql
```

### Error: "Access denied" saat konek database
- Pastikan password database benar
- Cek IP whitelist di Supabase (Settings → Database → Connection pooling)

### Error: "SQLSTATE[08006]"
- Cek koneksi internet
- Pastikan host dan port Supabase benar
- Coba gunakan connection pooler: `db.xxxxx.supabase.co` → `db.xxxxx.pooler.supabase.co`

---

## 📞 Kontak & Referensi

- **Repository**: https://github.com/PPLKelompok411/SI4605-KEL411
- **Supabase Docs**: https://supabase.com/docs
- **Laravel Docs**: https://laravel.com/docs

---

**Status saat ini**: ✅ SQL Schema siap di-eksekusi ke Supabase

**Langkah selanjutnya**: Eksekusi `supabase_schema.sql` di SQL Editor Supabase Anda!
