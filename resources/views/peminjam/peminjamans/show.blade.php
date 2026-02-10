@extends('layouts.sidebar')

@section('title', 'Detail Peminjaman')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">{{ $peminjaman->kode_peminjaman }}</h1>
        <a href="{{ route('peminjam.peminjamans.index') }}" class="px-3 py-2 border rounded">Kembali</a>
    </div>

    <div class="bg-white shadow rounded p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-sm text-gray-500">Alat</div>
                <div class="font-medium">{{ $peminjaman->alat->nama_alat ?? '-' }}</div>

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

                @if($peminjaman->status === 'menunggu_konfirmasi')
                    <div class="mt-6">
                        <form action="{{ route('peminjam.peminjamans.cancel', $peminjaman) }}" method="POST" onsubmit="return confirm('Batalkan peminjaman ini?')">
                            @csrf
                            <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded">Batalkan Peminjaman</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
