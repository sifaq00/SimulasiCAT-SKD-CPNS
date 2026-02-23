# Simulasi CAT CPNS Platform

Platform Simulasi _Computer Assisted Test_ (CAT) untuk persiapan seleksi CPNS. Aplikasi ini dibangun menggunakan **Laravel 12**, **Livewire 3**, dan **Tailwind CSS**.

## 🚀 Fitur Utama

- **Simulasi Real-time:** Timer ujian, navigasi soal, dan penyimpanan jawaban otomatis.
- **Sistem Bundle:** Manajemen paket soal satuan maupun bundle (hemat harga).
- **Payment Gateway:** Integrasi Midtrans (Snap) untuk pembayaran otomatis.
- **Lockdown Browser (Middleware):** Mencegah peserta ujian membuka halaman lain (Dashboard/Profile) saat ujian berlangsung.
- **Analisis Nilai:** Perhitungan skor SKD (TWK, TIU, TKP) dan status kelulusan (Passing Grade) secara instan.
- **Admin Panel:** Manajemen soal, paket, bundle, user, dan transaksi.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12, MySQL 8
- **Frontend:** Blade, Livewire 3, Tailwind CSS, Alpine.js
- **Payment:** Midtrans Snap API
- **Icons:** Heroicons

---

## 💻 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

---

## 📦 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di lokal:

### 1. Clone Repository & Install Dependencies

```bash
git clone https://github.com/sifaq00/SimulasiCAT-SKD-CPNS.git
cd SimulasiCAT-SKD-CPNS

# Install PHP dependencies
composer install

# Install JS dependencies
npm install && npm run build
```

### 2. Konfigurasi Environment (.env)

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Atur konfigurasi database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simulasi_cpns
DB_USERNAME=root
DB_PASSWORD=
```

Atur URL aplikasi (PENTING untuk Midtrans callback):

```env
APP_URL=http://127.0.0.1:8000
```

### 3. Konfigurasi Midtrans

Tambahkan kredensial Midtrans (Mode Sandbox untuk development) di `.env`:

```env
MIDTRANS_MERCHANT_ID=your-merchant-id
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_IS_PRODUCTION=false
```

### 4. Setup Database

Jalankan migrasi dan seeder untuk mengisi data awal (Kategori, Paket, Bundle, Soal, & Admin):

```bash
# Opsi 1: Setup awal (jika database kosong)
php artisan migrate --seed

# Opsi 2: Reset total (HAPUS SEMUA DATA user & transaksi)
php artisan migrate:fresh --seed
```

> **Note:** Seeder akan membuat akun Admin default:
>
> - Email: `admin@simulasicpns.test`
> - Password: `password`
>
> **Data yang di-generate otomatis:**
>
> - **1 Paket Gratis:** 30 Soal (10 TWK, 10 TIU, 10 TKP)
> - **4 Paket Berbayar:** SKD 2019, 2021, 2024, 2026 (110 Soal/paket)
> - **1 Bundle Hemat:** Paket Lengkap Semua Tahun (Diskon 35%)
> - **Total Soal:** 470 Soal + 2350 Opsi Jawaban

### 5. Jalankan Aplikasi

Jalankan server lokal Laravel:

```bash
php artisan serve
```

Akses aplikasi di `http://127.0.0.1:8000`.

---

## 📖 Panduan Penggunaan

### A. Alur User (Peserta)

1. **Registrasi/Login:** Buat akun baru.
2. **Beli Paket:** Pilih paket atau bundle di halaman Home. Klik "Beli".
3. **Pembayaran:** Selesaikan pembayaran via Midtrans (Qris/VA/E-wallet).
4. **Dashboard:**
    - Setelah bayar, sistem otomatis redirect ke Dashboard.
    - Paket yang dibeli muncul di daftar "Siap Dikerjakan".
5. **Ujian:**
    - Klik "Kerjakan".
    - **Lockdown Mode Aktif:** Anda tidak bisa membuka halaman lain sampai ujian selesai.
    - Kerjakan 110 soal dalam 100 menit.
6. **Hasil:** Skor TWK, TIU, TKP langsung muncul beserta status Lulus/Tidak.

### B. Alur Admin

1. Login dengan akun Admin.
2. Akses Panel Admin melalui menu dropdown profil -> **Admin Panel**.
3. **Menu Admin:**
    - **Manage Soal:** Tambah/Edit/Import soal ujian.
    - **Manage Paket:**
        - **Paket:** Buat paket simulasi (tahun, harga, durasi).
        - **Bundle:** Buat bundle yang berisi beberapa paket (diskon).
    - **Manage User:** Lihat daftar user terdaftar.
    - **Transaksi:** Pantau status pembayaran user.

---

## 🔒 Keamanan & Logika (Developer Notes)

1. **ForceActiveTest Middleware:**
   Middleware ini memeriksa tabel `test_attempts`. Jika user memiliki status `in_progress`, setiap request ke halaman non-ujian akan di-redirect paksa kembali ke halaman ujian tersebut.

2. **Bundle Logic:**
   Bundle disimpan sebagai entitas terpisah namun berelasi Many-to-Many dengan `packages`. Saat user membeli bundle, sistem mengecek relasi ini untuk memberikan akses ke semua paket di dalamnya.

3. **Dashboard Filtering:**
   Paket yang sudah dikerjakan (status `completed`) otomatis disembunyikan dari daftar "Siap Dikerjakan" menggunakan filtering logic pada `Dashboard.php` Livewire component.

---

## 🤝 Kontribusi

Silakan buat _Pull Request_ baru jika ingin menambahkan fitur atau memperbaiki bug.

---

## 📄 Lisensi

[MIT License](https://opensource.org/licenses/MIT).
