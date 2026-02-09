@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Selamat datang di sistem peminjaman alat')

@section('navigation')
<a href="{{ route('admin.dashboard') }}" class="sidebar-link active flex items-center px-4 py-3 mb-1 text-white rounded-lg">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    <span class="font-medium">Dashboard</span>
</a>

<a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center px-4 py-3 mb-1 text-blue-100 hover:text-white hover:bg-blue-700 hover:bg-opacity-50 rounded-lg">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    <span class="font-medium">Kelola User</span>
</a>

<a href="{{ route('admin.kategoris.index') }}" class="sidebar-link flex items-center px-4 py-3 mb-1 text-blue-100 hover:text-white hover:bg-blue-700 hover:bg-opacity-50 rounded-lg">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
    </svg>
    <span class="font-medium">Kategori Alat</span>
</a>

<a href="{{ route('admin.alats.index') }}" class="sidebar-link flex items-center px-4 py-3 mb-1 text-blue-100 hover:text-white hover:bg-blue-700 hover:bg-opacity-50 rounded-lg">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
    <span class="font-medium">Kelola Alat</span>
</a>

<a href="{{ route('admin.peminjamans.index') }}" class="sidebar-link flex items-center px-4 py-3 mb-1 text-blue-100 hover:text-white hover:bg-blue-700 hover:bg-opacity-50 rounded-lg">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    <span class="font-medium">Peminjaman</span>
</a>

<a href="{{ route('admin.pengembalians.index') }}" class="sidebar-link flex items-center px-4 py-3 mb-1 text-blue-100 hover:text-white hover:bg-blue-700 hover:bg-opacity-50 rounded-lg">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
    </svg>
    <span class="font-medium">Pengembalian</span>
</a>

<a href="{{ route('admin.dendas.index') }}" class="sidebar-link flex items-center px-4 py-3 mb-1 text-blue-100 hover:text-white hover:bg-blue-700 hover:bg-opacity-50 rounded-lg">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="font-medium">Denda</span>
</a>

<div class="px-4 py-2">
    <div class="h-px bg-blue-500 bg-opacity-30"></div>
</div>

<a href="{{ route('admin.aktivitas.index') }}" class="sidebar-link flex items-center px-4 py-3 mb-1 text-blue-100 hover:text-white hover:bg-blue-700 hover:bg-opacity-50 rounded-lg">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <span class="font-medium">Activity Log</span>
</a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->username }}! 👋</h3>
                <p class="mt-2 text-blue-100">Berikut adalah ringkasan sistem peminjaman alat hari ini</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 text-blue-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $total_users }}</p>
                    <div class="flex items-center mt-2 text-sm text-green-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>Aktif</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Alat -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Alat</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $total_alat }}</p>
                    <p class="text-sm text-green-600 mt-2">{{ $total_alat_tersedia }} tersedia</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Peminjaman Aktif</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $total_peminjaman_aktif }}</p>
                    <p class="text-sm text-yellow-600 mt-2">{{ $peminjaman_menunggu }} menunggu</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Denda -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Denda Belum Dibayar</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($total_denda_belum_dibayar, 0, ',', '.') }}</p>
                    <p class="text-sm text-red-600 mt-2">Perlu ditindaklanjuti</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Peminjaman Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Status Peminjaman</h3>
                <span class="text-sm text-gray-500">Bulan ini</span>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>

        <!-- Alat Populer -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Alat Paling Populer</h3>
                <a href="{{ route('admin.alats.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-4">
                @foreach($top_alat ?? [] as $index => $alat)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                            <span class="text-blue-600 font-bold">#{{ $index + 1 }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $alat->nama_alat }}</p>
                            <p class="text-xs text-gray-500">{{ $alat->kategori->nama_kategori }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ $alat->peminjaman_count }}</p>
                        <p class="text-xs text-gray-500">peminjaman</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Activity Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Peminjaman Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Peminjaman Terbaru</h3>
                    <a href="{{ route('admin.peminjamans.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @forelse($peminjaman_terbaru as $peminjaman)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors border border-gray-100">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ strtoupper(substr($peminjaman->user->username, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $peminjaman->user->username }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $peminjaman->alat->nama_alat }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full flex-shrink-0
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
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Belum ada peminjaman</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pengembalian Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Pengembalian Terbaru</h3>
                    <a href="{{ route('admin.pengembalians.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @forelse($pengembalian_terbaru as $pengembalian)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors border border-gray-100">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ strtoupper(substr($pengembalian->peminjaman->user->username, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $pengembalian->peminjaman->user->username }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($pengembalian->kondisi_alat == 'baik') bg-green-100 text-green-800
                                @elseif($pengembalian->kondisi_alat == 'rusak') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($pengembalian->kondisi_alat) }}
                            </span>
                            @if($pengembalian->terlambat)
                            <p class="text-xs text-red-600 mt-1 font-medium">Terlambat {{ $pengembalian->hari_terlambat }} hari</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Belum ada pengembalian</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function(){
        const ctx = document.getElementById('peminjamanChart');
        if (!ctx) return;

        const data = {
            labels: [
                'Menunggu',
                'Disetujui',
                'Dipinjam',
                'Dikembalikan',
                'Ditolak'
            ],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $status_counts['menunggu_konfirmasi'] ?? 0 }},
                    {{ $status_counts['disetujui'] ?? 0 }},
                    {{ $status_counts['dipinjam'] ?? 0 }},
                    {{ $status_counts['dikembalikan'] ?? 0 }},
                    {{ $status_counts['ditolak'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(156, 163, 175, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgb(251, 191, 36)',
                    'rgb(59, 130, 246)',
                    'rgb(34, 197, 94)',
                    'rgb(156, 163, 175)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 2
            }]
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed + ' peminjaman';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    })();
</script>
@endpush