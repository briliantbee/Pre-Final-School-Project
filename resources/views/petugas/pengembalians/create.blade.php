@extends('layouts.sidebar')

@section('title', 'Proses Pengembalian')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Proses Pengembalian</h1>

    @if(session('error'))
        <div class="p-3 mb-4 text-red-700 bg-red-100 rounded">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-100 rounded">
            <ul class="text-sm text-red-700 list-disc list-inside">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form x-data="{
            selectedId: '{{ old('peminjaman_id', '') }}',
            peminjamanMap: {
                @foreach($peminjamans as $pm)
                    '{{ $pm->id }}': { max: {{ $pm->jumlah }}, alat: '{{ addslashes($pm->alat->nama_alat ?? '-') }}', kode: '{{ $pm->kode_peminjaman }}' },
                @endforeach
            },
            getSelected() { return this.peminjamanMap[this.selectedId] || null },
            updateDefaults(el) {
                if (!this.selectedId) return;
                const data = this.getSelected();
                if (!data) return;
                const jumlahInput = el.querySelector('[name=jumlah_dikembalikan]');
                if (jumlahInput) {
                    jumlahInput.max = data.max;
                    if (parseInt(jumlahInput.value) > data.max) jumlahInput.value = data.max;
                }
            }
        }" x-init="updateDefaults($el)" @change="updateDefaults($el)" action="{{ route('petugas.pengembalians.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Peminjaman</label>
            <select name="peminjaman_id" x-model="selectedId" required class="w-full px-3 py-2 border rounded">
                <option value="">Pilih peminjaman</option>
                @foreach($peminjamans as $pm)
                    <option value="{{ $pm->id }}" {{ old('peminjaman_id') == $pm->id ? 'selected' : '' }} data-max="{{ $pm->jumlah }}">{{ $pm->kode_peminjaman }} — {{ $pm->user->username ?? $pm->user->name }} — {{ $pm->alat->nama_alat }} ({{ $pm->jumlah }})</option>
                @endforeach
            </select>
            @error('peminjaman_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Pengembalian</label>
                <input type="date" name="tanggal_pengembalian" required value="{{ old('tanggal_pengembalian', date('Y-m-d')) }}" class="w-full px-3 py-2 border rounded" />
                @error('tanggal_pengembalian') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jumlah Dikembalikan</label>
                <input type="number" name="jumlah_dikembalikan" required min="1" value="{{ old('jumlah_dikembalikan', 1) }}" class="w-full px-3 py-2 border rounded" />
                <div class="text-xs text-gray-500 mt-1">Pastikan tidak melebihi jumlah yang dipinjam.</div>
                @error('jumlah_dikembalikan') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Kondisi Alat</label>
            <select name="kondisi_alat" required class="w-full px-3 py-2 border rounded">
                <option value="baik" {{ old('kondisi_alat')=='baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak" {{ old('kondisi_alat')=='rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="hilang" {{ old('kondisi_alat')=='hilang' ? 'selected' : '' }}>Hilang</option>
                <option value="tidak_lengkap" {{ old('kondisi_alat')=='tidak_lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
            </select>
            @error('kondisi_alat') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Catatan (opsional)</label>
            <textarea name="catatan" class="w-full px-3 py-2 border rounded" rows="4">{{ old('catatan') }}</textarea>
            @error('catatan') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('petugas.pengembalians.index') }}" class="px-4 py-2 border rounded">Batal</a>
            <button type="button" @click="$dispatch('open-confirm')" class="px-4 py-2 bg-blue-600 text-white rounded">Proses Pengembalian</button>
        </div>

        <!-- Confirmation modal -->
        <div x-data @open-confirm.window="$el.__open = true" x-init="$el.__open = false" x-show="$el.__open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display:none;">
            <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl">
                <h3 class="text-lg font-semibold mb-3">Konfirmasi Pengembalian</h3>
                <div class="text-sm text-gray-700 mb-4">Anda akan memproses pengembalian. Pastikan data sudah benar.</div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="$el.__open = false" class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" @click="$el.__open = false" class="px-4 py-2 bg-blue-600 text-white rounded">Ya, Proses</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
