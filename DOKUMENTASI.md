# Aplikasi Peminjaman Alat - Laravel 12

Aplikasi peminjaman alat berbasis web menggunakan Laravel 12 dengan Breeze dan Resource Controllers. Mendukung 3 role: **Admin**, **Petugas**, dan **Peminjam/Siswa**.

## 📋 Fitur Utama

### Role: Admin

- **Dashboard**: Statistik lengkap (total users, alat, peminjaman, denda)
- **User Management**: CRUD users dengan role
- **Kategori Management**: CRUD kategori alat
- **Alat Management**: CRUD alat dengan foto, stok, dan kategori
- **Peminjaman Management**:
    - Approve/reject peminjaman
    - Membuat peminjaman untuk user
    - View detail dan history
- **Pengembalian Management**: View semua pengembalian
- **Denda Management**: Kelola dan konfirmasi pembayaran denda
- **Activity Log**: View log aktivitas sistem

### Role: Petugas

- **Dashboard**: Statistik operasional (peminjaman menunggu, aktif, denda)
- **Peminjaman Management**:
    - Approve/reject peminjaman
    - Serah terima alat
- **Pengembalian Management**:
    - Proses pengembalian
    - Auto-calculate denda
- **Denda Management**: Konfirmasi pembayaran denda
- **Alat**: View katalog alat

### Role: Peminjam/Siswa

- **Dashboard**: Statistik personal peminjaman
- **Browse Alat**: Katalog alat yang tersedia
- **Peminjaman**:
    - Ajukan peminjaman
    - Track status peminjaman
    - Cancel peminjaman (status: menunggu)
- **Pengembalian**: View history pengembalian
- **Denda**: View dan upload bukti pembayaran denda

---

## 📁 Struktur Folder

```
peminjaman-alat/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Controllers untuk Admin
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── KategoriController.php
│   │   │   │   ├── AlatController.php
│   │   │   │   ├── PeminjamanController.php
│   │   │   │   ├── PengembalianController.php
│   │   │   │   ├── DendaController.php
│   │   │   │   └── AktivitasController.php
│   │   │   │
│   │   │   ├── Petugas/            # Controllers untuk Petugas
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── PeminjamanController.php
│   │   │   │   ├── PengembalianController.php
│   │   │   │   ├── DendaController.php
│   │   │   │   └── AlatController.php
│   │   │   │
│   │   │   ├── Peminjam/           # Controllers untuk Peminjam/Siswa
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── AlatController.php
│   │   │   │   ├── PeminjamanController.php
│   │   │   │   ├── PengembalianController.php
│   │   │   │   └── DendaController.php
│   │   │   │
│   │   │   ├── Controller.php
│   │   │   └── ProfileController.php
│   │   │
│   │   └── Middlewares/
│   │       ├── RoleMiddleware.php     # Flexible role middleware
│   │       ├── AdminMiddleware.php    # Khusus admin
│   │       ├── PetugasMiddleware.php  # Khusus petugas
│   │       └── SiswaMiddleware.php    # Khusus siswa
│   │
│   └── Models/
│       ├── User.php
│       ├── Role.php
│       ├── Kategori.php
│       ├── Alat.php
│       ├── Peminjaman.php
│       ├── Pengembalian.php
│       ├── Denda.php
│       └── Aktivitas.php
│
├── database/
│   ├── migrations/
│   │   ├── 2026_02_08_115248_create_roles_table.php
│   │   ├── 2026_02_08_115452_add_user_credential.php
│   │   ├── 2026_02_08_115907_create_kategoris_table.php
│   │   ├── 2026_02_08_120202_create_alats_table.php
│   │   ├── 2026_02_08_120326_create_peminjamen_table.php
│   │   ├── 2026_02_08_120427_create_pengembalians_table.php
│   │   ├── 2026_02_08_120457_create_dendas_table.php
│   │   └── 2026_02_08_120541_create_aktivitas_table.php
│   │
│   └── seeders/
│       ├── RoleSeeder.php
│       ├── UserSeeder.php
│       ├── KategoriSeeder.php
│       └── AlatSeeder.php
│
├── routes/
│   ├── web.php        # Routes dengan middleware role
│   └── auth.php       # Auth routes dari Breeze
│
└── resources/
    └── views/
        ├── admin/     # Views untuk admin (belum dibuat)
        ├── petugas/   # Views untuk petugas (belum dibuat)
        └── peminjam/  # Views untuk peminjam (belum dibuat)
```

---

## 🔐 Middleware & Authentication

### Middleware yang Tersedia

1. **RoleMiddleware** (`role`)
    - Flexible middleware untuk check multiple roles
    - Normalisasi nama role (case-insensitive, handle spasi)
    - Support alias: `siswa` → `peminjam`, `petugas peminjaman` → `petugas`

    **Contoh penggunaan:**

    ```php
    Route::middleware(['auth', 'role:admin'])->group(function() {
        // Routes untuk admin
    });

    Route::middleware(['auth', 'role:admin,petugas'])->group(function() {
        // Routes untuk admin atau petugas
    });
    ```

