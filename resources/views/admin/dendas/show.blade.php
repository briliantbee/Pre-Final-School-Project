@extends('layouts.sidebar')

@section('title', 'Detail Denda')

@section('navigation')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
</a>

<a href="{{ route('admin.dendas.index') }}" class="flex items-center px-6 py-3 text-white bg-blue-700 border-l-4 border-blue-400">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Denda
</a>

@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Detail Denda</h1>
            <p class="text-sm text-gray-600">Informasi lengkap dan opsi ubah status atau unggah bukti.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dendas.index') }}" class="px-4 py-2 bg-gray-100 rounded">Kembali</a>
            <a href="{{ route('admin.dendas.edit', $denda->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded">Edit Denda</a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="text-sm text-gray-500">Kode Peminjaman</div>
                <div class="font-medium text-lg">{{ $denda->pengembalian->peminjaman->kode_peminjaman ?? '-' }}</div>

                <div class="mt-4 text-sm text-gray-500">Peminjam</div>
                <div class="font-medium">{{ $denda->pengembalian->peminjaman->user->name ?? '-' }}</div>

                <div class="mt-4 text-sm text-gray-500">Alat</div>
                <div class="font-medium">{{ $denda->pengembalian->peminjaman->alat->nama_alat ?? '-' }}</div>

                <div class="mt-4 text-sm text-gray-500">Tanggal Pengembalian</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($denda->pengembalian->tanggal_pengembalian)->format('d M Y') }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Denda Keterlambatan</div>
                <div class="font-medium">Rp {{ number_format($denda->denda_keterlambatan ?? 0, 0, ',', '.') }}</div>

                <div class="mt-4 text-sm text-gray-500">Denda Kerusakan</div>
                <div class="font-medium">Rp {{ number_format($denda->denda_kerusakan ?? 0, 0, ',', '.') }}</div>

                <div class="mt-4 text-sm text-gray-500">Total Denda</div>
                <div class="font-medium text-xl">{{ $denda->total_denda_format }}</div>

                <div class="mt-4 text-sm text-gray-500">Status</div>
                <div class="font-medium">
                    @if($denda->status === 'sudah_dibayar')
                        <span class="px-2 py-1 rounded text-sm bg-green-100 text-green-800">Sudah Dibayar</span>
                    @else
                        <span class="px-2 py-1 rounded text-sm bg-red-100 text-red-800">Belum Dibayar</span>
                    @endif
                </div>
            </div>
        </div>

        @if($denda->bukti_pembayaran)
            <div class="mt-6">
                <div class="text-sm text-gray-500">Bukti Pembayaran</div>
                <div class="mt-2">
                    <a href="{{ $denda->bukti_pembayaran_url }}" target="_blank" class="text-blue-600 underline">Lihat Bukti</a>
                </div>
            </div>
        @endif

        @if($denda->tanggal_pembayaran)
            <div class="mt-4 text-sm text-gray-500">Tanggal Pembayaran</div>
            <div class="font-medium">{{ \Carbon\Carbon::parse($denda->tanggal_pembayaran)->format('d M Y H:i') }}</div>
        @endif

        @if($denda->pengkonfirmasi)
            <div class="mt-4 text-sm text-gray-500">Dikonfirmasi Oleh</div>
            <div class="font-medium">{{ $denda->pengkonfirmasi->name ?? '-' }}</div>
        @endif
    </div>
</div>

@endsection
