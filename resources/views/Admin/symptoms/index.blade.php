@extends('layouts_admin.app')

@section('content')
    <div class="container">


        {{-- MAIN CONTENT --}}

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Data Gejala Kulit</h1>
        </div>
        <div class="flex justify-end mb-6">
            <button onclick="openModal('addModal')" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow">
                + Tambah Gejala
            </button>
        </div>


        {{-- CARD STATS --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-pink-100 p-4 rounded-xl">
                <p class="text-sm text-gray-600">TOTAL GEJALA</p>
                <h2 class="text-xl font-bold">{{ $symptoms->total() }}</h2>
            </div>
            <div class="bg-pink-100 p-4 rounded-xl">
                <p class="text-sm text-gray-600">UPDATE TERAKHIR</p>
                <h2 class="text-xl font-bold">Hari Ini</h2>
            </div>
            <div class="bg-pink-100 p-4 rounded-xl">
                <p class="text-sm text-gray-600">STATUS</p>
                <h2 class="text-xl font-bold">Aktif</h2>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                <h3 class="font-semibold text-gray-700">Daftar Gejala</h3>
                <input type="text" placeholder="Cari gejala..."
                    class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
            </div>

            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Nama Gejala</th>
                        <th class="p-4 text-left">Deskripsi</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($symptoms as $item)
                        <tr class="hover:bg-pink-50 transition">

                            <td class="p-4">
                                <span class="bg-pink-100 text-pink-600 px-2 py-1 rounded-md text-xs font-semibold">
                                    G{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <td class="p-4 font-medium text-gray-800">
                                {{ $item->name }}
                            </td>

                            <td class="p-4 text-gray-500">
                                {{ \Illuminate\Support\Str::limit($item->description, 60) }}
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">

                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, @js($item->name), @js($item->description))"
                                        class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition">
                                        Edit
                                    </button>

                                    <form action="{{ route('symptoms.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus data?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            onclick="openDeleteModal({{ $item->id }}, @js($item->name))"
                                            class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-400">
                                Data gejala belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MODAL TAMBAH --}}
        <div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50"
            style="background-color: rgba(0, 0, 0, 0.35);">

            <div class="bg-white p-6 rounded-xl w-96 shadow-lg">
                <h2 class="text-lg font-bold mb-4">Tambah Gejala</h2>

                <form action="{{ route('symptoms.store') }}" method="POST" onsubmit="return validateAddForm()">
                    @csrf

                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Nama Gejala</label>
                        <input type="text" id="addName" name="name" placeholder="Masukkan nama gejala"
                            class="w-full mt-1 border p-2 rounded focus:ring-2 focus:ring-pink-400 outline-none">
                    </div>

                    <div class="mb-2">
                        <label class="text-sm text-gray-600">Deskripsi</label>
                        <textarea id="addDescription" name="description" placeholder="Masukkan deskripsi"
                            class="w-full mt-1 border p-2 rounded focus:ring-2 focus:ring-pink-400 outline-none"></textarea>
                    </div>

                    <p id="addError" class="hidden text-sm text-red-500 mb-3"></p>

                    <div class="flex justify-end gap-2 mt-3">
                        <button type="button" onclick="closeModal('addModal')" class="px-3 py-1 bg-gray-200 rounded">
                            Batal
                        </button>

                        <button type="submit" class="px-3 py-1 bg-pink-500 text-white rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div id="editModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">

            <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-pink-100">

                <h2 class="text-lg font-bold text-gray-800 mb-4">
                    ✏️ Edit Gejala
                </h2>

                <form id="editForm" method="POST" onsubmit="return validateEditForm()">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Nama Gejala</label>
                        <input type="text" id="editName" name="name"
                            class="w-full mt-1 border border-gray-200 p-2 rounded-lg focus:ring-2 focus:ring-pink-400 outline-none">
                    </div>

                    <div class="mb-2">
                        <label class="text-sm text-gray-600">Deskripsi</label>
                        <textarea id="editDescription" name="description"
                            class="w-full mt-1 border border-gray-200 p-2 rounded-lg focus:ring-2 focus:ring-pink-400 outline-none"></textarea>
                    </div>

                    <p id="editError" class="hidden text-sm text-red-500 mt-2 mb-3"></p>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal('editModal')"
                            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">
                            Batal
                        </button>

                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600 shadow">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- MODAL HAPUS --}}
        <div id="deleteModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">

            <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-red-100">

                <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-red-600 text-2xl">!</span>
                </div>

                <h2 class="text-lg font-bold text-gray-800 text-center mb-2">
                    Hapus Gejala?
                </h2>

                <p class="text-sm text-gray-500 text-center mb-6">
                    Apakah Anda yakin ingin menghapus gejala
                    <span id="deleteName" class="font-semibold text-gray-700"></span>?
                    Data yang sudah dihapus tidak dapat dikembalikan.
                </p>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')

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
            function openModal(id) {
                const modal = document.getElementById(id);

                if (!modal) {
                    console.error('Modal tidak ditemukan:', id);
                    return;
                }

                // Reset form dan warning ketika modal tambah dibuka
                if (id === 'addModal') {
                    resetAddForm();
                }

                // Reset warning ketika modal edit dibuka
                if (id === 'editModal') {
                    resetEditForm();
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal(id) {
                const modal = document.getElementById(id);

                if (!modal) {
                    console.error('Modal tidak ditemukan:', id);
                    return;
                }

                modal.classList.add('hidden');
                modal.classList.remove('flex');

                // Reset warning ketika modal tambah ditutup
                if (id === 'addModal') {
                    resetAddForm();
                }

                // Reset warning ketika modal edit ditutup
                if (id === 'editModal') {
                    resetEditForm();
                }
            }

            function resetAddForm() {
                const name = document.getElementById('addName');
                const description = document.getElementById('addDescription');
                const error = document.getElementById('addError');

                if (name) {
                    name.classList.remove('border-red-500');
                    name.classList.add('border');
                }

                if (description) {
                    description.classList.remove('border-red-500');
                    description.classList.add('border');
                }

                if (error) {
                    error.classList.add('hidden');
                    error.textContent = '';
                }
            }

            function validateAddForm() {
                const name = document.getElementById('addName');
                const description = document.getElementById('addDescription');
                const error = document.getElementById('addError');

                let isValid = true;
                let messages = [];

                name.classList.remove('border-red-500');
                description.classList.remove('border-red-500');
                error.classList.add('hidden');
                error.textContent = '';

                if (name.value.trim() === '') {
                    name.classList.add('border-red-500');
                    messages.push('Nama gejala wajib diisi.');
                    isValid = false;
                }

                if (description.value.trim() === '') {
                    description.classList.add('border-red-500');
                    messages.push('Deskripsi wajib diisi.');
                    isValid = false;
                }

                if (!isValid) {
                    error.innerHTML = messages.join('<br>');
                    error.classList.remove('hidden');
                    return false;
                }

                return true;
            }

            function resetEditForm() {
                const name = document.getElementById('editName');
                const description = document.getElementById('editDescription');
                const error = document.getElementById('editError');

                if (name) {
                    name.classList.remove('border-red-500');
                    name.classList.add('border-gray-200');
                }

                if (description) {
                    description.classList.remove('border-red-500');
                    description.classList.add('border-gray-200');
                }

                if (error) {
                    error.classList.add('hidden');
                    error.textContent = '';
                }
            }

            function validateEditForm() {
                const name = document.getElementById('editName');
                const description = document.getElementById('editDescription');
                const error = document.getElementById('editError');

                let isValid = true;
                let messages = [];

                name.classList.remove('border-red-500');
                description.classList.remove('border-red-500');
                error.classList.add('hidden');
                error.textContent = '';

                if (name.value.trim() === '') {
                    name.classList.add('border-red-500');
                    messages.push('Nama gejala wajib diisi.');
                    isValid = false;
                }

                if (description.value.trim() === '') {
                    description.classList.add('border-red-500');
                    messages.push('Deskripsi wajib diisi.');
                    isValid = false;
                }

                if (!isValid) {
                    error.innerHTML = messages.join('<br>');
                    error.classList.remove('hidden');
                    return false;
                }

                return true;
            }

            function openEditModal(id, name, description) {
                const modal = document.getElementById('editModal');
                const editForm = document.getElementById('editForm');
                const editName = document.getElementById('editName');
                const editDescription = document.getElementById('editDescription');

                if (!modal || !editForm || !editName || !editDescription) {
                    console.error('Element edit modal tidak lengkap');
                    return;
                }

                resetEditForm();

                editName.value = name;
                editDescription.value = description;

                editForm.action = "{{ url('/admin/symptoms') }}/" + id;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function openDeleteModal(id, name) {
                const modal = document.getElementById('deleteModal');
                const deleteForm = document.getElementById('deleteForm');
                const deleteName = document.getElementById('deleteName');

                if (!modal || !deleteForm || !deleteName) {
                    console.error('Element delete modal tidak lengkap');
                    return;
                }

                deleteName.textContent = name;
                deleteForm.action = "{{ url('/admin/symptoms') }}/" + id;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        </script>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $symptoms->links() }}
        </div>

    </div>
@endsection
