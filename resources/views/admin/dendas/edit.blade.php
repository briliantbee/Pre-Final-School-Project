@extends('layouts.sidebar')

@section('title', 'Edit Denda')

@section('navigation')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
</a>

<a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    Kelola User
</a>

<a href="{{ route('admin.kategoris.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
    </svg>
    Kategori Alat
</a>

<a href="{{ route('admin.alats.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
    Kelola Alat
</a>

<a href="{{ route('admin.peminjamans.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Peminjaman
</a>

<a href="{{ route('admin.pengembalians.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
    </svg>
    Pengembalian
</a>

<a href="{{ route('admin.dendas.index') }}" class="flex items-center px-6 py-3 text-white bg-blue-700 border-l-4 border-blue-400">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Denda
</a>

<a href="{{ route('admin.aktivitas.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Activity Log
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto" x-data="{
    dendaKeterlambatan: {{ old('denda_keterlambatan', $denda->denda_keterlambatan) }},
    dendaKerusakan: {{ old('denda_kerusakan', $denda->denda_kerusakan) }},
    previewImage: null,
    get totalDenda() {
        return parseInt(this.dendaKeterlambatan || 0) + parseInt(this.dendaKerusakan || 0);
    },
    formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    handleFilePreview(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.previewImage = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
        <a href="{{ route('admin.dendas.index') }}" class="hover:text-blue-600">Denda</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('admin.dendas.show', $denda->id) }}" class="hover:text-blue-600">Detail</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-900 font-medium">Edit</span>
    </nav>

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Denda</h1>
                <p class="text-sm text-gray-600 mt-1">Perbarui jumlah denda dan status pembayaran</p>
            </div>
            <a href="{{ route('admin.dendas.show', $denda->id) }}" 
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.dendas.update', $denda->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Informasi Peminjaman -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informasi Peminjaman
            </h2>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Peminjaman</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                        {{ $denda->peminjaman->kode_peminjaman ?? '-' }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Peminjam</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                        {{ $denda->peminjaman->user->name ?? '-' }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alat</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                        {{ $denda->peminjaman->alat->nama_alat ?? '-' }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hari Terlambat</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                        {{ $denda->hari_terlambat ?? 0 }} Hari
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Denda -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Detail Denda
            </h2>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Denda Keterlambatan
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                        <input 
                            type="number" 
                            name="denda_keterlambatan" 
                            x-model.number="dendaKeterlambatan"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            min="0"
                            step="1000"
                            required />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Denda per hari keterlambatan</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Denda Kerusakan
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                        <input 
                            type="number" 
                            name="denda_kerusakan" 
                            x-model.number="dendaKerusakan"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            min="0"
                            step="1000"
                            required />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Biaya kerusakan atau kehilangan alat</p>
                </div>
            </div>

            <!-- Total Denda Display -->
            <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Total Denda</span>
                    <span class="text-2xl font-bold text-blue-600" x-text="formatRupiah(totalDenda)"></span>
                </div>
                <input type="hidden" name="total_denda" :value="totalDenda">
            </div>
        </div>

        <!-- Status & Bukti Pembayaran -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Status & Bukti Pembayaran
            </h2>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Pembayaran
                        <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="belum_dibayar" @if(old('status', $denda->status)=='belum_dibayar') selected @endif>
                            ⏳ Belum Dibayar
                        </option>
                        <option value="sudah_dibayar" @if(old('status', $denda->status)=='sudah_dibayar') selected @endif>
                            ✅ Sudah Dibayar
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Bukti Pembayaran
                    </label>
                    <input 
                        type="file" 
                        name="bukti_pembayaran" 
                        accept="image/*"
                        @change="handleFilePreview"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-lg" />
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, atau JPEG (Maks. 2MB)</p>
                </div>
            </div>

            <!-- Preview Images -->
            <div class="mt-6 grid grid-cols-2 gap-6">
                <!-- Current Image -->
                @if($denda->bukti_pembayaran)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Saat Ini</label>
                    <div class="relative group">
                        <img 
                            src="{{ $denda->bukti_pembayaran_url }}" 
                            alt="Bukti Pembayaran" 
                            class="w-full h-48 object-cover rounded-lg border-2 border-gray-200">
                        <a 
                            href="{{ $denda->bukti_pembayaran_url }}" 
                            target="_blank"
                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all rounded-lg flex items-center justify-center">
                            <span class="text-white opacity-0 group-hover:opacity-100 font-medium flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>Lihat</span>
                            </span>
                        </a>
                    </div>
                </div>
                @endif

                <!-- New Preview -->
                <div x-show="previewImage">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preview Baru</label>
                    <img 
                        :src="previewImage" 
                        alt="Preview" 
                        class="w-full h-48 object-cover rounded-lg border-2 border-blue-300">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <a href="{{ route('admin.dendas.show', $denda->id) }}" 
               class="px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 rounded-lg transition-colors flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>Batal</span>
            </a>
            
            <button 
                type="submit" 
                class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg transition-all flex items-center space-x-2 shadow-lg shadow-green-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-semibold">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection