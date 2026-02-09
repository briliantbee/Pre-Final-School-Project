@extends('layouts.sidebar')

@section('title', 'Dashboard Petugas')

@section('navigation')
<a href="{{ route('petugas.dashboard') }}" class="flex items-center px-6 py-3 text-white bg-blue-700 border-l-4 border-blue-400">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
</a>

<a href="{{ route('petugas.peminjamans.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Peminjaman
</a>

<a href="{{ route('petugas.pengembalians.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
    </svg>
    Pengembalian
</a>

<a href="{{ route('petugas.dendas.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Denda
</a>

<a href="{{ route('petugas.alats.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
    Katalog Alat
</a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Menunggu Konfirmasi -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $peminjaman_menunggu }}</p>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Peminjaman Aktif</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $peminjaman_aktif }}</p>
                </div>
            </div>
        </div>

        <!-- Pengembalian Hari Ini -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pengembalian Hari Ini</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pengembalian_hari_ini }}</p>
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
                    <p class="text-sm font-medium text-gray-500">Total Denda</p>
                    <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($total_denda_belum_dibayar, 0, ',', '.') }}</p>
                    <p class="text-xs text-red-600">{{ $denda_belum_dibayar }} belum dibayar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Peminjaman Menunggu -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Peminjaman Menunggu Konfirmasi</h3>
                <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">
                    {{ $peminjaman_menunggu_list->count() }}
                </span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($peminjaman_menunggu_list as $peminjaman)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $peminjaman->user->username }}</p>
                            <p class="text-xs text-gray-500">{{ $peminjaman->alat->nama_alat }} ({{ $peminjaman->jumlah }} unit)</p>
                            <p class="text-xs text-gray-400">{{ $peminjaman->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('petugas.peminjamans.show', $peminjaman) }}" class="text-sm text-blue-600 hover:text-blue-800">
                            Review →
                        </a>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada peminjaman menunggu</p>
                    @endforelse
                </div>
                @if($peminjaman_menunggu_list->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('petugas.peminjamans.index') }}?status=menunggu_konfirmasi" class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat Semua →
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Peminjaman Aktif</h3>
                <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded">
                    {{ $peminjaman_aktif_list->count() }}
                </span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($peminjaman_aktif_list as $peminjaman)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $peminjaman->user->username }}</p>
                            <p class="text-xs text-gray-500">{{ $peminjaman->alat->nama_alat }} ({{ $peminjaman->jumlah }} unit)</p>
                            <p class="text-xs text-gray-400">Berakhir: {{ \Carbon\Carbon::parse($peminjaman->tanggal_berakhir_peminjaman)->format('d M Y') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded
                            @if($peminjaman->status == 'disetujui') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ ucwords(str_replace('_', ' ', $peminjaman->status)) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada peminjaman aktif</p>
                    @endforelse
                </div>
                @if($peminjaman_aktif_list->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('petugas.peminjamans.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat Semua →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Latest Pengembalian -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Pengembalian Terbaru</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($pengembalian_terbaru as $pengembalian)
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $pengembalian->peminjaman->user->username }}</p>
                        <p class="text-xs text-gray-500">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
                        <p class="text-xs text-gray-400">{{ $pengembalian->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 text-xs font-semibold rounded
                            @if($pengembalian->kondisi_alat == 'baik') bg-green-100 text-green-800
                            @elseif($pengembalian->kondisi_alat == 'rusak') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($pengembalian->kondisi_alat) }}
                        </span>
                        @if($pengembalian->terlambat)
                        <p class="text-xs text-red-600 mt-1">Terlambat {{ $pengembalian->hari_terlambat }} hari</p>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada pengembalian</p>
                @endforelse
            </div>
            @if($pengembalian_terbaru->count() > 0)
            <div class="mt-4 text-center">
                <a href="{{ route('petugas.pengembalians.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Lihat Semua →
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
