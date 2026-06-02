@extends('layouts_admin.app')
@section('title', 'Manajemen Berita')

@section('content')
<div class="container">

    {{-- ─── VALIDATION ERROR BANNER ─────────────────────────────────────────── --}}
    @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-red-700 mb-2">Validasi Gagal — Periksa Input Berikut:</h4>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="text-xs text-red-600 flex items-start gap-1.5">
                                <span class="mt-0.5 shrink-0">&#x25CF;</span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── SUCCESS TOAST ────────────────────────────────────────────────────── --}}
    @if(session('success'))
        <div id="successToast" class="mb-5 bg-green-50 border border-green-200 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-green-700">{{ session('success') }}</span>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('successToast'); if(t) t.remove(); }, 4000);</script>
    @endif

    {{-- ─── HEADER ───────────────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#5D605C]">Manajemen Berita</h1>
            <p class="text-sm text-gray-400 mt-0.5">Kelola artikel dan berita kesehatan kulit untuk pasien</p>
        </div>
        <a href="{{ route('admin.news.create') }}"
           class="bg-pink-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow hover:bg-pink-600 transition-colors inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tulis Berita Baru
        </a>
    </div>

    {{-- ─── FILTER BAR ────────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] p-4 mb-5">
        <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-wrap gap-3">
            <input type="text" name="search" placeholder="Cari judul berita..."
                value="{{ request('search') }}"
                class="flex-1 min-w-[200px] px-3 py-2 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-pink-400">
            <button type="submit"
                class="px-4 py-2 bg-pink-500 text-white rounded-xl text-sm font-semibold hover:bg-pink-600 transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.news.index') }}"
                    class="px-4 py-2 bg-[#E1E3DE] text-[#5D605C] rounded-xl text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ─── TABLE ─────────────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#E1E3DE] flex items-center justify-between">
            <h3 class="font-semibold text-[#5D605C]">Daftar Artikel Berita</h3>
            <span class="text-xs text-gray-400">Total: {{ $newsList->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-[#5D605C] uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Cover</th>
                        <th class="p-4 text-left">Judul Berita</th>
                        <th class="p-4 text-left">Penulis</th>
                        <th class="p-4 text-left">Tanggal</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E1E3DE]/60">
                    @forelse ($newsList as $index => $item)
                        <tr class="hover:bg-pink-50 transition-colors">

                            {{-- No --}}
                            <td class="p-4 text-gray-400 text-xs">
                                {{ $newsList->firstItem() + $index }}
                            </td>

                            {{-- Cover Image --}}
                            <td class="p-4">
                                @if($item->image_path)
                                    <img src="{{ asset($item->image_path) }}"
                                         alt="{{ $item->title }}"
                                         class="w-16 h-11 object-cover rounded-lg border border-[#E1E3DE] bg-gray-100">
                                @else
                                    <div class="w-16 h-11 rounded-lg border border-[#E1E3DE] bg-gray-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>

                            {{-- Title --}}
                            <td class="p-4 font-semibold text-[#5D605C] max-w-xs">
                                <p class="line-clamp-2 leading-snug">{{ $item->title }}</p>
                                <p class="text-[10px] text-gray-400 font-normal mt-0.5 font-mono">{{ $item->slug }}</p>
                            </td>

                            {{-- Author --}}
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-pink-100 flex items-center justify-center shrink-0">
                                        <span class="text-[10px] font-bold text-pink-600 uppercase">
                                            {{ substr($item->user->name ?? 'A', 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-[#5D605C]">{{ $item->user->name ?? '—' }}</span>
                                </div>
                            </td>

                            {{-- Date --}}
                            <td class="p-4 text-xs text-gray-400">
                                {{ $item->created_at->format('d M Y') }}<br>
                                <span class="text-gray-300">{{ $item->created_at->format('H:i') }} WIB</span>
                            </td>

                            {{-- Actions --}}
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.news.edit', $item->id) }}"
                                       class="px-3 py-1.5 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-500 hover:text-white transition-colors font-medium">
                                        Edit
                                    </a>

                                    <form id="deleteForm-{{ $item->id }}"
                                        action="{{ route('admin.news.destroy', $item->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button"
                                        onclick="confirmDelete({{ $item->id }}, @js($item->title))"
                                        class="px-3 py-1.5 text-xs bg-red-50 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition-colors font-medium">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-[#E1E3DE]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h3"/>
                                    </svg>
                                    Belum ada artikel berita. Mulai menulis sekarang.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $newsList->appends(request()->query())->links() }}
    </div>

</div>

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- DELETE CONFIRM MODAL                                           --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
<div id="deleteConfirmModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-red-100">
        
        <!-- Ikon Peringatan -->
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-red-600 text-2xl font-bold">!</span>
        </div>
        
        <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Berita?</h2>
        <p class="text-sm text-gray-500 text-center mb-2">
            Apakah Anda yakin ingin menghapus berita:
        </p>
        
        <!-- Target Judul Berita -->
        <p id="deleteTargetName" class="text-sm text-gray-700 text-center font-medium italic mb-6 px-2"></p>
        
        <p class="text-xs text-gray-400 text-center mb-6">Tindakan ini bersifat permanen dan tidak dapat dibatalkan. Foto cover berita juga akan dihapus.</p>
        
        <!-- Tombol Aksi -->
        <div class="flex justify-center gap-2">
            <button type="button" onclick="closeDeleteModal()"
                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors font-medium">
                Batal
            </button>
            <button type="button" id="confirmDeleteBtn" onclick="executeDelete()"
                class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 shadow transition-colors font-medium">
                Ya, Hapus
            </button>
        </div>
        
    </div>
</div>

<script>
let _pendingDeleteFormId = null;

function confirmDelete(id, title) {
    _pendingDeleteFormId = 'deleteForm-' + id;
    
    // Sedikit modifikasi: menambahkan tanda kutip ganda otomatis seperti di referensi Anda
    document.getElementById('deleteTargetName').textContent = '"' + title + '"';
    
    const modal = document.getElementById('deleteConfirmModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteConfirmModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    _pendingDeleteFormId = null;
}

function executeDelete() {
    if (!_pendingDeleteFormId) return;
    const form = document.getElementById(_pendingDeleteFormId);
    if (form) form.submit();
}

// Tutup modal jika area luar di-klik
document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>

@endsection