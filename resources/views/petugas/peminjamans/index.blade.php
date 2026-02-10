@extends('layouts.sidebar')

@section('title', 'Peminjaman (Petugas)')

@section('navigation')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
    <div x-data="{
        showApprove: false,
        showReject: false,
        showHandOver: false,
        selectedId: null,
        selectedKode: '',
        selectedUser: '',
        selectedAlat: '',
        rejectNote: '',
        openHandOver(id, kode, user, alat) {
            this.selectedId = id;
            this.selectedKode = kode;
            this.selectedUser = user;
            this.selectedAlat = alat;
            this.showHandOver = true;
        },
        confirmHandOver() {
            if (!this.selectedId) return;
            const form = document.getElementById('handOverForm' + this.selectedId);
            if (form) form.submit();
        },
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
    }" class="max-w-7xl mx-auto">
    <!-- Header dengan Gradient -->
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Manajemen Peminjaman</h1>
                        <p class="text-blue-100 mt-1">Kelola persetujuan dan penyerahan alat</p>
                    </div>
                </div>
                <a href="{{ route('petugas.peminjamans.export') }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white rounded-xl hover:bg-white/30 transition-all duration-200 font-medium shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="flex items-center p-4 mb-6 text-green-800 bg-green-50 border border-green-200 rounded-xl shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center p-4 mb-6 text-red-800 bg-red-50 border border-red-200 rounded-xl shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Kode / user / alat..." 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">🔄 Semua Status</option>
                    <option value="menunggu_konfirmasi" {{ request('status')=='menunggu_konfirmasi'?'selected':'' }}>⏳ Menunggu</option>
                    <option value="disetujui" {{ request('status')=='disetujui'?'selected':'' }}>✅ Disetujui</option>
                    <option value="dipinjam" {{ request('status')=='dipinjam'?'selected':'' }}>📦 Dipinjam</option>
                    <option value="dikembalikan" {{ request('status')=='dikembalikan'?'selected':'' }}>🔄 Dikembalikan</option>
                    <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>❌ Ditolak</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium shadow-lg shadow-blue-500/30">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Enhanced Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alat</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($peminjamans as $p)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration + ($peminjamans->currentPage()-1) * $peminjamans->perPage() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">{{ $p->kode_peminjaman }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $p->user->username ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $p->alat->nama_alat ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-blue-100 text-blue-800">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                {{ $p->jumlah }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d M Y') }} → {{ \Carbon\Carbon::parse($p->tanggal_berakhir_peminjaman)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($p->status === 'menunggu_konfirmasi')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Menunggu
                                </span>
                            @elseif($p->status === 'disetujui')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-100 text-blue-800">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Disetujui
                                </span>
                            @elseif($p->status === 'dipinjam')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                    </svg>
                                    Dipinjam
                                </span>
                            @elseif($p->status === 'dikembalikan')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-100 text-indigo-800">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                    </svg>
                                    Dikembalikan
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-100 text-red-800">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ ucfirst($p->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('petugas.peminjamans.show', $p) }}" 
                                   class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200 text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                                @if($p->status === 'menunggu_konfirmasi')
                                    <button @click="openApprove({{ $p->id }}, '{{ $p->kode_peminjaman }}', '{{ $p->user->username ?? $p->user->name ?? $p->user->email ?? '-' }}', '{{ $p->alat->nama_alat ?? '-' }}')" 
                                            class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 text-sm font-medium shadow-lg shadow-green-500/30">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Setujui
                                    </button>
                                    <button @click="openReject({{ $p->id }}, '{{ $p->kode_peminjaman }}', '{{ $p->user->username ?? $p->user->name ?? $p->user->email ?? '-' }}', '{{ $p->alat->nama_alat ?? '-' }}')" 
                                            class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 text-sm font-medium shadow-lg shadow-red-500/30">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Tolak
                                    </button>
                                @endif

                                @if($p->status === 'disetujui')
                                    <button @click="openHandOver({{ $p->id }}, '{{ $p->kode_peminjaman }}', '{{ $p->user->username ?? $p->user->name ?? $p->user->email ?? '-' }}', '{{ $p->alat->nama_alat ?? '-' }}')" 
                                            class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 text-sm font-medium shadow-lg shadow-indigo-500/30">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        Serahkan Alat
                                    </button>
                                @endif
                            </div>

                            <form id="approveForm{{ $p->id }}" action="{{ route('petugas.peminjamans.approve', $p) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <form id="rejectForm{{ $p->id }}" action="{{ route('petugas.peminjamans.reject', $p) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="catatan_admin" value="">
                            </form>
                            <form id="handOverForm{{ $p->id }}" action="{{ route('petugas.peminjamans.hand-over', $p) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-lg font-medium">Tidak ada data peminjaman</p>
                                <p class="text-gray-400 text-sm mt-1">Belum ada peminjaman yang terdaftar dalam sistem</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $peminjamans->withQueryString()->links() }}</div>

    <!-- Enhanced Approve Modal -->
    <div x-show="showApprove" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="showApprove = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
         style="display: none;">
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform scale-95 opacity-0"
             x-transition:enter-end="transform scale-100 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="transform scale-100 opacity-100"
             x-transition:leave-end="transform scale-95 opacity-0"
             class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
            <!-- Modal Header with Gradient -->
            <div class="relative bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-5">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative flex items-center">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-xl font-bold text-white">Konfirmasi Setujui</h3>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-700 mb-4">Apakah Anda yakin ingin menyetujui peminjaman ini?</p>
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-xl border border-gray-200">
                    <div class="text-sm"><strong>Kode:</strong> <span x-text="selectedKode" class="text-gray-700"></span></div>
                    <div class="text-sm"><strong>Peminjam:</strong> <span x-text="selectedUser" class="text-gray-700"></span></div>
                    <div class="text-sm"><strong>Alat:</strong> <span x-text="selectedAlat" class="text-gray-700"></span></div>
                </div>
            
                <!-- Modal Footer -->
                <div class="flex justify-end gap- 3 mt-6">
                    <button 
                        @click="showApprove = false" 
                        class="px-5 py-2.5 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                        Batal
                    </button>
                    <button 
                        @click="confirmApprove()" 
                        class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-medium shadow-lg shadow-green-500/30">
                        <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Ya, Setujui
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Reject Modal -->
    <div x-show="showReject" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="showReject = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
         style="display: none;">
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform scale-95 opacity-0"
             x-transition:enter-end="transform scale-100 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="transform scale-100 opacity-100"
             x-transition:leave-end="transform scale-95 opacity-0"
             class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
            <!-- Modal Header with Gradient -->
            <div class="relative bg-gradient-to-r from-red-600 to-rose-600 px-6 py-5">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative flex items-center">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-xl font-bold text-white">Tolak Peminjaman</h3>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-xl border border-gray-200 mb-4">
                    <div class="text-sm"><strong>Kode:</strong> <span x-text="selectedKode" class="text-gray-700"></span></div>
                    <div class="text-sm"><strong>Peminjam:</strong> <span x-text="selectedUser" class="text-gray-700"></span></div>
                    <div class="text-sm"><strong>Alat:</strong> <span x-text="selectedAlat" class="text-gray-700"></span></div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        x-model="rejectNote" 
                        rows="4" 
                        placeholder="Masukkan alasan penolakan..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none"></textarea>
                </div>
            
                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 mt-6">
                    <button 
                        @click="showReject = false" 
                        class="px-5 py-2.5 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                        Batal
                    </button>
                    <button 
                        @click="confirmReject()" 
                        class="px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg hover:from-red-700 hover:to-rose-700 transition-all duration-200 font-medium shadow-lg shadow-red-500/30">
                        <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak Peminjaman
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Hand-over Modal -->
    <div x-show="showHandOver"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="showHandOver = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
         style="display: none;">
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform scale-95 opacity-0"
             x-transition:enter-end="transform scale-100 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="transform scale-100 opacity-100"
             x-transition:leave-end="transform scale-95 opacity-0"
             class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
            <!-- Modal Header with Gradient -->
            <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative flex items-center">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-xl font-bold text-white">Serahkan Alat</h3>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-700 mb-4">Konfirmasi penyerahan alat kepada peminjam.</p>
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-xl border border-gray-200">
                    <div class="text-sm"><strong>Kode:</strong> <span x-text="selectedKode" class="text-gray-700"></span></div>
                    <div class="text-sm"><strong>Peminjam:</strong> <span x-text="selectedUser" class="text-gray-700"></span></div>
                    <div class="text-sm"><strong>Alat:</strong> <span x-text="selectedAlat" class="text-gray-700"></span></div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 mt-6">
                    <button 
                        @click="showHandOver = false" 
                        class="px-5 py-2.5 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                        Batal
                    </button>
                    <button 
                        @click="confirmHandOver()" 
                        class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 font-medium shadow-lg shadow-indigo-500/30">
                        <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                        Ya, Serahkan
                    </button>
                </div>
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
