@extends('layouts.sidebar')

@section('title', 'Daftar Alat')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Alat Tersedia</h2>
            <p class="text-sm text-gray-600">Telusuri alat yang tersedia untuk dipinjam.</p>
        </div>

        <form action="{{ route('peminjam.alats.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode alat" class="px-3 py-2 border rounded" />
            <select name="kategori_id" class="px-3 py-2 border rounded">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" @if(request('kategori_id') == $k->id) selected @endif>{{ $k->nama_kategori }} ({{ $k->alats_count }})</option>
                @endforeach
            </select>
            <button class="px-3 py-2 bg-gray-100 rounded">Filter</button>
        </form>
    </div>

    <div class="grid grid-cols-4 gap-4">
        @foreach($alats as $alat)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                <div class="h-40 bg-gray-100 flex items-center justify-center overflow-hidden">
                    @if($alat->foto)
                        <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="object-cover w-full h-full" />
                    @else
                        <div class="text-gray-400">No image</div>
                    @endif
                </div>

                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-sm text-gray-500">{{ $alat->kode_alat ?? '-' }}</div>
                        <h3 class="text-lg font-semibold mt-1">{{ $alat->nama_alat }}</h3>
                        <div class="mt-2 text-sm text-gray-600">{{ Str::limit($alat->deskripsi ?? '-', 120) }}</div>

                        <div class="mt-3 text-sm text-gray-500">Kategori: {{ $alat->kategori->nama_kategori ?? '-' }}</div>
                        <div class="text-sm text-gray-500">Stok: {{ $alat->stok_tersedia ?? 0 }}</div>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <a href="{{ route('peminjam.alats.show', $alat->id) }}" class="px-3 py-1 border rounded text-sm">Detail</a>
                        @if($alat->stok_tersedia > 0)
                            <a href="{{ route('peminjam.alats.show', $alat->id) }}#pinjam" class="px-3 py-1 bg-green-600 text-white rounded text-sm">Pinjam</a>
                        @else
                            <span class="px-3 py-1 text-sm text-gray-500">Kosong</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $alats->links() }}</div>
</div>

@endsection
