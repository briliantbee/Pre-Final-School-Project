@extends('layouts.sidebar')

@section('title', 'Detail Alat')

@section('navigation')
<a href="{{ route('admin.alats.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
    Kembali ke Kelola Alat
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Detail Alat</h1>
            <p class="text-sm text-gray-600">Informasi lengkap alat laboratorium</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.alats.edit', $alat->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded">Edit</a>
            <form action="{{ route('admin.alats.destroy', $alat) }}" method="POST" onsubmit="return confirm('Hapus alat ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
            </form>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 grid grid-cols-3 gap-6">
        <div class="col-span-1">
            @if($alat->foto)
                <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="w-full h-64 object-cover rounded">
            @else
                <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded text-gray-400">Tidak ada foto</div>
            @endif
        </div>

        <div class="col-span-2">
            <div class="mb-4">
                <h2 class="text-xl font-semibold">{{ $alat->nama_alat }}</h2>
                <div class="text-sm text-gray-500">Kode: {{ $alat->kode_alat }}</div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                <div>
                    <div class="text-gray-500">Stok</div>
                    <div class="font-medium">{{ $alat->stok }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Stok Tersedia</div>
                    <div class="font-medium">{{ $alat->stok_tersedia ?? 0 }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Kategori</div>
                    <div class="font-medium">{{ $alat->kategori ? $alat->kategori->nama_kategori : '-' }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Status</div>
                    <div class="font-medium">@if($alat->status=='tersedia')<span class="text-green-600">Tersedia</span>@else<span class="text-red-600">Tidak Tersedia</span>@endif</div>
                </div>
            </div>

            <div class="mt-6">
                <div class="text-gray-500 text-sm">Deskripsi</div>
                <div class="mt-2 text-gray-800">{{ $alat->deskripsi ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
