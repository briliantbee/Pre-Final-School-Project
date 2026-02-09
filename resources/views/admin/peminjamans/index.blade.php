@extends('layouts.sidebar')

@section('title', 'Peminjaman')

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
<div x-data="{
    showApprove: false,
    showReject: false,
    selectedId: null,
    selectedKode: '',
    selectedUser: '',
    selectedAlat: '',
    rejectNote: '',
    
    openApprove(id, kode, user, alat) {
        this.selectedId = id;
        this.selectedKode = kode;
        this.selectedUser = user;
        this.selectedAlat = alat;
        this.showApprove = true;
    },
    
    openReject(id, kode, user, alat) {
        this.selectedId = id;
        this.selectedKode = kode;
        this.selectedUser = user;
        this.selectedAlat = alat;
        this.rejectNote = '';
        this.showReject = true;
    },
    
    confirmApprove() {
        if (!this.selectedId) return;
        const form = document.getElementById('approveForm' + this.selectedId);
        if (form) form.submit();
    },
    
    confirmReject() {
        if (!this.selectedId || !this.rejectNote.trim()) {
            alert('Alasan penolakan harus diisi!');
            return;
        }
        const form = document.getElementById('rejectForm' + this.selectedId);
        if (form) {
            form.querySelector('[name=catatan_admin]').value = this.rejectNote;
            form.submit();
        }
    }
}">

    <div class="mb-6 flex items-start justify-between gap-6">
        <div>
            <h2 class="text-2xl font-semibold">Peminjaman</h2>
            <p class="text-sm text-gray-600">Kelola permintaan peminjaman alat — approve / reject dari sini.</p>
        </div>

        <div class="flex items-center gap-4">
            <form action="{{ route('admin.peminjamans.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode, pengguna, atau alat" class="px-3 py-2 border rounded-lg" />
                <select name="status" class="px-3 py-2 border rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="menunggu_konfirmasi" @if(request('status')=='menunggu_konfirmasi') selected @endif>Menunggu</option>
                    <option value="disetujui" @if(request('status')=='disetujui') selected @endif>Disetujui</option>
                    <option value="dipinjam" @if(request('status')=='dipinjam') selected @endif>Dipinjam</option>
                    <option value="dikembalikan" @if(request('status')=='dikembalikan') selected @endif>Dikembalikan</option>
                    <option value="ditolak" @if(request('status')=='ditolak') selected @endif>Ditolak</option>
                </select>
                <button type="submit" class="px-3 py-2 bg-gray-100 rounded">Filter</button>
            </form>
        </div>
    </div>

    <!-- Status counts -->
    <div class="grid grid-cols-5 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Menunggu</div>
            <div class="text-2xl font-bold">{{ $statusCounts['menunggu'] ?? 0 }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Disetujui</div>
            <div class="text-2xl font-bold">{{ $statusCounts['disetujui'] ?? 0 }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Dipinjam</div>
            <div class="text-2xl font-bold">{{ $statusCounts['dipinjam'] ?? 0 }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Dikembalikan</div>
            <div class="text-2xl font-bold">{{ $statusCounts['dikembalikan'] ?? 0 }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Ditolak</div>
            <div class="text-2xl font-bold">{{ $statusCounts['ditolak'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Cards list -->
    <div class="grid grid-cols-3 gap-4">
        @foreach($peminjamans as $p)
        <div class="bg-white rounded-lg shadow p-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">{{ $p->kode_peminjaman }}</div>
                        <h3 class="text-lg font-semibold">{{ $p->user->name ?? ($p->user->email ?? 'User') }}</h3>
                        <div class="text-sm text-gray-500">{{ $p->alat->nama_alat ?? '-' }} • Jumlah: {{ $p->jumlah }}</div>
                    </div>
                    <div class="text-right">
                        @if($p->status == 'menunggu_konfirmasi')
                            <span class="px-2 py-1 text-sm bg-yellow-100 text-yellow-800 rounded">Menunggu</span>
                        @elseif($p->status == 'disetujui')
                            <span class="px-2 py-1 text-sm bg-green-100 text-green-800 rounded">Disetujui</span>
                        @elseif($p->status == 'dipinjam')
                            <span class="px-2 py-1 text-sm bg-blue-100 text-blue-800 rounded">Dipinjam</span>
                        @elseif($p->status == 'dikembalikan')
                            <span class="px-2 py-1 text-sm bg-indigo-100 text-indigo-800 rounded">Dikembalikan</span>
                        @else
                            <span class="px-2 py-1 text-sm bg-red-100 text-red-800 rounded">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="mt-3 text-sm text-gray-600">
                    <div>Tanggal pinjam: {{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d M Y') }}</div>
                    <div>Tanggal selesai: {{ \Carbon\Carbon::parse($p->tanggal_berakhir_peminjaman)->format('d M Y') }}</div>
                    @if($p->catatan_admin)
                        <div class="mt-2 text-sm text-red-600">Catatan: {{ $p->catatan_admin }}</div>
                    @endif
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <a href="{{ route('admin.peminjamans.show', $p->id) }}" class="px-3 py-1 border rounded text-sm">Detail</a>

                <div class="flex items-center gap-2">
                    @if($p->status == 'menunggu_konfirmasi')
                        <button 
                            @click="openApprove({{ $p->id }}, '{{ $p->kode_peminjaman }}', '{{ $p->user->name ?? $p->user->email }}', '{{ $p->alat->nama_alat ?? '-' }}')" 
                            class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                            Approve
                        </button>
                        <button 
                            @click="openReject({{ $p->id }}, '{{ $p->kode_peminjaman }}', '{{ $p->user->name ?? $p->user->email }}', '{{ $p->alat->nama_alat ?? '-' }}')" 
                            class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                            Reject
                        </button>
                    @else
                        <span class="text-sm text-gray-500">—</span>
                    @endif
                </div>
            </div>

            <!-- Hidden forms -->
            <form id="approveForm{{ $p->id }}" action="{{ route('admin.peminjamans.approve', $p->id) }}" method="POST" style="display: none;">
                @csrf
            </form>
            <form id="rejectForm{{ $p->id }}" action="{{ route('admin.peminjamans.reject', $p->id) }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="catatan_admin" value="">
            </form>
        </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $peminjamans->links() }}</div>

    <!-- Approve Modal -->
    <div x-show="showApprove" 
         x-cloak 
         @click.self="showApprove = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         style="display: none;">
        <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-semibold text-gray-900">Konfirmasi Approve</h3>
            </div>
            
            <div class="mt-3 text-sm text-gray-600 space-y-2">
                <p>Apakah Anda yakin ingin menyetujui peminjaman ini?</p>
                <div class="bg-gray-50 p-3 rounded border border-gray-200">
                    <div><strong>Kode:</strong> <span x-text="selectedKode"></span></div>
                    <div><strong>Peminjam:</strong> <span x-text="selectedUser"></span></div>
                    <div><strong>Alat:</strong> <span x-text="selectedAlat"></span></div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end gap-3">
                <button 
                    @click="showApprove = false" 
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button 
                    @click="confirmApprove()" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Ya, Approve
                </button>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div x-show="showReject" 
         x-cloak
         @click.self="showReject = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         style="display: none;">
        <div class="bg-white rounded-lg w-full max-w-lg p-6 shadow-xl">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-semibold text-gray-900">Tolak Peminjaman</h3>
            </div>
            
            <div class="mt-3 space-y-3">
                <div class="bg-gray-50 p-3 rounded border border-gray-200 text-sm">
                    <div><strong>Kode:</strong> <span x-text="selectedKode"></span></div>
                    <div><strong>Peminjam:</strong> <span x-text="selectedUser"></span></div>
                    <div><strong>Alat:</strong> <span x-text="selectedAlat"></span></div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        x-model="rejectNote" 
                        rows="4" 
                        placeholder="Masukkan alasan penolakan..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end gap-3">
                <button 
                    @click="showReject = false" 
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button 
                    @click="confirmReject()" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Tolak Peminjaman
                </button>
            </div>
        </div>
    </div>

</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection