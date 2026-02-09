# Quick Reference - Struktur Aplikasi Peminjaman Alat

## 🗂️ Struktur Folder Controllers

```
app/Http/Controllers/
│
├── Admin/                           # Admin Controllers (Full Access)
│   ├── DashboardController.php     # Dashboard dengan statistik lengkap
│   ├── UserController.php          # CRUD Users
│   ├── KategoriController.php      # CRUD Kategori
│   ├── AlatController.php          # CRUD Alat (dengan foto & stok)
│   ├── PeminjamanController.php    # Kelola peminjaman, approve/reject, create
│   ├── PengembalianController.php  # View pengembalian (read-only)
│   ├── DendaController.php         # Kelola denda, konfirmasi pembayaran
│   └── AktivitasController.php     # View activity logs (read-only)
│
├── Petugas/                         # Petugas Controllers (Operational)
│   ├── DashboardController.php     # Dashboard operasional
│   ├── PeminjamanController.php    # Approve/reject, serah terima alat
│   ├── PengembalianController.php  # Proses pengembalian + auto-calculate denda
│   ├── DendaController.php         # View & konfirmasi pembayaran denda
│   └── AlatController.php          # View katalog alat (read-only)
│
├── Peminjam/                        # Peminjam/Siswa Controllers (Limited)
│   ├── DashboardController.php     # Dashboard personal
│   ├── AlatController.php          # Browse katalog alat tersedia
│   ├── PeminjamanController.php    # Ajukan peminjaman, track status, cancel
│   ├── PengembalianController.php  # View history pengembalian (read-only)
│   └── DendaController.php         # View denda & upload bukti pembayaran
│
├── Controller.php                   # Base Controller
└── ProfileController.php            # Profile management (Breeze)
```

---

## 🔐 Middleware Configuration

### Lokasi: `app/Http/Middlewares/`

| Middleware              | Alias     | Deskripsi                                           |
| ----------------------- | --------- | --------------------------------------------------- |
| `RoleMiddleware.php`    | `role`    | Flexible, support multiple roles dengan normalisasi |
| `AdminMiddleware.php`   | `admin`   | Khusus admin                                        |
| `PetugasMiddleware.php` | `petugas` | Khusus petugas                                      |
| `SiswaMiddleware.php`   | `siswa`   | Khusus siswa/peminjam                               |

### Cara Pakai:

```php
// Single role
Route::middleware(['auth', 'role:admin'])->group(...);

// Multiple roles
Route::middleware(['auth', 'role:admin,petugas'])->group(...);

// Alias support
Route::middleware(['auth', 'role:siswa'])->group(...);  // sama dengan 'peminjam'
```

---

## 🛣️ Route Mapping

### Admin Routes (`/admin/*`)

```
Dashboard      GET    /admin/dashboard
Users          CRUD   /admin/users
Kategoris      CRUD   /admin/kategoris
Alats          CRUD   /admin/alats
Peminjamans    CRUD   /admin/peminjamans
               POST   /admin/peminjamans/{id}/approve
               POST   /admin/peminjamans/{id}/reject
Pengembalians  GET    /admin/pengembalians (index, show)
Dendas         CRUD   /admin/dendas (except create, store, destroy)
               POST   /admin/dendas/{id}/confirm-payment
Aktivitas      GET    /admin/aktivitas (index, show)
```

### Petugas Routes (`/petugas/*`)

```
Dashboard      GET    /petugas/dashboard
Peminjamans    GET    /petugas/peminjamans (index, show)
               POST   /petugas/peminjamans/{id}/approve
               POST   /petugas/peminjamans/{id}/reject
               POST   /petugas/peminjamans/{id}/hand-over
Pengembalians  CRUD   /petugas/pengembalians (except edit, update, destroy)
Dendas         GET    /petugas/dendas (index, show)
               POST   /petugas/dendas/{id}/confirm-payment
Alats          GET    /petugas/alats (index, show)
```

### Peminjam Routes (`/peminjam/*`)

```
Dashboard      GET    /peminjam/dashboard
Alats          GET    /peminjam/alats (index, show - browse katalog)
Peminjamans    CRUD   /peminjam/peminjamans (except edit, update, destroy)
               POST   /peminjam/peminjamans/{id}/cancel
Pengembalians  GET    /peminjam/pengembalians (index, show)
Dendas         GET    /peminjam/dendas (index, show)
               POST   /peminjam/dendas/{id}/upload-bukti
```

---

## 🗄️ Models & Relationships

### User.php

```php
// Relationships
- belongsTo: Role
- hasMany: Peminjaman (sebagai peminjam)
- hasMany: Aktivitas
- hasMany: Pengembalian (sebagai penerima, via 'diterima_oleh')
```

### Role.php

```php
// Relationships
- hasMany: User
```

### Kategori.php

```php
// Relationships
- hasMany: Alat
```

### Alat.php

```php
// Relationships
- belongsTo: Kategori
- hasMany: Peminjaman
```

### Peminjaman.php

```php
// Relationships
- belongsTo: User (peminjam)
- belongsTo: Alat
- belongsTo: User (disetujui_oleh)
- hasOne: Pengembalian

// Scopes
- menungguKonfirmasi()
- disetujui()
- ditolak()
- dipinjam()
- dikembalikan()
- melewatiJadwal()
```

### Pengembalian.php

```php
// Relationships
- belongsTo: Peminjaman
- belongsTo: User (diterima_oleh / diterimaDosen)
- hasOne: Denda
```

### Denda.php

```php
// Relationships
- belongsTo: Pengembalian
```

### Aktivitas.php

```php
// Relationships
- belongsTo: User
```

---

## 📊 Status Flow

### Status Peminjaman

