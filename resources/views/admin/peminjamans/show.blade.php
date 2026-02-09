@extends('layouts.sidebar')

@section('title', 'Detail Peminjaman')

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

<a href="{{ route('admin.peminjamans.index') }}" class="flex items-center px-6 py-3 text-white bg-blue-700 border-l-4 border-blue-400">
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

<a href="{{ route('admin.dendas.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
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
<div class="max-w-3xl mx-auto" x-data="{showReject:false, rejectNote:''}">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Detail Peminjaman</h1>
            <p class="text-sm text-gray-600">Informasi lengkap permintaan peminjaman</p>
        </div>
        <div class="flex items-center gap-2">
            @if($peminjaman->status == 'menunggu_konfirmasi')
                <form id="approveForm" action="{{ route('admin.peminjamans.approve', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Approve</button>
                </form>

                <button @click="showReject = true" class="px-4 py-2 bg-red-600 text-white rounded">Reject</button>
            @endif
            <a href="{{ route('admin.peminjamans.index') }}" class="px-4 py-2 bg-gray-100 rounded">Kembali</a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-sm text-gray-500">Kode Peminjaman</div>
                <div class="font-medium text-lg">{{ $peminjaman->kode_peminjaman }}</div>

                <div class="mt-4 text-sm text-gray-500">Pengaju</div>
                <div class="font-medium">{{ $peminjaman->user->name ?? $peminjaman->user->username ?? $peminjaman->user->email }}</div>

                <div class="mt-4 text-sm text-gray-500">Alat</div>
                <div class="font-medium">{{ $peminjaman->alat->nama_alat ?? '-' }} ({{ $peminjaman->alat->kode_alat ?? '-' }})</div>

                <div class="mt-4 text-sm text-gray-500">Jumlah</div>
                <div class="font-medium">{{ $peminjaman->jumlah }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Tanggal Peminjaman</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y') }}</div>

                <div class="mt-4 text-sm text-gray-500">Tanggal Berakhir</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($peminjaman->tanggal_berakhir_peminjaman)->format('d M Y') }}</div>

                <div class="mt-4 text-sm text-gray-500">Status</div>
                <div class="font-medium">{{ ucfirst(str_replace('_', ' ', $peminjaman->status)) }}</div>

                @if($peminjaman->disetujuiOleh)
                    <div class="mt-4 text-sm text-gray-500">Disetujui Oleh</div>
                    <div class="font-medium">{{ $peminjaman->disetujuiOleh->name ?? $peminjaman->disetujuiOleh->username ?? '-' }}</div>
                    <div class="text-sm text-gray-500">Tanggal Disetujui</div>
                    <div class="font-medium">{{ $peminjaman->tanggal_disetujui ? \Carbon\Carbon::parse($peminjaman->tanggal_disetujui)->format('d M Y H:i') : '-' }}</div>
                @endif
            </div>
        </div>

        @if($peminjaman->catatan_admin)
            <div class="mt-6">
                <div class="text-sm text-gray-500">Catatan Admin</div>
                <div class="mt-2 text-gray-800">{{ $peminjaman->catatan_admin }}</div>
            </div>
        @endif
    </div>

    <!-- Reject Modal -->
    <div x-show="showReject" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-lg w-full max-w-lg p-6">
            <h3 class="text-lg font-semibold">Tolak Peminjaman</h3>
            <p class="text-sm text-gray-600 mt-2">Masukkan alasan penolakan untuk <strong>{{ $peminjaman->kode_peminjaman }}</strong></p>
            <div class="mt-3">
                <textarea x-model="rejectNote" rows="4" class="w-full p-2 border rounded"></textarea>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button @click="showReject=false" class="px-3 py-2 border rounded">Batal</button>
                <form id="rejectForm" action="{{ route('admin.peminjamans.reject', $peminjaman->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="catatan_admin" x-bind:value="rejectNote">
                    <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded">Kirim Tolak</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
