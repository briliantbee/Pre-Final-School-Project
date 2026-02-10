@extends('layouts.sidebar')

@section('title', 'Daftar Denda')
@section('subtitle', 'Kelola denda dan unggah bukti pembayaran')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Gradient Header with Stats -->
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/10"></div>
            <div class="relative px-8 py-10">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-white flex items-center gap-3">
                        <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Daftar Denda
                    </h2>
                    <p class="text-blue-100 mt-2 ml-14">Kelola denda dan unggah bukti pembayaran</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-5 border border-white/20 hover:bg-white/20 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Denda</p>
                                <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($stats['total_denda'] ?? 0,0,',','.') }}</p>
                            </div>
                            <div class="p-3 bg-yellow-500/30 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-5 border border-white/20 hover:bg-white/20 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Sudah Dibayar</p>
                                <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($stats['sudah_dibayar'] ?? 0,0,',','.') }}</p>
                            </div>
                            <div class="p-3 bg-green-500/30 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-5 border border-white/20 hover:bg-white/20 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Belum Dibayar</p>
                                <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($stats['belum_dibayar'] ?? 0,0,',','.') }}</p>
                            </div>
                            <div class="p-3 bg-red-500/30 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Filters -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <form method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white">
                            <option value="">💰 Semua Status</option>
                            <option value="sudah_dibayar" {{ request('status')=='sudah_dibayar' ? 'selected' : '' }}>✅ Sudah Dibayar</option>
                            <option value="belum_dibayar" {{ request('status')=='belum_dibayar' ? 'selected' : '' }}>⏳ Belum Dibayar</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="search" name="q" value="{{ request('q') }}" 
                               placeholder="Cari nama alat atau deskripsi..." 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" />
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('peminjam.dendas.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Enhanced Table -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden" x-data="{ uploadModal: null }">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">#</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Alat</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Denda</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Bukti</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($dendas as $denda)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    {{ $loop->iteration + ($dendas->currentPage()-1) * $dendas->perPage() }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $denda->pengembalian->peminjaman->alat->nama_alat ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $denda->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 font-medium">
                                    {{ $denda->pengembalian->peminjaman->jumlah ?? 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <span class="font-bold text-red-600">Rp {{ number_format($denda->total_denda ?? 0,0,',','.') }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($denda->status === 'sudah_dibayar')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Sudah Dibayar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    @if($denda->bukti_pembayaran)
                                        <a href="{{ asset('storage/'.$denda->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                    {{ optional($denda->created_at)->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('peminjam.dendas.show', $denda) }}" 
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors font-medium text-xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail
                                        </a>
                                        @if($denda->status !== 'sudah_dibayar')
                                            <button @click="uploadModal = {{ $denda->id }}" 
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:from-yellow-600 hover:to-orange-600 transition-all duration-200 font-semibold text-xs shadow-md hover:shadow-lg">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                </svg>
                                                Upload Bukti
                                            </button>

                                            <!-- Upload Modal -->
                                            <div x-show="uploadModal === {{ $denda->id }}" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <div x-show="uploadModal === {{ $denda->id }}" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="uploadModal = null" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                                    <div x-show="uploadModal === {{ $denda->id }}" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95" class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
                                                        <form action="{{ route('peminjam.dendas.uploadBukti', $denda) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <!-- Modal Header -->
                                                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center gap-3">
                                                                        <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                                            </svg>
                                                                        </div>
                                                                        <h3 class="text-xl font-bold text-white">Upload Bukti Pembayaran</h3>
                                                                    </div>
                                                                    <button type="button" @click="uploadModal = null" class="text-white/80 hover:text-white transition-colors">
                                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <!-- Modal Body -->
                                                            <div class="bg-white px-6 py-6 space-y-4">
                                                                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-4 rounded-lg border border-yellow-200">
                                                                    <p class="text-sm text-gray-700 font-medium">Total Denda: <span class="text-red-700 font-bold">Rp {{ number_format($denda->total_denda ?? 0,0,',','.') }}</span></p>
                                                                </div>

                                                                <div>
                                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                                        Upload Bukti Transfer <span class="text-red-500">*</span>
                                                                    </label>
                                                                    <input type="file" name="bukti_pembayaran" accept="image/*" required 
                                                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm"/>
                                                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max 2MB)</p>
                                                                </div>
                                                            </div>

                                                            <!-- Modal Footer -->
                                                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 flex justify-end gap-3">
                                                                <button type="button" @click="uploadModal = null" 
                                                                        class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 font-medium shadow-sm">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" 
                                                                        class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 font-semibold shadow-md hover:shadow-lg flex items-center gap-2">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                                    </svg>
                                                                    Kirim Bukti
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-16 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-3">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada data denda</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <style>
            [x-cloak] { display: none !important; }
        </style>

        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">Menampilkan {{ $dendas->firstItem() ?? 0 }} - {{ $dendas->lastItem() ?? 0 }} dari {{ $dendas->total() ?? 0 }} hasil</div>
            <div>
                {{ $dendas->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