```
[Siswa Ajukan]
    ↓
menunggu_konfirmasi
    ↓
[Admin/Petugas Review]
    ↓
┌───────────┬────────────┐
↓           ↓            ↓
disetujui   ditolak    [cancel by siswa]
    ↓
[Petugas Hand Over]
    ↓
dipinjam
    ↓
[Petugas Proses Pengembalian]
    ↓
dikembalikan
```

### Status Denda

```
[Auto-created saat pengembalian jika ada masalah]
    ↓
belum_dibayar
    ↓
[Siswa upload bukti]
    ↓
[Petugas konfirmasi]
    ↓
sudah_dibayar
```

---

## 🎯 Permissions Matrix

| Feature                         | Admin           | Petugas           | Peminjam/Siswa     |
| ------------------------------- | --------------- | ----------------- | ------------------ |
| **Dashboard**                   | Full stats      | Operational stats | Personal stats     |
| **User Management**             | ✅ CRUD         | ❌                | ❌                 |
| **Kategori**                    | ✅ CRUD         | ❌                | ❌                 |
| **Alat**                        | ✅ CRUD         | 👁️ View           | 👁️ Browse          |
| **Peminjaman - Create**         | ✅ For any user | ❌                | ✅ For self        |
| **Peminjaman - Approve/Reject** | ✅              | ✅                | ❌                 |
| **Peminjaman - Hand Over**      | ❌              | ✅                | ❌                 |
| **Peminjaman - Cancel**         | ✅              | ❌                | ✅ (menunggu only) |
| **Pengembalian - Process**      | ❌              | ✅                | ❌                 |
| **Pengembalian - View**         | ✅ All          | ✅ All            | 👁️ Own only        |
| **Denda - Manage**              | ✅              | ✅                | ❌                 |
| **Denda - Upload Bukti**        | ❌              | ❌                | ✅ Own only        |
| **Denda - Confirm Payment**     | ✅              | ✅                | ❌                 |
| **Activity Log**                | 👁️ View         | ❌                | ❌                 |

**Legend:**

- ✅ Full Access
- 👁️ View/Read Only
- ❌ No Access

---

## 💰 Tarif Denda (Default)

| Jenis          | Tarif             |
| -------------- | ----------------- |
| Keterlambatan  | Rp 5.000 per hari |
| Kondisi Rusak  | Rp 50.000         |
| Kondisi Hilang | Rp 200.000        |
| Tidak Lengkap  | Rp 25.000         |

**Lokasi kode:** `app/Http/Controllers/Petugas/PengembalianController.php` (line ~97-109)

---

## 📝 Code Conventions

### Naming Conventions

- **Controllers:** `{Entity}Controller.php` (PascalCase)
- **Models:** `{Entity}.php` (PascalCase, singular)
- **Migrations:** `{date}_create_{entities}_table.php` (snake_case, plural)
- **Routes:** `{role}.{entity}.{action}` (kebab-case)

### Controller Methods (Resource)

```php
index()     // List semua
create()    // Form tambah
store()     // Simpan baru
show($id)   // Detail satu item
edit($id)   // Form edit
update($id) // Update item
destroy($id)// Hapus item
```

### Custom Controller Methods

```php
approve($id)         // Setujui
reject($id)          // Tolak
cancel($id)          // Batalkan
handOver($id)        // Serah terima
confirmPayment($id)  // Konfirmasi bayar
uploadBukti($id)     // Upload bukti
```

---

## 🔄 Common Operations

### Check User Role

```php
// In Controller
$user = auth()->user();
$roleName = $user->role->nama_role;

// Using helper (jika dibuat)
if ($user->isAdmin()) { ... }
if ($user->isPetugas()) { ... }
if ($user->isSiswa()) { ... }
```

### Log Activity

```php
use App\Models\Aktivitas;

Aktivitas::create([
    'user_id' => auth()->id(),
    'aktivitas' => 'Judul Aktivitas',
    'deskripsi' => 'Detail aktivitas...',
]);
```

### Calculate Denda

```php
// Keterlambatan
$hariTerlambat = Carbon::parse($tanggalKembali)
    ->diffInDays($tanggalBerakhir);
$dendaKeterlambatan = $hariTerlambat * 5000;

// Kerusakan
$dendaKerusakan = match($kondisiAlat) {
    'rusak' => 50000,
    'hilang' => 200000,
    'tidak_lengkap' => 25000,
    default => 0,
};

$totalDenda = $dendaKeterlambatan + $dendaKerusakan;
```

### Update Stok Alat

```php
// Kurangi stok saat approve
$alat->decrement('stok_tersedia', $jumlah);
if ($alat->stok_tersedia == 0) {
    $alat->update(['status' => 'tidak_tersedia']);
}

// Kembalikan stok saat pengembalian
$alat->increment('stok_tersedia', $jumlah);
if ($alat->stok_tersedia > 0) {
    $alat->update(['status' => 'tersedia']);
}
```

---

## 🚨 Important Notes

1. **Middleware:** Semua routes yang butuh auth harus wrapped dengan `auth` middleware
2. **Authorization:** Additional check di controller jika user hanya boleh akses data sendiri
3. **Validation:** Selalu validate input di controller
4. **Transaction:** Gunakan `DB::transaction()` untuk operasi multi-step
5. **Soft Delete:** Kategori, Alat, Peminjaman, Denda menggunakan soft deletes
6. **File Upload:** Foto alat & bukti pembayaran disimpan di `storage/app/public`
7. **Auto Generate:** Kode peminjaman auto-generate format: `PMJ00001`, `PMJ00002`, dst.

---

## 📞 Need Help?

Lihat dokumentasi lengkap di [`DOKUMENTASI.md`](DOKUMENTASI.md)

---

**Last Updated:** February 8, 2026
