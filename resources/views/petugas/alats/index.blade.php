@extends('layouts.sidebar')

@section('title', 'Katalog Alat (Petugas)')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Katalog Alat</h1>
            <p class="text-sm text-gray-500">Daftar alat yang tersedia dan status stok.</p>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama alat" class="px-3 py-2 border rounded" />
            <select name="kategori_id" class="px-3 py-2 border rounded">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            <select name="status" class="px-3 py-2 border rounded">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option>
                <option value="tidak_tersedia" {{ request('status')=='tidak_tersedia'?'selected':'' }}>Tidak Tersedia</option>
            </select>
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kode</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Nama Alat</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Stok</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Peminjaman Aktif</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($alats as $alat)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($alats->currentPage()-1) * $alats->perPage() }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $alat->kode_alat ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $alat->nama_alat }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $alat->stok_tersedia }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $alat->peminjamans_count ?? 0 }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($alat->status === 'tersedia')
                                <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded">Tersedia</span>
                            @else
                                <span class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded">Tidak Tersedia</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('petugas.alats.show', $alat) }}" class="px-3 py-1 border rounded text-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">Tidak ada alat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $alats->withQueryString()->links() }}</div>
</div>
@endsection
