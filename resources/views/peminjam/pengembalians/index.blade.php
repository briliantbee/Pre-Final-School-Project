@extends('layouts.sidebar')

@section('title', 'Daftar Pengembalian')
@section('subtitle', 'Riwayat pengembalian alat oleh Anda')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500">Total Pengembalian</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500">Terlambat</p>
                <p class="text-2xl font-semibold text-red-600">{{ $stats['terlambat'] ?? 0 }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500">Belum Denda</p>
                <p class="text-2xl font-semibold text-green-600">{{ $pengembalians->where('denda', null)->count() }}</p>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-end gap-3">
            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-600">Kondisi:</label>
                <select name="kondisi" class="form-select rounded-md border-gray-200">
                    <option value="">Semua</option>
                    <option value="baik" {{ request('kondisi')=='baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak" {{ request('kondisi')=='rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-600">Terlambat:</label>
                <select name="terlambat" class="form-select rounded-md border-gray-200">
                    <option value="">Semua</option>
                    <option value="ya" {{ request('terlambat')=='ya' ? 'selected' : '' }}>Ya</option>
                    <option value="tidak" {{ request('terlambat')=='tidak' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-600">Cari Alat:</label>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Nama alat atau kode" class="rounded-md border-gray-200 px-3 py-2" />
            </div>

            <div class="ml-auto">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Filter</button>
                <a href="{{ route('peminjam.pengembalians.index') }}" class="ml-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-md">Reset</a>
            </div>
        </form>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Alat</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kategori</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Jumlah</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kondisi</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Diterima Oleh</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Denda</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Terlambat</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($pengembalians as $pengembalian)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($pengembalians->currentPage()-1) * $pengembalians->perPage() }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $pengembalian->peminjaman->alat->nama_alat ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $pengembalian->peminjaman->alat->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $pengembalian->peminjaman->jumlah ?? 1 }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if(Str::lower($pengembalian->kondisi_alat ?? '') === 'baik')
                                    <span class="px-2 py-1 rounded-md bg-green-100 text-green-700 text-xs">Baik</span>
                                @elseif(Str::lower($pengembalian->kondisi_alat ?? '') === 'rusak')
                                    <span class="px-2 py-1 rounded-md bg-red-100 text-red-700 text-xs">Rusak</span>
                                @else
                                    <span class="px-2 py-1 rounded-md bg-gray-100 text-gray-700 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $pengembalian->diterimaDosen->nama ?? 'Petugas' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($pengembalian->denda)
                                    Rp {{ number_format($pengembalian->denda->jumlah,0,',','.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($pengembalian->terlambat)
                                    <span class="px-2 py-1 rounded-md bg-red-100 text-red-700 text-xs">Terlambat</span>
                                @else
                                    <span class="px-2 py-1 rounded-md bg-green-100 text-green-700 text-xs">Tepat Waktu</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ optional($pengembalian->created_at)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('peminjam.pengembalians.show', $pengembalian) }}" class="text-blue-600 hover:underline">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-6 text-center text-gray-500">Tidak ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">Menampilkan {{ $pengembalians->firstItem() ?? 0 }} - {{ $pengembalians->lastItem() ?? 0 }} dari {{ $pengembalians->total() ?? 0 }} hasil</div>
            <div>
                {{ $pengembalians->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
