# PINJAM AJA DULU — Aplikasi Manajemen Peminjaman

Ringkasan singkat: aplikasi Laravel untuk mengelola katalog alat, peminjaman, pengembalian, dan denda pada lingkungan sekolah/kampus.

## Fitur Utama

- Manajemen alat (CRUD)
- Permintaan peminjaman oleh peminjam
- Persetujuan / penolakan dan penyerahan alat oleh petugas
- Pemrosesan pengembalian (kondisi, terlambat, denda otomatis)
- Upload bukti pembayaran denda (peminjam)
- Log aktivitas untuk tindakan penting

## Struktur Proyek (ringkasan)

- `app/` — model, controller, provider
    - `app/Http/Controllers/Petugas` — controller untuk petugas (peminjaman, pengembalian, denda)
    - `app/Http/Controllers/Peminjam` — controller untuk peminjam
- `resources/views/` — Blade views
    - `resources/views/petugas/peminjamans` — tampilan manajemen peminjaman petugas
    - `resources/views/petugas/pengembalians` — tampilan pengembalian petugas (index/create/show)
    - `resources/views/peminjam` — tampilan untuk peminjam (peminjaman, pengembalian, denda)
- `routes/web.php` — deklarasi route; lihat grup `admin`, `petugas`, `peminjam` untuk endpoint role-specific

## Setup & Jalankan (dev)

1. Salin `.env.example` → `.env` dan atur koneksi database.
2. Install dependensi PHP dan JS:

```bash
composer install
npm install
npm run dev
```

3. Migrasi dan seeder (opsional):

```bash
php artisan migrate --seed
php artisan storage:link
```

4. Jalankan server lokal:

```bash
php artisan serve
```

## Endpoint Penting (petunjuk cepat)

- Petugas Dashboard: `/petugas/dashboard`
- Manajemen Peminjaman (petugas): `/petugas/peminjamans` — approve / reject / serahkan
- Manajemen Pengembalian (petugas): `/petugas/pengembalians` — proses pengembalian (`create` form menuliskan tanggal, jumlah, kondisi)`
- Peminjam (user): `/peminjam/peminjamans`, `/peminjam/pengembalians`, `/peminjam/dendas`

Catatan: nama route lengkap di `routes/web.php` menggunakan prefix `petugas.` / `peminjam.` / `admin.`; contoh: `petugas.peminjamans.approve`, `petugas.pengembalians.store`.

## Catatan Implementasi yang Perlu Diperhatikan

- Pengembalian: denda otomatis dibuat saat proses pengembalian jika terlambat atau kondisi alat tidak baik. Besaran denda ada di `PengembalianController`.
- Penyerahan alat (`hand-over`) diimplementasikan sebagai route POST bernama `petugas.peminjamans.hand-over`.
- Upload bukti pembayaran denda untuk peminjam memakai disk `public` — pastikan `php artisan storage:link` dijalankan.

## Pengujian Manual Singkat

1. Login sebagai petugas → buka `/petugas/peminjamans` → setujui permintaan → tombol `Serahkan` akan membuka modal konfirmasi.
2. Login sebagai petinjam → buat permintaan peminjaman → setelah dikembalikan petugas, cek `/peminjam/dendas` jika ada denda.

## Kontribusi & Pengembangan

- Ikuti alur branch: buat feature branch, push, dan buka PR.
- Jalankan `php artisan test` jika ada test suite ditambahkan.

## Lisensi

Project ini disesuaikan untuk kebutuhan internal; lisensi default MIT.

---

File dokumentasi utama: [README.md](README.md)
