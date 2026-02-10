@extends('layouts.sidebar')

@section('title', 'Detail Alat')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">{{ $alat->nama_alat }}</h1>
            <p class="text-sm text-gray-600">{{ $alat->kode_alat ?? '' }} · {{ $alat->kategori->nama_kategori ?? '' }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('peminjam.alats.index') }}" class="px-4 py-2 bg-gray-100 rounded">Kembali</a>
            @if($hasActiveBorrowing)
                <span class="px-4 py-2 text-sm text-yellow-700 bg-yellow-100 rounded">Anda memiliki peminjaman aktif</span>
            @elseif($alat->stok_tersedia > 0)
                <button type="button" onclick="window.dispatchEvent(new Event('open-pinjam'))" class="px-4 py-2 bg-green-600 text-white rounded">Pinjam Alat</button>
            @else
                <span class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded">Stok Kosong</span>
            @endif
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="text-sm text-gray-500">Nama</div>
                <div class="font-medium text-lg">{{ $alat->nama_alat }}</div>

                <div class="mt-4 text-sm text-gray-500">Kode Alat</div>
                <div class="font-medium">{{ $alat->kode_alat ?? '-' }}</div>

                <div class="mt-4 text-sm text-gray-500">Kategori</div>
                <div class="font-medium">{{ $alat->kategori->nama_kategori ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Stok Tersedia</div>
                <div class="font-medium">{{ $alat->stok_tersedia ?? 0 }}</div>

                <div class="mt-4 text-sm text-gray-500">Status</div>
                <div class="font-medium capitalize">{{ $alat->status ?? '-' }}</div>

                <div class="mt-4 text-sm text-gray-500">Lokasi / Keterangan</div>
                <div class="font-medium">{{ $alat->deskripsi ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Pinjam Modal -->
<div x-data="{ open: false }" x-init="if(window.location.hash === '#pinjam') open = true" x-on:open-pinjam.window="open = true">
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold">Form Peminjaman</h3>
            <p class="text-sm text-gray-500">Ajukan peminjaman untuk alat ini.</p>

            <form action="{{ route('peminjam.peminjamans.store') }}" method="POST" class="mt-4 space-y-3">
                @csrf
                <input type="hidden" name="alat_id" value="{{ $alat->id }}">

                <div>
                    <label class="text-sm text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" min="1" max="{{ $alat->stok_tersedia }}" value="1" class="mt-1 block w-full px-3 py-2 border rounded" required />
                </div>

                <div>
                    <label class="text-sm text-gray-700">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_peminjaman" class="mt-1 block w-full px-3 py-2 border rounded" min="{{ \Carbon\Carbon::today()->toDateString() }}" required />
                </div>

                <div>
                    <label class="text-sm text-gray-700">Tanggal Kembali</label>
                    <input type="date" name="tanggal_berakhir_peminjaman" class="mt-1 block w-full px-3 py-2 border rounded" min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}" required />
                </div>

                <div>
                    <label class="text-sm text-gray-700">Keperluan</label>
                    <textarea name="keperluan" rows="3" class="mt-1 block w-full px-3 py-2 border rounded" required></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open=false" class="px-3 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded">Ajukan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@endsection
