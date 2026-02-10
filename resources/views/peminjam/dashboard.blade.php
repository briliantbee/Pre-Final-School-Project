@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->username }}!</h2>
        <p class="text-blue-100">Kelola peminjaman alat Anda dengan mudah</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Peminjaman -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Peminjaman</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $total_peminjaman }}</p>
                </div>
            </div>
        </div>

        <!-- Sedang Dipinjam -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Sedang Dipinjam</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $peminjaman_aktif }}</p>
                </div>
            </div>
        </div>

        <!-- Menunggu Konfirmasi -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Menunggu</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $peminjaman_menunggu }}</p>
                </div>
            </div>
        </div>

        <!-- Denda Belum Dibayar -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Denda</p>
                    <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($denda_belum_dibayar, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Mau pinjam alat?</h3>
                <p class="text-sm text-gray-500 mt-1">Lihat katalog alat yang tersedia dan ajukan peminjaman</p>
            </div>
            <a href="{{ route('peminjam.alats.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Lihat Katalog
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Peminjaman Terbaru -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Peminjaman Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($peminjaman_terbaru as $peminjaman)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $peminjaman->alat->nama_alat }}</p>
                            <p class="text-xs text-gray-500">{{ $peminjaman->kode_peminjaman }} • {{ $peminjaman->tanggal_peminjaman->format('d M Y') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded
                            @if($peminjaman->status == 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                            @elseif($peminjaman->status == 'disetujui') bg-blue-100 text-blue-800
                            @elseif($peminjaman->status == 'dipinjam') bg-green-100 text-green-800
                            @elseif($peminjaman->status == 'dikembalikan') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucwords(str_replace('_', ' ', $peminjaman->status)) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada peminjaman</p>
                    @endforelse
                </div>
                @if($peminjaman_terbaru->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('peminjam.peminjamans.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat Semua →
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Pengembalian Terbaru -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Pengembalian Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($pengembalian_terbaru as $pengembalian)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
                            <p class="text-xs text-gray-500">{{ $pengembalian->tanggal_pengembalian->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-semibold rounded
                                @if($pengembalian->kondisi_alat == 'baik') bg-green-100 text-green-800
                                @elseif($pengembalian->kondisi_alat == 'rusak') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($pengembalian->kondisi_alat) }}
                            </span>
                            @if($pengembalian->denda && $pengembalian->denda->status == 'belum_dibayar')
                            <p class="text-xs text-red-600 mt-1">Ada denda</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada pengembalian</p>
                    @endforelse
                </div>
                @if($pengembalian_terbaru->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('peminjam.pengembalians.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat Semua →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Info Alat Tersedia -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm text-blue-700">
                    <strong>{{ $alat_tersedia }}</strong> alat tersedia untuk dipinjam saat ini.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
