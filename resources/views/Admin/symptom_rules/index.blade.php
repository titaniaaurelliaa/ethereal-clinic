@extends('layouts_admin.app')

@section('title', 'Pertanyaan Anamnesis — Admin')

@section('content')
<div class="container">

    {{-- ── HEADER ── --}}
    <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Pertanyaan Anamnesis</h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola pertanyaan kontekstual yang ditampilkan ke pasien berdasarkan deteksi AI.
            </p>
        </div>
        <a href="{{ route('admin.symptom-rules.create') }}"
           class="inline-flex items-center gap-2 bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition font-semibold">
            <i class="fas fa-plus text-sm"></i> Tambah Pertanyaan
        </a>
    </div>

    {{-- ── STAT CARD ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center text-pink-500">
                <i class="fas fa-question-circle"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Pertanyaan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $total }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-500">
                <i class="fas fa-brain"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Jenis Kondisi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $objekList->count() }}</p>
            </div>
        </div>
    </div>

    {{-- ── TABEL ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Filter Bar --}}
        <div class="p-4 border-b bg-gray-50 flex flex-wrap justify-between items-center gap-3">
            <h3 class="font-semibold text-gray-700">Daftar Pertanyaan</h3>

            <form method="GET" action="{{ route('admin.symptom-rules.index') }}" class="flex flex-wrap gap-2">
                <select name="objek"
                    class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                    <option value="">Semua Kondisi</option>
                    @foreach ($objekList as $nama)
                        <option value="{{ $nama }}" {{ request('objek') === $nama ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="search" placeholder="Cari pertanyaan..."
                    value="{{ request('search') }}"
                    class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">

                <button type="submit"
                    class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition text-sm">
                    <i class="fas fa-search"></i> Cari
                </button>

                @if(request('search') || request('objek'))
                    <a href="{{ route('admin.symptom-rules.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left w-10">#</th>
                        <th class="p-4 text-left">Kondisi Kulit (KB)</th>
                        <th class="p-4 text-left">Tingkat</th>
                        <th class="p-4 text-left">Pertanyaan Anamnesis</th>
                        <th class="p-4 text-center w-24">CF Gejala</th>
                        <th class="p-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($rules as $rule)
                        <tr class="hover:bg-pink-50 transition">

                            {{-- No urut --}}
                            <td class="p-4 text-gray-400 text-xs">
                                {{ $loop->iteration + ($rules->currentPage() - 1) * $rules->perPage() }}
                            </td>

                            {{-- Nama Objek --}}
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-pink-100 flex items-center justify-center text-pink-500 shrink-0">
                                        <i class="fas fa-eye text-xs"></i>
                                    </div>
                                    <span class="font-medium text-gray-800">
                                        {{ $rule->knowledgeBase?->nama_objek ?? '—' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Tingkat Keparahan --}}
                            <td class="p-4">
                                @php
                                    $keparahan = $rule->knowledgeBase?->tingkat_keparahan;
                                    $badgeMap  = [
                                        'Ringan' => 'bg-green-100 text-green-700',
                                        'Sedang' => 'bg-yellow-100 text-yellow-700',
                                        'Parah'  => 'bg-red-100 text-red-700',
                                    ];
                                    $badge = $badgeMap[$keparahan] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $badge }}">
                                    {{ $keparahan ?? '—' }}
                                </span>
                            </td>

                            {{-- Pertanyaan --}}
                            <td class="p-4 text-gray-700 max-w-sm leading-relaxed">
                                {{ $rule->pertanyaan }}
                            </td>

                            {{-- CF Gejala --}}
                            <td class="p-4 text-center">
                                @php
                                    $cf    = $rule->cf_gejala;
                                    $pct   = intval($cf * 100);
                                    $color = $cf >= 0.8 ? 'text-red-600' : ($cf >= 0.6 ? 'text-yellow-600' : 'text-green-600');
                                @endphp
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-bold text-sm {{ $color }}">{{ number_format($cf, 1) }}</span>
                                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full
                                            {{ $cf >= 0.8 ? 'bg-red-400' : ($cf >= 0.6 ? 'bg-yellow-400' : 'bg-green-400') }}"
                                             style="width: {{ $pct }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.symptom-rules.edit', $rule->id) }}"
                                       class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $rule->id }}, @js(\Illuminate\Support\Str::limit($rule->pertanyaan, 50)))"
                                        class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-3 block"></i>
                                Belum ada pertanyaan anamnesis. Klik <strong>"Tambah Pertanyaan"</strong> untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $rules->appends(request()->query())->links() }}
    </div>

</div>

{{-- ── MODAL HAPUS ── --}}
<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-red-100 transform transition-transform duration-200 scale-95"
         id="deleteModalCard">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-trash-alt text-red-500 text-xl"></i>
        </div>
        <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Pertanyaan?</h2>
        <p class="text-sm text-gray-500 text-center mb-1">
            Anda akan menghapus:
        </p>
        <p class="text-sm text-gray-700 text-center font-medium italic mb-5 px-4" id="deleteName"></p>
        <p class="text-xs text-gray-400 text-center mb-6">Data yang sudah dihapus tidak dapat dikembalikan.</p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 font-semibold">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 text-white hover:bg-red-600 font-semibold shadow">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(id, text) {
        document.getElementById('deleteName').textContent = '"' + text + '"';
        document.getElementById('deleteForm').action = '{{ url('/admin/symptom-rules') }}/' + id;

        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => document.getElementById('deleteModalCard').classList.replace('scale-95', 'scale-100'), 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        document.getElementById('deleteModalCard').classList.replace('scale-100', 'scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 150);
    }

    // Tutup modal jika klik backdrop
    document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });
</script>

@endsection
