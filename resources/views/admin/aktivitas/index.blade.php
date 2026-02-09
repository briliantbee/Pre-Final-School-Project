@extends('layouts.sidebar')

@section('title', 'Activity Log')

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

<a href="{{ route('admin.alats.index') }}" class="flex items-center px-6 py-3 text-white bg-blue-700 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
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

<a href="{{ route('admin.dendas.index') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:border-l-4 hover:border-blue-400 transition-all">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Denda
</a>

<a href="{{ route('admin.aktivitas.index') }}" class="flex items-center px-6 py-3 text-white bg-blue-700 border-l-4 border-blue-400 transition-all">
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
            <h2 class="text-2xl font-semibold">Activity Log</h2>
            <p class="text-sm text-gray-600">Riwayat aktivitas pengguna — filter menurut kata kunci atau rentang tanggal.</p>
        </div>

        <div class="flex items-center gap-4">
            <form action="{{ route('admin.aktivitas.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas, deskripsi, atau username" class="px-3 py-2 border rounded-lg" />
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2 border rounded-lg" />
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2 border rounded-lg" />
                <button type="submit" class="px-3 py-2 bg-gray-100 rounded">Filter</button>
            </form>
        </div>
    </div>

    <div class="grid gap-4">
        @forelse($aktivitas as $a)
            <div class="bg-white rounded-lg shadow p-4 flex justify-between items-start">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($a->created_at)->format('d M Y H:i') }}</div>
                        <div class="text-sm text-gray-400">•</div>
                        <div class="text-sm text-gray-500">By: {{ $a->user->name ?? $a->user->username ?? 'User' }}</div>
                    </div>

                    <h3 class="mt-2 text-lg font-semibold">{{ ucfirst($a->aktivitas) }}</h3>
                    @if($a->deskripsi)
                        <p class="mt-1 text-sm text-gray-600">{{ Str::limit($a->deskripsi, 200) }}</p>
                    @endif

                    <div class="mt-3 text-xs text-gray-400">IP: {{ $a->ip_address ?? '-' }} · UA: {{ Str::limit($a->user_agent ?? '-', 80) }}</div>
                </div>

                <div class="ml-4 text-right">
                    <a href="{{ route('admin.aktivitas.show', $a->id) }}" class="px-3 py-1 border rounded text-sm">Detail</a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-6 text-center text-gray-600">Tidak ada aktivitas ditemukan.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $aktivitas->links() }}</div>
</div>

@endsection
