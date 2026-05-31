@extends('layouts_admin.app')

@section('title', 'Pertanyaan Anamnesis')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Pertanyaan Gejala</h1>
        </div>
        <a href="{{ route('admin.symptom-rules.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition">
            + Tambah Pertanyaan
        </a>
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
        <form method="GET" action="{{ route('admin.symptom-rules.index') }}" class="flex flex-wrap gap-3">
            <select name="objek" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                <option value="">Semua Kondisi</option>
                @foreach ($objekList as $nama)
                    <option value="{{ $nama }}" {{ request('objek') === $nama ? 'selected' : '' }}>
                        {{ $nama }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="search" placeholder="Cari pertanyaan..." value="{{ request('search') }}"
                class="flex-1 min-w-[180px] px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search') || request('objek'))
                <a href="{{ route('admin.symptom-rules.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <h3 class="font-semibold text-gray-700">Daftar Pertanyaan Gejala</h3>
            <span class="text-xs text-gray-400">Total: {{ $rules->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Kondisi Kulit (KB)</th>
                        <th class="p-4 text-left">Keparahan</th>
                        <th class="p-4 text-left">Pertanyaan Anamnesis</th>
                        <th class="p-4 text-center w-28">CF Gejala</th>
                        <th class="p-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rules as $rule)
                        @php
                            $keparahan = $rule->knowledgeBase?->tingkat_keparahan;
                            $kepColor = [
                                'Ringan' => 'bg-green-100 text-green-600',
                                'Sedang' => 'bg-yellow-100 text-yellow-600',
                                'Parah'  => 'bg-red-100 text-red-600',
                            ][$keparahan] ?? 'bg-gray-100 text-gray-600';
                            $cf = $rule->cf_gejala;
                            $cfPct = intval($cf * 100);
                            $cfBar = $cf >= 0.8 ? 'bg-red-500' : ($cf >= 0.6 ? 'bg-yellow-500' : 'bg-green-500');
                        @endphp
                        <tr class="hover:bg-pink-50 transition">
                            <td class="p-4 text-gray-400 text-xs">
                                {{ $loop->iteration + ($rules->currentPage() - 1) * $rules->perPage() }}
                            </td>
                            <td class="p-4 font-medium text-gray-800">
                                {{ $rule->knowledgeBase?->nama_objek ?? '—' }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 {{ $kepColor }} rounded-lg text-xs font-semibold">
                                    {{ $keparahan ?? '—' }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-600 leading-relaxed max-w-xs">
                                {{ $rule->pertanyaan }}
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-bold text-sm text-pink-600">{{ number_format($cf, 1) }}</span>
                                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $cfBar }}" style="width:{{ $cfPct }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.symptom-rules.edit', $rule->id) }}"
                                        class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $rule->id }}, @js(\Illuminate\Support\Str::limit($rule->pertanyaan, 55)))"
                                        class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400">
                                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                Belum ada pertanyaan anamnesis
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $rules->appends(request()->query())->links() }}
    </div>

</div>

{{-- MODAL HAPUS --}}
<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-red-100">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-red-600 text-2xl font-bold">!</span>
        </div>
        <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Pertanyaan?</h2>
        <p class="text-sm text-gray-500 text-center mb-4">
            Apakah Anda yakin ingin menghapus pertanyaan:
        </p>
        <p id="deleteName" class="text-sm text-gray-700 text-center font-medium italic mb-6 px-2"></p>
        <p class="text-xs text-gray-400 text-center mb-6">Data yang sudah dihapus tidak dapat dikembalikan.</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="page" id="deletePage" value="{{ request()->get('page', 1) }}">
            <div class="flex justify-center gap-2">
                <button type="button" onclick="closeModal('deleteModal')"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 shadow">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('page') || 1;
    }

    function openDeleteModal(id, text) {
        document.getElementById('deleteName').textContent = '"' + text + '"';
        document.getElementById('deletePage').value = getCurrentPage();
        document.getElementById('deleteForm').action = '{{ url("/admin/symptom-rules") }}/' + id;
        
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

@endsection