@extends('layouts.sidebar')

@section('title', 'Ajukan Peminjaman')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Ajukan Peminjaman</h1>

    @if(session('error'))
        <div class="p-3 mb-4 text-red-700 bg-red-100 rounded">{{ session('error') }}</div>
    @endif

    <div class="bg-white shadow rounded p-6">
        <form action="{{ route('peminjam.peminjamans.store') }}" method="POST" class="space-y-4">
            @csrf

            @if(isset($alat) && $alat)
                <div class="text-sm text-gray-500">Alat</div>
                <div class="font-medium">{{ $alat->nama_alat }} ({{ $alat->kode_alat }})</div>
                <input type="hidden" name="alat_id" value="{{ $alat->id }}">
            @else
                <div>
                    <label class="text-sm text-gray-700">Pilih Alat</label>
                    <select name="alat_id" class="mt-1 block w-full border rounded" required>
                        <option value="">-- Pilih Alat --</option>
                        @foreach($alats as $a)
                            <option value="{{ $a->id }}">{{ $a->nama_alat }} — Stok: {{ $a->stok_tersedia }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div>
                <label class="text-sm text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" min="1" value="1" class="mt-1 block w-full border rounded" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-700">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_peminjaman" class="mt-1 block w-full border rounded" min="{{ \Carbon\Carbon::today()->toDateString() }}" required>
                </div>
                <div>
                    <label class="text-sm text-gray-700">Tanggal Kembali</label>
                    <input type="date" name="tanggal_berakhir_peminjaman" class="mt-1 block w-full border rounded" min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}" required>
                </div>
            </div>

            <div>
                <label class="text-sm text-gray-700">Keperluan</label>
                <textarea name="keperluan" rows="4" class="mt-1 block w-full border rounded" required></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('peminjam.peminjamans.index') }}" class="px-3 py-2 border rounded">Batal</a>
                <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded">Ajukan</button>
            </div>
        </form>
    </div>
</div>

@endsection
