@extends('layouts.sidebar')

@section('title', 'Detail Denda')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Detail Denda</h1>
        <div>
            <a href="{{ route('petugas.dendas.index') }}" class="px-3 py-2 border rounded">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded shadow p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-sm text-gray-500">Kode Peminjaman</div>
                <div class="font-medium">{{ $denda->pengembalian->peminjaman->kode_peminjaman ?? '-' }}</div>

                <div class="mt-3 text-sm text-gray-500">Peminjam</div>
                <div class="font-medium">{{ $denda->pengembalian->peminjaman->user->username ?? $denda->pengembalian->peminjaman->user->name }}</div>

                <div class="mt-3 text-sm text-gray-500">Alat</div>
                <div class="font-medium">{{ $denda->pengembalian->peminjaman->alat->nama_alat ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Total Denda</div>
                <div class="font-medium text-lg">Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</div>

                <div class="mt-3 text-sm text-gray-500">Status</div>
                <div class="font-medium">{{ ucfirst($denda->status) }}</div>
            </div>
        </div>

        @if($denda->bukti_pembayaran)
            <div class="mt-4">
                <div class="text-sm text-gray-500">Bukti Pembayaran</div>
                <img src="{{ asset('storage/' . $denda->bukti_pembayaran) }}" alt="bukti" class="mt-2 max-h-64 object-contain border rounded" />
            </div>
        @endif

        @if($denda->status === 'belum_dibayar')
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Konfirmasi Pembayaran</h3>
                <form action="{{ route('petugas.dendas.confirm-payment', $denda) }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-4 rounded">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Upload Bukti Pembayaran (Gambar)</label>
                        <input type="file" name="bukti_pembayaran" accept="image/*" required class="mt-2" />
                        @error('bukti_pembayaran') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('petugas.dendas.index') }}" class="px-4 py-2 border rounded">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Konfirmasi Pembayaran</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
