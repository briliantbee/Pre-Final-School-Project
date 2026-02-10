@extends('layouts.sidebar')

@section('title', 'Daftar Alat')

@section('navigation')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
<div>
    <!-- Gradient Header -->
    <div class="relative mb-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/10"></div>
        <div class="relative px-8 py-10">
            <h2 class="text-3xl font-bold text-white flex items-center gap-3">
                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                Alat Tersedia
            </h2>
            <p class="text-blue-100 mt-2 ml-14">Telusuri alat yang tersedia untuk dipinjam</p>
        </div>
    </div>

    <!-- Modern Search & Filter -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-6">
        <form action="{{ route('peminjam.alats.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative md:col-span-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama atau kode alat..." 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div class="relative">
                    <select name="kategori_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white">
                        <option value="">📦 Semua Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" @if(request('kategori_id') == $k->id) selected @endif>{{ $k->nama_kategori }} ({{ $k->alats_count }})</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Enhanced Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($alats as $alat)
            <div class="bg-white rounded-xl shadow-md border border-gray-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 overflow-hidden flex flex-col">
                <!-- Image Section -->
                <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden relative group">
                    @if($alat->foto)
                        <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300" />
                    @else
                        <div class="text-gray-400 flex flex-col items-center gap-2">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">No Image</span>
                        </div>
                    @endif
                    <!-- Stock Badge Overlay -->
                    <div class="absolute top-3 right-3">
                        @if($alat->stok_tersedia > 0)
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-500 text-white rounded-full text-xs font-bold shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $alat->stok_tersedia }} Tersedia
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500 text-white rounded-full text-xs font-bold shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Kosong
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-medium text-gray-500 mb-1">{{ $alat->kode_alat ?? '-' }}</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $alat->nama_alat }}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-3">{{ $alat->deskripsi ?? 'Tidak ada deskripsi' }}</p>

                        <!-- Category Badge -->
                        <div class="mb-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ $alat->kategori->nama_kategori ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex items-center gap-2">
                        <a href="{{ route('peminjam.alats.show', $alat->id) }}" 
                           class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detail
                        </a>
                        @if($alat->stok_tersedia > 0)
                            <a href="{{ route('peminjam.alats.show', $alat->id) }}#pinjam" 
                               class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 font-semibold text-sm shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Pinjam
                            </a>
                        @else
                            <span class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-500 rounded-lg text-sm font-medium cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Kosong
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 bg-white rounded-xl shadow-md border border-gray-200 p-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium text-lg">Tidak ada alat tersedia</p>
                <p class="text-sm text-gray-400 mt-2">Alat akan muncul di sini ketika tersedia</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $alats->links() }}</div>
</div>

@endsection
