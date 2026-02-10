@extends('layouts.sidebar')

@section('title', 'Detail Alat')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $alat->nama_alat }}</h1>
            <p class="text-sm text-gray-500">{{ $alat->kode_alat ?? '' }}</p>
        </div>
        <div>
            <a href="{{ route('petugas.alats.index') }}" class="px-3 py-2 border rounded">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded shadow p-6 grid grid-cols-2 gap-6">
        <div>
            <div class="text-sm text-gray-500">Kategori</div>
            <div class="font-medium">{{ $alat->kategori->nama_kategori ?? '-' }}</div>

            <div class="mt-3 text-sm text-gray-500">Stok Tersedia</div>
            <div class="font-medium">{{ $alat->stok_tersedia }}</div>

            <div class="mt-3 text-sm text-gray-500">Status</div>
            <div class="font-medium">{{ ucfirst($alat->status) }}</div>

            @if($alat->deskripsi)
                <div class="mt-4 text-sm text-gray-500">Deskripsi</div>
                <div class="mt-1 text-gray-700">{{ $alat->deskripsi }}</div>
            @endif
        </div>

        <div>
            <div class="text-sm text-gray-500">Riwayat Peminjaman (Terbaru)</div>
            <div class="mt-2 space-y-3">
                @forelse($alat->peminjamans as $p)
                    <div class="p-3 border rounded">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-600">{{ $p->kode_peminjaman }}</div>
                                <div class="font-medium">{{ $p->user->username ?? $p->user->name }}</div>
                            </div>
                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d M Y') }}</div>
                        </div>
                        <div class="mt-1 text-sm text-gray-600">Status: <span class="font-medium">{{ ucfirst($p->status) }}</span></div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500">Belum ada peminjaman.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
