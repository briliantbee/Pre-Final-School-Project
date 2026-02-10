<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AlatController as AdminAlatController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Admin\DendaController as AdminDendaController;
use App\Http\Controllers\Admin\AktivitasController;

// Petugas Controllers
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;
use App\Http\Controllers\Petugas\DendaController as PetugasDendaController;
use App\Http\Controllers\Petugas\AlatController as PetugasAlatController;

// Peminjam Controllers
use App\Http\Controllers\Peminjam\DashboardController as PeminjamDashboard;
use App\Http\Controllers\Peminjam\AlatController as PeminjamAlatController;
use App\Http\Controllers\Peminjam\PeminjamanController as PeminjamPeminjamanController;
use App\Http\Controllers\Peminjam\PengembalianController as PeminjamPengembalianController;
use App\Http\Controllers\Peminjam\DendaController as PeminjamDendaController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Redirect dashboard based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $role = strtolower(str_replace(' ', '', $user->role->nama_role));
        
        if (in_array($role, ['admin'])) {
            return redirect()->route('admin.dashboard');
        } elseif (in_array($role, ['petugas', 'petugaspeminjaman'])) {
            return redirect()->route('petugas.dashboard');
        } else {
            return redirect()->route('peminjam.dashboard');
        }
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Kategori Management
    Route::resource('kategoris', KategoriController::class);
    
    // Alat Management
    Route::resource('alats', AdminAlatController::class);
    
    // Peminjaman Management
    Route::resource('peminjamans', AdminPeminjamanController::class);
    Route::post('peminjamans/{peminjaman}/approve', [AdminPeminjamanController::class, 'approve'])->name('peminjamans.approve');
    Route::post('peminjamans/{peminjaman}/reject', [AdminPeminjamanController::class, 'reject'])->name('peminjamans.reject');
    
    // Pengembalian Management
    Route::resource('pengembalians', AdminPengembalianController::class)->only(['index', 'show']);
    
    // Denda Management
    Route::resource('dendas', AdminDendaController::class)->except(['create', 'store', 'destroy']);
    Route::post('dendas/{denda}/confirm-payment', [AdminDendaController::class, 'confirmPayment'])->name('dendas.confirm-payment');
    
    // Activity Log
    Route::resource('aktivitas', AktivitasController::class)->only(['index', 'show']);
});

/*
|--------------------------------------------------------------------------
| Petugas Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
    
    // Peminjaman Management
    Route::resource('peminjamans', PetugasPeminjamanController::class)->only(['index', 'show']);
    Route::post('peminjamans/{peminjaman}/approve', [PetugasPeminjamanController::class, 'approve'])->name('peminjamans.approve');
    Route::post('peminjamans/{peminjaman}/reject', [PetugasPeminjamanController::class, 'reject'])->name('peminjamans.reject');
    Route::post('peminjamans/{peminjaman}/hand-over', [PetugasPeminjamanController::class, 'handOver'])->name('peminjamans.hand-over');
    Route::get('peminjamans/export/excel', [PetugasPeminjamanController::class, 'exportExcel'])->name('peminjamans.export');
    
    // Pengembalian Management
    Route::resource('pengembalians', PetugasPengembalianController::class)->except(['edit', 'update', 'destroy']);
    Route::get('pengembalians/export/excel', [PetugasPengembalianController::class, 'exportExcel'])->name('pengembalians.export');
    
    // Denda Management
    Route::resource('dendas', PetugasDendaController::class)->only(['index', 'show']);
    Route::post('dendas/{denda}/confirm-payment', [PetugasDendaController::class, 'confirmPayment'])->name('dendas.confirm-payment');
    
    // Alat (View Only)
    Route::resource('alats', PetugasAlatController::class)->only(['index', 'show']);
    Route::get('alats/export/excel', [PetugasAlatController::class, 'exportExcel'])->name('alats.export');
});

/*
|--------------------------------------------------------------------------
| Peminjam/Siswa Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:peminjam,siswa'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/dashboard', [PeminjamDashboard::class, 'index'])->name('dashboard');
    
    // Browse Alat
    Route::resource('alats', PeminjamAlatController::class)->only(['index', 'show']);
    
    // Peminjaman Management
    Route::resource('peminjamans', PeminjamPeminjamanController::class)->except(['edit', 'update', 'destroy']);
    Route::post('peminjamans/{peminjaman}/cancel', [PeminjamPeminjamanController::class, 'cancel'])->name('peminjamans.cancel');
    
    // Pengembalian (View Only)
    Route::resource('pengembalians', PeminjamPengembalianController::class)->only(['index', 'show']);
    
    // Denda Management
    Route::resource('dendas', PeminjamDendaController::class)->only(['index', 'show']);
    Route::post('dendas/{denda}/upload-bukti', [PeminjamDendaController::class, 'uploadBukti'])->name('dendas.upload-bukti');
});

require __DIR__.'/auth.php';

