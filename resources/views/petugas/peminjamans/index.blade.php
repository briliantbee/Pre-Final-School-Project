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
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Manajemen Peminjaman</h1>
        <div class="flex gap-2">
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode / user / alat" class="px-3 py-2 border rounded" />
                <select name="status" class="px-3 py-2 border rounded">
                    <option value="">Semua Status</option>
                    <option value="menunggu_konfirmasi" {{ request('status')=='menunggu_konfirmasi'?'selected':'' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status')=='disetujui'?'selected':'' }}>Disetujui</option>
                    <option value="dipinjam" {{ request('status')=='dipinjam'?'selected':'' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status')=='dikembalikan'?'selected':'' }}>Dikembalikan</option>
                    <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
                </select>
                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Filter</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 mb-4 text-red-700 bg-red-100 rounded">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kode</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">User</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Alat</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Jumlah</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Periode</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($peminjamans as $p)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration + ($peminjamans->currentPage()-1) * $peminjamans->perPage() }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $p->kode_peminjaman }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->user->username ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->alat->nama_alat ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->jumlah }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d M Y') }} → {{ \Carbon\Carbon::parse($p->tanggal_berakhir_peminjaman)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($p->status === 'menunggu_konfirmasi')
                                <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded">Menunggu</span>
                            @elseif($p->status === 'disetujui')
                                <span class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded">Disetujui</span>
                            @elseif($p->status === 'dipinjam')
                                <span class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded">Dipinjam</span>
                            @elseif($p->status === 'dikembalikan')
                                <span class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded">Dikembalikan</span>
                            @else
                                <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded">{{ ucfirst($p->status) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('petugas.peminjamans.show', $p) }}" class="px-3 py-1 border rounded text-sm">Detail</a>
                                @if($p->status === 'menunggu_konfirmasi')
                                    <button @click="openApprove({{ $p->id }}, '{{ $p->kode_peminjaman }}', '{{ $p->user->username ?? $p->user->name ?? $p->user->email ?? '-' }}', '{{ $p->alat->nama_alat ?? '-' }}')" class="px-3 py-1 bg-green-600 text-white rounded text-sm">Setujui</button>
                                    <button @click="openReject({{ $p->id }}, '{{ $p->kode_peminjaman }}', '{{ $p->user->username ?? $p->user->name ?? $p->user->email ?? '-' }}', '{{ $p->alat->nama_alat ?? '-' }}')" class="px-3 py-1 bg-red-600 text-white rounded text-sm">Tolak</button>
                                @endif

                                @if($p->status === 'disetujui')
                                    <button @click="openHandOver({{ $p->id }}, '{{ $p->kode_peminjaman }}', '{{ $p->user->username ?? $p->user->name ?? $p->user->email ?? '-' }}', '{{ $p->alat->nama_alat ?? '-' }}')" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Serahkan</button>
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
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">Tidak ada peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $peminjamans->withQueryString()->links() }}</div>

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
                <h3 class="ml-4 text-lg font-semibold text-gray-900">Konfirmasi Setujui</h3>
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
                    Ya, Setujui
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

    <!-- Hand-over Modal -->
    <div x-show="showHandOver"
         x-cloak
         @click.self="showHandOver = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         style="display: none;">
        <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2"/>
                    </svg>
                </div>
                <h3 class="ml-4 text-lg font-semibold text-gray-900">Serahkan Alat</h3>
            </div>

            <div class="mt-3 text-sm text-gray-600 space-y-2">
                <p>Konfirmasi penyerahan alat kepada peminjam.</p>
                <div class="bg-gray-50 p-3 rounded border border-gray-200">
                    <div><strong>Kode:</strong> <span x-text="selectedKode"></span></div>
                    <div><strong>Peminjam:</strong> <span x-text="selectedUser"></span></div>
                    <div><strong>Alat:</strong> <span x-text="selectedAlat"></span></div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button @click="showHandOver = false" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</button>
                <button @click="confirmHandOver()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Ya, Serahkan</button>
            </div>
        </div>
    </div>

</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
</div>
@endsection
