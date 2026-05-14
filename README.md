# 🟦 BUDGETLY — Sistem Pencatatan Pengeluaran Usaha

Aplikasi web berbasis Laravel untuk mencatat dan mengelola pengeluaran usaha berdasarkan kategori.

---

## 📋 CARA INSTALASI (Laragon + MySQL)

### LANGKAH 1: Siapkan Project

1. Pastikan Laragon sudah berjalan (klik Start di Laragon)
2. Extract file `budgetly.zip` ke folder: `C:\laragon\www\budgetly`
3. Buka terminal/CMD di folder `C:\laragon\www\budgetly`

### LANGKAH 2: Install Dependensi

```bash
composer install
```

> Tunggu hingga semua package terinstall (butuh koneksi internet)

### LANGKAH 3: Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### LANGKAH 4: Buat Database

1. Buka **phpMyAdmin** di browser: http://localhost/phpmyadmin
2. Klik **"New"** atau **"Baru"**
3. Buat database baru dengan nama: **`budgetly`**
4. Pilih Collation: **`utf8mb4_unicode_ci`**
5. Klik **Create/Buat**

### LANGKAH 5: Sesuaikan File .env

Buka file `.env` dan sesuaikan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=budgetly
DB_USERNAME=root
DB_PASSWORD=         ← (kosongkan jika Laragon tanpa password)
```

> Laragon default: username = root, password = kosong

### LANGKAH 6: Migrasi & Seed Database

```bash
php artisan migrate --seed
```

### LANGKAH 7: Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 👤 AKUN DEMO

| Role  | Email                  | Password |
|-------|------------------------|----------|
| Admin | admin@budgetly.com     | admin123 |
| User  | budi@example.com       | user123  |
| User  | siti@example.com       | user123  |

---

## 🚀 FITUR SISTEM

### 👨‍💼 Fitur Admin:
- ✅ Login & Logout
- ✅ Dashboard dengan chart & statistik real-time
- ✅ Melihat & mengelola semua pengguna (aktifkan/nonaktifkan/hapus)
- ✅ Melihat semua pengeluaran dengan filter
- ✅ Mengelola kategori global

### 👤 Fitur User:
- ✅ Registrasi & Login (dengan password eye toggle)
- ✅ Dashboard dengan chart pengeluaran
- ✅ CRUD Pengeluaran (Tambah, Lihat, Edit, Hapus)
- ✅ Kategori pengeluaran (pribadi + global)
- ✅ Filter & pencarian pengeluaran
- ✅ Laporan visual (pie chart + bar chart)
- ✅ Export laporan ke PDF
- ✅ Export laporan ke CSV (Excel)

---

## 🛠️ TECH STACK

- **Backend**: Laravel 10 + PHP 8.1+
- **Database**: MySQL (via Laragon)
- **Frontend**: Bootstrap 5.3 + Font Awesome 6.5 + Chart.js 4.4
- **PDF Export**: barryvdh/laravel-dompdf
- **Fonts**: Google Fonts (Inter)

---

## 🎨 UI DESIGN

- Tema warna biru profesional (#1565C0 - #0D47A1)
- Sidebar navigasi dark blue
- Responsive di semua ukuran layar
- Real images dari Unsplash
- Password field dengan toggle show/hide (ikon mata)
- Chart interaktif (Line, Bar, Pie, Doughnut)
- Animasi hover pada card dan tombol

---

## ❓ TROUBLESHOOTING

**Error: Class not found**
```bash
composer dump-autoload
```

**Error: Key not set**
```bash
php artisan key:generate
```

**Error: Table not found**
```bash
php artisan migrate:fresh --seed
```

**Error: Permission denied (storage)**
```bash
php artisan storage:link
```

---

Dibuat oleh: Kelompok 9 — Rekayasa Perangkat Lunak, Universitas Diponegoro 2026
