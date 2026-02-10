@extends('layouts.sidebar')

@section('title', 'Peminjaman Saya')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Peminjaman Saya</h1>
        <a href="{{ route('peminjam.peminjamans.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Ajukan Peminjaman</a>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 mb-4 text-red-700 bg-red-100 rounded">{{ session('error') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg p-4 mb-4">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama alat" class="px-3 py-2 border rounded w-full" />
            <select name="status" class="px-3 py-2 border rounded">
                <option value="">Semua</option>
                <option value="menunggu_konfirmasi" {{ request('status')=='menunggu_konfirmasi'?'selected':'' }}>Menunggu ({{ $statusCounts['menunggu'] }})</option>
                <option value="disetujui" {{ request('status')=='disetujui'?'selected':'' }}>Disetujui ({{ $statusCounts['disetujui'] }})</option>
                <option value="dipinjam" {{ request('status')=='dipinjam'?'selected':'' }}>Dipinjam ({{ $statusCounts['dipinjam'] }})</option>
                <option value="dikembalikan" {{ request('status')=='dikembalikan'?'selected':'' }}>Dikembalikan ({{ $statusCounts['dikembalikan'] }})</option>
                <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak ({{ $statusCounts['ditolak'] }})</option>
            </select>
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Filter</button>
        </form>
    </div>

    <div class="grid gap-3">
        @forelse($peminjamans as $p)
            <div class="bg-white shadow rounded p-4 flex items-start justify-between">
                <div>
                    <div class="text-sm text-gray-500">{{ $p->kode_peminjaman }} · {{ $p->alat->nama_alat ?? '-' }}</div>
                    <div class="font-medium">{{ $p->jumlah }} buah · {{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->toDateString() }} → {{ \Carbon\Carbon::parse($p->tanggal_berakhir_peminjaman)->toDateString() }}</div>
                    @if($p->catatan_admin)
                        <div class="text-sm text-gray-600">Catatan: {{ $p->catatan_admin }}</div>
                    @endif
                </div>

                <div class="text-right">
                    <div class="mb-2">
                        @if($p->status === 'menunggu_konfirmasi')
                            <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded">Menunggu</span>
                        @elseif($p->status === 'disetujui')
                            <span class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded">Disetujui</span>
                        @elseif($p->status === 'dipinjam')
                            <span class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded">Dipinjam</span>
                        @elseif($p->status === 'dikembalikan')
                            <span class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded">Dikembalikan</span>
                        @else
                            <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded">{{ ucfirst($p->status) }}</span>
                        @endif
                    </div>
                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('peminjam.peminjamans.show', $p) }}" class="px-3 py-1 border rounded">Detail</a>
                        @if($p->status === 'menunggu_konfirmasi')
                            <form action="{{ route('peminjam.peminjamans.cancel', $p) }}" method="POST" onsubmit="return confirm('Batalkan peminjaman ini?')">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Batalkan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-gray-600">Belum ada peminjaman.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $peminjamans->withQueryString()->links() }}</div>
</div>

@endsection