2. **AdminMiddleware** (`admin`)
    - Khusus untuk admin

3. **PetugasMiddleware** (`petugas`)
    - Khusus untuk petugas

4. **SiswaMiddleware** (`siswa`)
    - Khusus untuk siswa/peminjam

### Registrasi Middleware

Di `bootstrap/app.php`:

```php
$middleware->alias([
    'role' => RoleMiddleware::class,
    'admin' => AdminMiddleware::class,
    'petugas' => PetugasMiddleware::class,
    'siswa' => SiswaMiddleware::class,
]);
```

---

## 🛣️ Route Structure

### Admin Routes

**Prefix:** `/admin`  
**Middleware:** `auth`, `role:admin`  
**Name prefix:** `admin.`

```
GET    /admin/dashboard                    -> admin.dashboard
CRUD   /admin/users                        -> admin.users.*
CRUD   /admin/kategoris                    -> admin.kategoris.*
CRUD   /admin/alats                        -> admin.alats.*
CRUD   /admin/peminjamans                  -> admin.peminjamans.*
POST   /admin/peminjamans/{id}/approve     -> admin.peminjamans.approve
POST   /admin/peminjamans/{id}/reject      -> admin.peminjamans.reject
GET    /admin/pengembalians                -> admin.pengembalians.index
GET    /admin/pengembalians/{id}           -> admin.pengembalians.show
CRUD   /admin/dendas (except create, store, destroy)
POST   /admin/dendas/{id}/confirm-payment  -> admin.dendas.confirm-payment
GET    /admin/aktivitas                    -> admin.aktivitas.index
```

### Petugas Routes

**Prefix:** `/petugas`  
**Middleware:** `auth`, `role:petugas`  
**Name prefix:** `petugas.`

```
GET    /petugas/dashboard                      -> petugas.dashboard
GET    /petugas/peminjamans                    -> petugas.peminjamans.index
POST   /petugas/peminjamans/{id}/approve       -> petugas.peminjamans.approve
POST   /petugas/peminjamans/{id}/reject        -> petugas.peminjamans.reject
POST   /petugas/peminjamans/{id}/hand-over     -> petugas.peminjamans.hand-over
CRUD   /petugas/pengembalians (except edit, update, destroy)
GET    /petugas/dendas                         -> petugas.dendas.index
POST   /petugas/dendas/{id}/confirm-payment    -> petugas.dendas.confirm-payment
GET    /petugas/alats                          -> petugas.alats.index
```

### Peminjam/Siswa Routes

**Prefix:** `/peminjam`  
**Middleware:** `auth`, `role:peminjam,siswa`  
**Name prefix:** `peminjam.`

```
GET    /peminjam/dashboard                  -> peminjam.dashboard
GET    /peminjam/alats                      -> peminjam.alats.index (browse katalog)
GET    /peminjam/alats/{id}                 -> peminjam.alats.show
CRUD   /peminjam/peminjamans (except edit, update, destroy)
POST   /peminjam/peminjamans/{id}/cancel    -> peminjam.peminjamans.cancel
GET    /peminjam/pengembalians              -> peminjam.pengembalians.index
GET    /peminjam/dendas                     -> peminjam.dendas.index
POST   /peminjam/dendas/{id}/upload-bukti   -> peminjam.dendas.upload-bukti
```

---

## 🗄️ Database Schema

### Table: users

```
id, username, password, email, role_id, nama_lengkap, nomor_identitas,
created_at, updated_at
```

### Table: roles

```
id, nama_role, deleted_at, created_at
```

### Table: kategoris

```
id, nama_kategori, deleted_at, created_at
```

### Table: alats

```
id, nama_alat, kode_alat (unique), deskripsi, stok, stok_tersedia,
kategori_id, status, foto, deleted_at, created_at, updated_at
```

### Table: peminjamans

```
id, kode_peminjaman (unique), user_id, alat_id, jumlah,
tanggal_peminjaman, tanggal_berakhir_peminjaman,
status (menunggu_konfirmasi, disetujui, ditolak, dipinjam, dikembalikan, melewati_jadwal),
keperluan, catatan_admin, disetujui_oleh, tanggal_disetujui,
deleted_at, created_at, updated_at
```

### Table: pengembalians

```
id, peminjaman_id, tanggal_pengembalian, jumlah_dikembalikan,
kondisi_alat (baik, rusak, hilang, tidak_lengkap),
diterima_oleh, terlambat, hari_terlambat, catatan,
created_at, updated_at
```

### Table: dendas

```
id, pengembalian_id, total_denda, bukti_pembayaran,
status (sudah_dibayar, belum_dibayar),
deleted_at, created_at, updated_at
```

