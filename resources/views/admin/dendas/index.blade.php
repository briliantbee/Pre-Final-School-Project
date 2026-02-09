@extends('layouts.sidebar')

@section('title', 'Denda')

@section('navigation')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
</a>

<a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    Kelola User
</a>

<a href="{{ route('admin.kategoris.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
    </svg>
    Kategori Alat
</a>

<a href="{{ route('admin.alats.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
    Kelola Alat
</a>

<a href="{{ route('admin.peminjamans.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Peminjaman
</a>

<a href="{{ route('admin.pengembalians.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
    </svg>
    Pengembalian
</a>

<a href="{{ route('admin.dendas.index') }}"class="flex items-center px-6 py-3 text-white bg-blue-700 border-l-4 border-blue-400">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Denda
</a>

<a href="{{ route('admin.aktivitas.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Activity Log
</a>
@endsection

@section('content')
<div>
    <div class="mb-6 flex items-start justify-between gap-6">
        <div>
            <h2 class="text-2xl font-semibold">Manajemen Denda</h2>
            <p class="text-sm text-gray-600">Kelola denda keterlambatan dan bukti pembayaran.</p>
        </div>

        <div class="flex items-center gap-4">
            <form action="{{ route('admin.dendas.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode peminjaman atau pengguna" class="px-3 py-2 border rounded-lg" />
                <select name="status" class="px-3 py-2 border rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="sudah_dibayar" @if(request('status')=='sudah_dibayar') selected @endif>Sudah Dibayar</option>
                    <option value="belum_dibayar" @if(request('status')=='belum_dibayar') selected @endif>Belum Dibayar</option>
                </select>
                <button type="submit" class="px-3 py-2 bg-gray-100 rounded">Filter</button>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Total Nilai Denda</div>
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
            <div class="text-sm text-gray-500">Jumlah Belum Dibayar</div>
            <div class="text-2xl font-bold">{{ $stats['jumlah_belum_dibayar'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($dendas as $d)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration + ($dendas->currentPage()-1) * $dendas->perPage() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $d->pengembalian->peminjaman->kode_peminjaman ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $d->pengembalian->peminjaman->user->name ?? $d->pengembalian->peminjaman->user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $d->pengembalian->peminjaman->alat->nama_alat ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">Rp {{ number_format($d->total_denda ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($d->status === 'sudah_dibayar')
                                <span class="px-2 py-1 rounded text-sm bg-green-100 text-green-800">Sudah Dibayar</span>
                            @else
                                <span class="px-2 py-1 rounded text-sm bg-red-100 text-red-800">Belum Dibayar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.dendas.show', $d->id) }}" class="px-3 py-1 border rounded text-sm">Detail</a>
                                <a href="{{ route('admin.dendas.edit', $d->id) }}" class="px-3 py-1 border rounded text-sm">Edit</a>

                                @if($d->status === 'belum_dibayar')
                                    <div x-data="{open:false}">
                                        <button @click="open = !open" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Konfirmasi Pembayaran</button>

                                        <div x-show="open" x-cloak class="mt-2 p-3 bg-gray-50 rounded border">
                                            <form action="{{ route('admin.dendas.confirm-payment', $d->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <label class="block text-sm text-gray-600">Unggah Bukti (jpg/png)</label>
                                                <input type="file" name="bukti_pembayaran" accept="image/*" required class="mt-1 block w-full text-sm" />
                                                <div class="mt-2 flex justify-end gap-2">
                                                    <button type="button" @click="open=false" class="px-3 py-1 border rounded">Batal</button>
                                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Kirim</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    @if($d->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . $d->bukti_pembayaran) }}" target="_blank" class="px-3 py-1 border rounded text-sm">Lihat Bukti</a>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $dendas->links() }}</div>
</div>

@endsection
