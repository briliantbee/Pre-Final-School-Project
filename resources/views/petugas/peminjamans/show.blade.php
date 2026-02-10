@extends('layouts.sidebar')

@section('title', 'Detail Peminjaman')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">{{ $peminjaman->kode_peminjaman }}</h1>
        <a href="{{ route('petugas.peminjamans.index') }}" class="px-3 py-2 border rounded">Kembali</a>
    </div>

    <div class="bg-white shadow rounded p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="text-sm text-gray-500">User</div>
                <div class="font-medium">{{ $peminjaman->user->username ?? '-' }}</div>

                <div class="mt-4 text-sm text-gray-500">Alat</div>
                <div class="font-medium">{{ $peminjaman->alat->nama_alat ?? '-' }} ({{ $peminjaman->alat->kode_alat ?? '-' }})</div>

                <div class="mt-4 text-sm text-gray-500">Jumlah</div>
                <div class="font-medium">{{ $peminjaman->jumlah }}</div>

                <div class="mt-4 text-sm text-gray-500">Keperluan</div>
                <div class="font-medium">{{ $peminjaman->keperluan }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Periode</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->toDateString() }} → {{ \Carbon\Carbon::parse($peminjaman->tanggal_berakhir_peminjaman)->toDateString() }}</div>

                <div class="mt-4 text-sm text-gray-500">Status</div>
                <div class="font-medium">{{ ucfirst($peminjaman->status) }}</div>

                @if($peminjaman->catatan_admin)
                    <div class="mt-4 text-sm text-gray-500">Catatan Admin</div>
                    <div class="font-medium text-red-600">{{ $peminjaman->catatan_admin }}</div>
                @endif

                <div class="mt-6">
                    @if($peminjaman->status === 'menunggu_konfirmasi')
                        <form action="{{ route('petugas.peminjamans.approve', $peminjaman) }}" method="POST" class="inline-block mr-2">
                            @csrf
                            <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded">Setujui</button>
                        </form>

                        <button onclick="document.getElementById('reject-form').classList.remove('hidden')" class="px-3 py-2 bg-red-600 text-white rounded">Tolak</button>

                        <form id="reject-form" action="{{ route('petugas.peminjamans.reject', $peminjaman) }}" method="POST" class="hidden mt-3">
                            @csrf
                            <label class="text-sm text-gray-700">Alasan penolakan</label>
                            <input type="text" name="catatan_admin" class="mt-1 block w-full border rounded px-3 py-2" required />
                            <div class="mt-2 flex gap-2">
                                <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded">Kirim</button>
                                <button type="button" onclick="document.getElementById('reject-form').classList.add('hidden')" class="px-3 py-2 bg-gray-200 rounded">Batal</button>
                            </div>
                        </form>
                    @endif

                    @if($peminjaman->status === 'disetujui')
                        <form action="{{ route('petugas.peminjamans.hand-over', $peminjaman) }}" method="POST" onsubmit="return confirm('Serahkan alat ke peminjam?')">
                            @csrf
                            <button type="submit" class="px-3 py-2 bg-indigo-600 text-white rounded">Serahkan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection