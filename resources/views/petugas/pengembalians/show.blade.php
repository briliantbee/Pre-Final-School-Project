@extends('layouts.sidebar')

@section('title', 'Detail Pengembalian')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Detail Pengembalian</h1>
        <div>
            <a href="{{ route('petugas.pengembalians.index') }}" class="px-3 py-2 border rounded">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded shadow p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-sm text-gray-500">Kode Peminjaman</div>
                <div class="font-medium">{{ $pengembalian->peminjaman->kode_peminjaman ?? '-' }}</div>

                <div class="mt-3 text-sm text-gray-500">Peminjam</div>
                <div class="font-medium">{{ $pengembalian->peminjaman->user->username ?? $pengembalian->peminjaman->user->name }}</div>

                <div class="mt-3 text-sm text-gray-500">Alat</div>
                <div class="font-medium">{{ $pengembalian->peminjaman->alat->nama_alat ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Tanggal Pengembalian</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}</div>

                <div class="mt-3 text-sm text-gray-500">Jumlah Dikembalikan</div>
                <div class="font-medium">{{ $pengembalian->jumlah_dikembalikan }}</div>

                <div class="mt-3 text-sm text-gray-500">Kondisi Alat</div>
                <div class="font-medium">{{ ucfirst($pengembalian->kondisi_alat) }}</div>
            </div>
        </div>

        <div class="mt-4">
            <div class="text-sm text-gray-500">Terlambat</div>
            <div class="font-medium">{{ $pengembalian->terlambat ? 'Ya — ' . ($pengembalian->hari_terlambat ?? 0) . ' hari' : 'Tidak' }}</div>
        </div>

        @if($pengembalian->catatan)
            <div class="mt-4">
                <div class="text-sm text-gray-500">Catatan</div>
                <div class="font-medium">{{ $pengembalian->catatan }}</div>
            </div>
        @endif

        @if($pengembalian->denda)
            <div class="mt-4 p-4 bg-yellow-50 rounded border">
                <div class="text-sm text-gray-500">Denda</div>
                <div class="font-medium">Rp {{ number_format($pengembalian->denda->total_denda, 0, ',', '.') }} — {{ ucfirst($pengembalian->denda->status) }}</div>
            </div>
        @endif
    </div>
</div>
@endsection
