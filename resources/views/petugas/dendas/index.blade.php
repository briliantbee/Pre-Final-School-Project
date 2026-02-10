@extends('layouts.sidebar')

@section('title', 'Denda (Petugas)')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Manajemen Denda</h1>
        <div></div>
    </div>

    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Total Denda</div>
            <div class="text-2xl font-bold">Rp {{ number_format($stats['total_denda'] ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Sudah Dibayar</div>
            <div class="text-2xl font-bold">Rp {{ number_format($stats['sudah_dibayar'] ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Belum Dibayar</div>
            <div class="text-2xl font-bold">Rp {{ number_format($stats['belum_dibayar'] ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Jumlah Tagihan</div>
            <div class="text-2xl font-bold">{{ $stats['jumlah_belum_dibayar'] ?? 0 }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kode</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Peminjam</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Alat</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Total</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($dendas as $d)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($dendas->currentPage()-1) * $dendas->perPage() }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $d->pengembalian->peminjaman->kode_peminjaman ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $d->pengembalian->peminjaman->user->username ?? $d->pengembalian->peminjaman->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $d->pengembalian->peminjaman->alat->nama_alat ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($d->status === 'belum_dibayar')
                                <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded">Belum Dibayar</span>
                            @else
                                <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded">Sudah Dibayar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('petugas.dendas.show', $d) }}" class="px-3 py-1 border rounded text-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">Tidak ada data denda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $dendas->withQueryString()->links() }}</div>
</div>
@endsection
