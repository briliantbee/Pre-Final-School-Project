@extends('layouts.sidebar')

@section('title', 'Daftar Denda')
@section('subtitle', 'Kelola denda dan unggah bukti pembayaran')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500">Total Denda</p>
                <p class="text-2xl font-semibold text-gray-800">Rp {{ number_format($stats['total_denda'] ?? 0,0,',','.') }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500">Sudah Dibayar</p>
                <p class="text-2xl font-semibold text-green-600">Rp {{ number_format($stats['sudah_dibayar'] ?? 0,0,',','.') }}</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500">Belum Dibayar</p>
                <p class="text-2xl font-semibold text-red-600">Rp {{ number_format($stats['belum_dibayar'] ?? 0,0,',','.') }}</p>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-end gap-3">
            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-600">Status:</label>
                <select name="status" class="form-select rounded-md border-gray-200">
                    <option value="">Semua</option>
                    <option value="sudah_dibayar" {{ request('status')=='sudah_dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                    <option value="belum_dibayar" {{ request('status')=='belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-600">Cari:</label>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Nama alat atau deskripsi" class="rounded-md border-gray-200 px-3 py-2" />
            </div>

            <div class="ml-auto">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Filter</button>
                <a href="{{ route('peminjam.dendas.index') }}" class="ml-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-md">Reset</a>
            </div>
        </form>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Alat</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Jumlah</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Total Denda</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Bukti</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($dendas as $denda)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($dendas->currentPage()-1) * $dendas->perPage() }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $denda->pengembalian->peminjaman->alat->nama_alat ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $denda->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $denda->pengembalian->peminjaman->jumlah ?? 1 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($denda->total_denda ?? 0,0,',','.') }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($denda->status === 'sudah_dibayar')
                                    <span class="px-2 py-1 rounded-md bg-green-100 text-green-700 text-xs">Sudah Dibayar</span>
                                @else
                                    <span class="px-2 py-1 rounded-md bg-red-100 text-red-700 text-xs">Belum Dibayar</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($denda->bukti_pembayaran)
                                    <a href="{{ asset('storage/'.$denda->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ optional($denda->created_at)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('peminjam.dendas.show', $denda) }}" class="text-blue-600 hover:underline">Detail</a>
                                    @if($denda->status !== 'sudah_dibayar')
                                        <button @click.prevent="document.getElementById('upload-{{ $denda->id }}').classList.remove('hidden')" class="px-3 py-1 bg-yellow-500 text-white rounded-md text-sm">Unggah Bukti</button>

                                        <form id="upload-{{ $denda->id }}" action="{{ route('peminjam.dendas.uploadBukti', $denda) }}" method="POST" enctype="multipart/form-data" class="hidden mt-2">
                                            @csrf
                                            <input type="file" name="bukti_pembayaran" accept="image/*" required class="mb-2" />
                                            <div>
                                                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded-md text-sm">Kirim</button>
                                                <button type="button" onclick="document.getElementById('upload-{{ $denda->id }}').classList.add('hidden')" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md text-sm">Batal</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-gray-500">Tidak ada data denda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">Menampilkan {{ $dendas->firstItem() ?? 0 }} - {{ $dendas->lastItem() ?? 0 }} dari {{ $dendas->total() ?? 0 }} hasil</div>
            <div>
                {{ $dendas->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
