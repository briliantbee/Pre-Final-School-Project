@extends('layouts.sidebar')

@section('title', 'Pengembalian (Petugas)')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Manajemen Pengembalian</h1>
        <div>
            <a href="{{ route('petugas.pengembalians.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Proses Pengembalian</a>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Total Pengembalian</div>
            <div class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Terlambat</div>
            <div class="text-2xl font-bold">{{ $stats['terlambat'] ?? 0 }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Rusak</div>
            <div class="text-2xl font-bold">{{ $stats['rusak'] ?? 0 }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Hilang</div>
            <div class="text-2xl font-bold">{{ $stats['hilang'] ?? 0 }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kode</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">User</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Alat</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Jumlah</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kondisi</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Terlambat</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($pengembalians as $p)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($pengembalians->currentPage()-1) * $pengembalians->perPage() }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $p->peminjaman->kode_peminjaman ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->peminjaman->user->username ?? $p->peminjaman->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->peminjaman->alat->nama_alat ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->jumlah_dikembalikan }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($p->kondisi_alat) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->terlambat ? 'Ya' : 'Tidak' }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('petugas.pengembalians.show', $p) }}" class="px-3 py-1 border rounded text-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-gray-500">Tidak ada pengembalian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $pengembalians->withQueryString()->links() }}</div>
</div>
@endsection