### Table: aktivitas

```
id, user_id, aktivitas, deskripsi, created_at
```

---

## 🚀 Instalasi & Setup

### 1. Clone/Setup Project

```bash
cd c:/laragon/www/peminjaman-alat
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=peminjaman_alat
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration & Seeding

```bash
php artisan migrate:fresh --seed
```

### 5. Storage Link

```bash
php artisan storage:link
```

### 6. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 7. Run Application

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

---

## 👥 Default Users (setelah seeding)

| Role           | Username | Email               | Password |
| -------------- | -------- | ------------------- | -------- |
| Admin          | admin    | admin@example.com   | password |
| Petugas        | petugas  | petugas@example.com | password |
| Siswa/Peminjam | siswa    | siswa@example.com   | password |

---

## 📝 Flow Aplikasi

### Flow Peminjaman

1. **Siswa mengajukan peminjaman**
    - Browse alat di katalog
    - Pilih alat → Create peminjaman
    - Status: `menunggu_konfirmasi`

2. **Admin/Petugas mereview**
    - Approve → Status: `disetujui`, stok dikurangi
    - Reject → Status: `ditolak`

3. **Petugas serah terima alat**
    - Hand over → Status: `dipinjam`

4. **Petugas proses pengembalian**
    - Input pengembalian (jumlah, kondisi, tanggal)
    - System auto-calculate denda jika:
        - Terlambat: Rp 5.000/hari
        - Rusak: Rp 50.000
        - Hilang: Rp 200.000
        - Tidak lengkap: Rp 25.000
    - Status peminjaman: `dikembalikan`
    - Stok dikembalikan

5. **Siswa bayar denda (jika ada)**
    - Upload bukti pembayaran
    - Petugas konfirmasi → Status denda: `sudah_dibayar`

---

## 🎯 Best Practices

### Controllers

- Setiap role punya folder controller sendiri
- Gunakan Resource Controllers untuk CRUD standar
- Custom methods untuk actions khusus (approve, reject, dll)
- Authorization check di dalam controller jika diperlukan

### Models

- Gunakan `$guarded` atau `$fillable` untuk mass assignment
- Define relationships lengkap
- Gunakan scopes untuk query yang sering dipakai
- Cast attributes sesuai tipe data

### Middleware

- Gunakan `RoleMiddleware` untuk flexible role checking
- Support multiple roles dengan comma-separated
- Normalisasi role names untuk konsistensi

### Routes

- Group by role dengan prefix dan middleware
- Gunakan resource routes untuk CRUD
- Named routes untuk kemudahan maintenance

---

## 🔧 Kustomisasi

### Mengubah Tarif Denda

Edit `app/Http/Controllers/Petugas/PengembalianController.php`:

```php
// Line ~97-109
if ($terlambat) {
    $totalDenda += $hariTerlambat * 5000; // Ubah di sini
}

if ($validated['kondisi_alat'] === 'rusak') {
    $totalDenda += 50000; // Ubah di sini
} elseif ($validated['kondisi_alat'] === 'hilang') {
    $totalDenda += 200000; // Ubah di sini
} elseif ($validated['kondisi_alat'] === 'tidak_lengkap') {
    $totalDenda += 25000; // Ubah di sini
}
```

### Menambah Role Baru

1. Tambahkan di `database/seeders/RoleSeeder.php`
2. Update `app/Http/Middlewares/RoleMiddleware.php` jika perlu alias
3. Buat folder controller baru
4. Tambahkan routes di `routes/web.php`

---

## 📚 Next Steps

1. **Buat Views untuk setiap role**
    - `resources/views/admin/`
    - `resources/views/petugas/`
    - `resources/views/peminjam/`

2. **Implementasi Notifications**
    - Email notification untuk approval/rejection
    - Reminder untuk peminjaman yang akan berakhir

3. **Export/Report**
    - Export laporan peminjaman (Excel/PDF)
    - Grafik statistik dashboard

4. **API (Optional)**
    - REST API untuk mobile app
    - API authentication dengan Sanctum

---

## 🐛 Troubleshooting

### Error: Class 'RoleMiddleware' not found

- Pastikan middleware sudah diregistrasi di `bootstrap/app.php`
- Clear cache: `php artisan config:clear`

### Error: Storage link not found

- Jalankan: `php artisan storage:link`

### Error: SQLSTATE connection refused

- Pastikan MySQL/MariaDB sudah running
- Cek credentials di `.env`

---

## 📄 License

This project is open-sourced software licensed under the MIT license.

---

## 👨‍💻 Developer Notes

- Laravel Version: 12
- PHP Version: ^8.2
- Breeze: Authentication scaffolding
- Database: MySQL/MariaDB
- Frontend: Blade + Tailwind CSS (via Breeze)

**Created:** February 8, 2026
