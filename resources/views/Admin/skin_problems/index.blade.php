@extends('layouts_admin.app')

@section('title', 'Data Masalah Kulit')

@section('content')
<div class="container">
    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Data Masalah Kulit</h1>

        <button onclick="openModal('addModal')" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition">
            + Tambah Masalah Kulit
        </button>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-semibold text-gray-700">Daftar Masalah Kulit</h3>
            <div class="flex gap-2">
                <form method="GET" action="{{ route('admin.skin-problems.index') }}" class="flex gap-2">
                    {{-- Filter Berdasarkan Tingkat Keparahan --}}
                    <select name="severity" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#9B6B6C]">
                        <option value="">Tingkat Keparahan</option>
                        <option value="ringan" {{ request('severity') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="sedang" {{ request('severity') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="berat" {{ request('severity') == 'berat' ? 'selected' : '' }}>Berat</option>
                    </select>

                    {{-- Input Pencarian Nama Masalah --}}
                    <input type="text" name="search" placeholder="Cari masalah kulit..." value="{{ request('search') }}"
                        class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#9B6B6C]">

                    {{-- Tombol Cari --}}
                    <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
                        Cari
                    </button>

                    {{-- Tombol Reset (Hanya muncul jika sedang mencari/filter) --}}
                    @if(request('search') || request('severity'))
                        <a href="{{ route('admin.skin-problems.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">Kode</th>
                        <th class="p-4 text-left">Nama Masalah Kulit</th>
                        <th class="p-4 text-left">Deskripsi Singkat</th>
                        <th class="p-4 text-left">Tingkat Keparahan</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($problems as $item)
                        <tr class="hover:bg-pink-50 transition">
                            <td class="p-4">
                                <span class="bg-pink-100 text-pink-600 px-2 py-1 rounded-md text-xs font-semibold">
                                    P{{ str_pad($loop->iteration + ($problems->firstItem() - 1), 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <td class="p-4 font-medium text-gray-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-[#9B6B6C]">
                                        <i class="fas fa-virus text-xs"></i>
                                    </div>
                                    {{ $item->name }}
                                </div>
                            </td>

                            <td class="p-4 text-gray-500 max-w-xs">
                                {{ \Illuminate\Support\Str::limit($item->description, 70) }}
                            </td>

                            <td class="p-4">
                                @php
                                    $badgeColor = [
                                        'ringan' => 'bg-blue-100 text-blue-600',
                                        'sedang' => 'bg-yellow-100 text-yellow-600',
                                        'berat'  => 'bg-red-100 text-red-600'
                                    ][$item->severity_level] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="px-3 py-1 {{ $badgeColor }} rounded-full text-[10px] font-bold uppercase">
                                    ● {{ $item->severity_level }}
                                </span>
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, @js($item->name), @js($item->severity_level), @js($item->description))"
                                        class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition">
                                        Edit
                                    </button>

                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, @js($item->name))"
                                        class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-400">
                                Data masalah kulit belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $problems->links() }}
    </div>

</div>

{{-- TOAST NOTIFICATION --}}
@if(session('success'))
<div id="toastNotification" class="fixed bottom-4 right-4 z-50 animate-slide-in">
    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

{{-- MODAL TAMBAH --}}
<div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.4);">
    <div class="bg-white p-6 rounded-xl w-[500px] shadow-lg max-h-[90vh] overflow-y-auto">
        <h2 class="text-lg font-bold mb-4 text-gray-800">Tambah Masalah Kulit</h2>

        <form action="{{ route('admin.skin-problems.store') }}" method="POST" onsubmit="return validateForm('add')">
            @csrf
            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-600">Nama Masalah Kulit *</label>
                <input type="text" id="addName" name="name" placeholder="Contoh: Jerawat Batu"
                    class="w-full mt-1 border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-[#9B6B6C] outline-none">
            </div>

            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-600">Tingkat Keparahan *</label>
                <select id="addSeverity" name="severity_level"
                    class="w-full mt-1 border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-[#9B6B6C] outline-none">
                    <option value="">Pilih Tingkat</option>
                    <option value="ringan">Ringan</option>
                    <option value="sedang">Sedang</option>
                    <option value="berat">Berat</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-600">Deskripsi *</label>
                <textarea id="addDescription" name="description" placeholder="Masukkan penjelasan masalah kulit..."
                    class="w-full mt-1 border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-[#9B6B6C] outline-none" rows="4"></textarea>
            </div>

            <p id="addError" class="hidden text-xs text-red-500 mb-4"></p>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-[#9B6B6C] text-white rounded-lg hover:opacity-90 transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.4);">
    <div class="bg-white rounded-2xl w-[500px] p-6 shadow-xl border border-gray-100 max-h-[90vh] overflow-y-auto">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Edit Masalah Kulit</h2>

        <form id="editForm" method="POST" onsubmit="return validateForm('edit')">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-600">Nama Masalah Kulit *</label>
                <input type="text" id="editName" name="name"
                    class="w-full mt-1 border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
            </div>

            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-600">Tingkat Keparahan *</label>
                <select id="editSeverity" name="severity_level"
                    class="w-full mt-1 border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <option value="ringan">Ringan</option>
                    <option value="sedang">Sedang</option>
                    <option value="berat">Berat</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-600">Deskripsi *</label>
                <textarea id="editDescription" name="description"
                    class="w-full mt-1 border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" rows="4"></textarea>
            </div>

            <p id="editError" class="hidden text-xs text-red-500 mb-4"></p>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 shadow transition">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div id="deleteModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.4);">
    <div class="bg-white rounded-2xl w-96 p-6 shadow-xl">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600 text-2xl font-bold italic">
            !
        </div>
        <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Data?</h2>
        <p class="text-sm text-gray-500 text-center mb-6">
            Yakin ingin menghapus <span id="deleteName" class="font-semibold text-gray-700"></span>?
            Tindakan ini tidak bisa dibatalkan.
        </p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center gap-2">
                <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 shadow transition">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        // Sembunyikan pesan error jika ada
        if(id === 'addModal') document.getElementById('addError').classList.add('hidden');
        if(id === 'editModal') document.getElementById('editError').classList.add('hidden');
    }

    function openEditModal(id, name, severity, description) {
        const form = document.getElementById('editForm');
        document.getElementById('editName').value = name;
        document.getElementById('editSeverity').value = severity;
        document.getElementById('editDescription').value = description;

        form.action = `/admin/skin-problems/${id}`;
        openModal('editModal');
    }

    function openDeleteModal(id, name) {
        const form = document.getElementById('deleteForm');
        document.getElementById('deleteName').textContent = name;
        form.action = `/admin/skin-problems/${id}`;
        openModal('deleteModal');
    }

    function validateForm(type) {
        const name = document.getElementById(`${type}Name`).value;
        const severity = document.getElementById(`${type}Severity`).value;
        const description = document.getElementById(`${type}Description`).value;
        const errorField = document.getElementById(`${type}Error`);

        if (!name || !severity || !description) {
            errorField.textContent = "Semua field wajib diisi!";
            errorField.classList.remove('hidden');
            return false;
        }
        return true;
    }

    // Auto-hide toast
    @if(session('success'))
    setTimeout(() => {
        const toast = document.getElementById('toastNotification');
        if (toast) {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s';
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);
    @endif
</script>

<style>
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-slide-in { animation: slideIn 0.3s ease-out; }
</style>

@endsection
