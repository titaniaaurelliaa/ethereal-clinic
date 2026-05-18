@extends('layouts_admin.app')

@section('content')
    <div class="container">

        {{-- MAIN CONTENT --}}

        {{-- HEADER --}}
        <div class="flex flex-wrap justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Data Gejala Kulit</h1>
            
            <button onclick="openModal('addModal')" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition">
                + Tambah Gejala
            </button>
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

                <form action="{{ route('admin.symptoms.store') }}" method="POST" onsubmit="return validateAddForm()">
                    @csrf
                    <input type="hidden" name="page" id="addPage" value="{{ request()->get('page', 1) }}">

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
                    Edit Gejala
                </h2>

                <form id="editForm" method="POST" onsubmit="return validateEditForm()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">

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
            // Dapatkan page saat ini dari URL
            function getCurrentPage() {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get('page') || 1;
            }

            function openModal(id) {
                const modal = document.getElementById(id);

                if (!modal) {
                    console.error('Modal tidak ditemukan:', id);
                    return;
                }

                // Update page value untuk modal tambah
                if (id === 'addModal') {
                    const pageInput = document.getElementById('addPage');
                    if (pageInput) pageInput.value = getCurrentPage();
                    resetAddForm();
                }

                if (id === 'editModal') {
                    const pageInput = document.getElementById('editPage');
                    if (pageInput) pageInput.value = getCurrentPage();
                    resetEditForm();
                }

                if (id === 'deleteModal') {
                    const pageInput = document.getElementById('deletePage');
                    if (pageInput) pageInput.value = getCurrentPage();
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

                if (id === 'addModal') {
                    resetAddForm();
                }

                if (id === 'editModal') {
                    resetEditForm();
                }
            }

            function resetAddForm() {
                const name = document.getElementById('addName');
                const description = document.getElementById('addDescription');
                const error = document.getElementById('addError');

                if (name) {
                    name.value = '';
                    name.classList.remove('border-red-500');
                    name.classList.add('border');
                }

                if (description) {
                    description.value = '';
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
                const pageInput = document.getElementById('editPage');

                if (!modal || !editForm || !editName || !editDescription) {
                    console.error('Element edit modal tidak lengkap');
                    return;
                }

                resetEditForm();

                editName.value = name;
                editDescription.value = description;
                
                if (pageInput) pageInput.value = getCurrentPage();

                editForm.action = "{{ url('/admin/symptoms') }}/" + id;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function openDeleteModal(id, name) {
                const modal = document.getElementById('deleteModal');
                const deleteForm = document.getElementById('deleteForm');
                const deleteName = document.getElementById('deleteName');
                const pageInput = document.getElementById('deletePage');

                if (!modal || !deleteForm || !deleteName) {
                    console.error('Element delete modal tidak lengkap');
                    return;
                }

                deleteName.textContent = name;
                deleteForm.action = "{{ url('/admin/symptoms') }}/" + id;
                
                if (pageInput) pageInput.value = getCurrentPage();

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

@push('scripts')
@if(session('success'))
<script>
    // Notifikasi sederhana (alert bawaan)
    alert('{{ session('success') }}');
</script>
@endif
@endpush