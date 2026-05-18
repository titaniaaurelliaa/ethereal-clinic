@extends('layouts_admin.app')

@section('content')
    <div class="container">

        {{-- HEADER --}}
        <div class="flex flex-wrap justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Data Produk</h1>
            
            <button onclick="openModal('addModal')" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition">
                + Tambah Produk
            </button>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                <h3 class="font-semibold text-gray-700">Daftar Produk</h3>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.dataproduk.index') }}" class="flex gap-2">
                        <select name="category" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                            <option value="">Semua Kategori</option>
                            <option value="skincare" {{ request('category') == 'skincare' ? 'selected' : '' }}>Skincare</option>
                            <option value="makeup" {{ request('category') == 'makeup' ? 'selected' : '' }}>Makeup</option>
                            <option value="obat" {{ request('category') == 'obat' ? 'selected' : '' }}>Obat</option>
                            <option value="krim" {{ request('category') == 'krim' ? 'selected' : '' }}>Krim</option>
                            <option value="sabun" {{ request('category') == 'sabun' ? 'selected' : '' }}>Sabun</option>
                            <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                            class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                        <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        @if(request('search') || request('category'))
                            <a href="{{ route('admin.dataproduk.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Gambar</th>
                            <th class="p-4 text-left">Nama Produk</th>
                            <th class="p-4 text-left">Brand</th>
                            <th class="p-4 text-left">Kategori</th>
                            <th class="p-4 text-left">Deskripsi</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($dataproduk as $item)
                            <tr class="hover:bg-pink-50 transition">
                                <td class="p-4">
                                    <span class="bg-pink-100 text-pink-600 px-2 py-1 rounded-md text-xs font-semibold">
                                        P{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    @if($item->image_path && file_exists(public_path($item->image_path)))
                                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No img</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="p-4 font-medium text-gray-800">
                                    {{ $item->name }}
                                </td>

                                <td class="p-4 text-gray-600">
                                    {{ $item->brand }}
                                </td>

                                <td class="p-4">
                                    @php
                                        $categoryLabels = [
                                            'skincare' => 'Skincare',
                                            'makeup' => 'Makeup',
                                            'obat' => 'Obat',
                                            'krim' => 'Krim',
                                            'sabun' => 'Sabun',
                                            'lainnya' => 'Lainnya'
                                        ];
                                        $categoryColor = [
                                            'skincare' => 'bg-green-100 text-green-600',
                                            'makeup' => 'bg-purple-100 text-purple-600',
                                            'obat' => 'bg-red-100 text-red-600',
                                            'krim' => 'bg-blue-100 text-blue-600',
                                            'sabun' => 'bg-yellow-100 text-yellow-600',
                                            'lainnya' => 'bg-gray-100 text-gray-600'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 {{ $categoryColor[$item->category] ?? 'bg-gray-100 text-gray-600' }} rounded-md text-xs">
                                        {{ $categoryLabels[$item->category] ?? $item->category }}
                                    </span>
                                </td>

                                <td class="p-4 text-gray-500 max-w-xs">
                                    {{ \Illuminate\Support\Str::limit($item->description, 60) }}
                                </td>

                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button type="button"
                                            onclick="openEditModal({{ $item->id }}, @js($item->name), @js($item->brand), @js($item->description), @js($item->category), @js($item->image_path))"
                                            class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <button type="button"
                                            onclick="openDeleteModal({{ $item->id }}, @js($item->name))"
                                            class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-400">
                                    <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                    Data produk belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $dataproduk->appends(request()->query())->links() }}
        </div>

    </div>

    {{-- MODAL TAMBAH --}}
    <div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.35);">
        <div class="bg-white p-6 rounded-xl w-[500px] shadow-lg max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold mb-4">Tambah Produk</h2>

            <form action="{{ route('admin.dataproduk.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateAddForm()">
                @csrf
                <input type="hidden" name="page" id="addPage" value="{{ request()->get('page', 1) }}">

                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Nama Produk *</label>
                        <input type="text" id="addName" name="name" placeholder="Masukkan nama produk"
                            class="w-full mt-1 border p-2 rounded focus:ring-2 focus:ring-pink-400 outline-none">
                    </div>

                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Brand *</label>
                        <input type="text" id="addBrand" name="brand" placeholder="Masukkan brand produk"
                            class="w-full mt-1 border p-2 rounded focus:ring-2 focus:ring-pink-400 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Kategori *</label>
                        <select id="addCategory" name="category"
                            class="w-full mt-1 border p-2 rounded focus:ring-2 focus:ring-pink-400 outline-none">
                            <option value="">Pilih Kategori</option>
                            <option value="skincare">Skincare</option>
                            <option value="makeup">Makeup</option>
                            <option value="obat">Obat</option>
                            <option value="krim">Krim</option>
                            <option value="sabun">Sabun</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Prioritas</label>
                        <input type="number" id="addPriority" name="priority" placeholder="Prioritas (1-10)" min="1" max="10"
                            class="w-full mt-1 border p-2 rounded focus:ring-2 focus:ring-pink-400 outline-none">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-sm text-gray-600">Deskripsi *</label>
                    <textarea id="addDescription" name="description" placeholder="Masukkan deskripsi produk"
                        class="w-full mt-1 border p-2 rounded focus:ring-2 focus:ring-pink-400 outline-none" rows="3"></textarea>
                </div>

                {{-- PERBAIKAN: Upload Gambar dengan Button yang Jelas --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-pink-400 transition-colors cursor-pointer" id="uploadAreaAdd">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="addImage" class="relative cursor-pointer bg-white rounded-md font-medium text-pink-600 hover:text-pink-500 focus-within:outline-none">
                                    <span>Klik untuk upload</span>
                                    <input id="addImage" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImageAdd(event)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, JPEG, GIF (Max 2MB)
                            </p>
                        </div>
                    </div>
                    
                    {{-- Preview gambar sebelum upload --}}
                    <div id="addImagePreview" class="hidden mt-3">
                        <p class="text-xs text-gray-500 mb-1">Preview gambar:</p>
                        <img id="addImagePreviewImg" src="#" alt="Preview" class="w-24 h-24 object-cover rounded-lg border">
                        <button type="button" onclick="removeImageAdd()" class="text-xs text-red-500 mt-1 hover:text-red-700">Hapus gambar</button>
                    </div>
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
        <div class="bg-white rounded-2xl w-[500px] p-6 shadow-xl border border-pink-100 max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Edit Produk</h2>

            <form id="editForm" method="POST" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                @csrf
                @method('PUT')
                <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">

                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Nama Produk *</label>
                        <input type="text" id="editName" name="name"
                            class="w-full mt-1 border border-gray-200 p-2 rounded-lg focus:ring-2 focus:ring-pink-400 outline-none">
                    </div>

                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Brand *</label>
                        <input type="text" id="editBrand" name="brand"
                            class="w-full mt-1 border border-gray-200 p-2 rounded-lg focus:ring-2 focus:ring-pink-400 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Kategori *</label>
                        <select id="editCategory" name="category"
                            class="w-full mt-1 border border-gray-200 p-2 rounded-lg focus:ring-2 focus:ring-pink-400 outline-none">
                            <option value="">Pilih Kategori</option>
                            <option value="skincare">Skincare</option>
                            <option value="makeup">Makeup</option>
                            <option value="obat">Obat</option>
                            <option value="krim">Krim</option>
                            <option value="sabun">Sabun</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="text-sm text-gray-600">Prioritas</label>
                        <input type="number" id="editPriority" name="priority" placeholder="Prioritas (1-10)" min="1" max="10"
                            class="w-full mt-1 border border-gray-200 p-2 rounded-lg focus:ring-2 focus:ring-pink-400 outline-none">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-sm text-gray-600">Deskripsi *</label>
                    <textarea id="editDescription" name="description"
                        class="w-full mt-1 border border-gray-200 p-2 rounded-lg focus:ring-2 focus:ring-pink-400 outline-none" rows="3"></textarea>
                </div>

                {{-- PERBAIKAN: Upload Gambar dengan Button yang Jelas --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                    
                    {{-- Gambar saat ini --}}
                    <div id="currentImageContainer" class="mb-3 hidden">
                        <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                        <div class="relative inline-block">
                            <img id="currentImage" src="#" alt="Current product image" class="w-24 h-24 object-cover rounded-lg border">
                            <button type="button" onclick="removeCurrentImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                ×
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-pink-400 transition-colors cursor-pointer" id="uploadAreaEdit">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="editImage" class="relative cursor-pointer bg-white rounded-md font-medium text-pink-600 hover:text-pink-500 focus-within:outline-none">
                                    <span>Klik untuk upload gambar baru</span>
                                    <input id="editImage" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImageEdit(event)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, JPEG, GIF (Max 2MB)
                            </p>
                            <p class="text-xs text-gray-400">Kosongkan jika tidak ingin mengubah gambar</p>
                        </div>
                    </div>
                    
                    {{-- Preview gambar baru --}}
                    <div id="editImagePreview" class="hidden mt-3">
                        <p class="text-xs text-gray-500 mb-1">Preview gambar baru:</p>
                        <img id="editImagePreviewImg" src="#" alt="Preview" class="w-24 h-24 object-cover rounded-lg border">
                        <button type="button" onclick="removeImageEdit()" class="text-xs text-red-500 mt-1 hover:text-red-700">Batal</button>
                    </div>
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
                <span class="text-red-600 text-2xl font-bold">!</span>
            </div>
            <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Produk?</h2>
            <p class="text-sm text-gray-500 text-center mb-6">
                Apakah Anda yakin ingin menghapus produk
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
        function getCurrentPage() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('page') || 1;
        }

        function openModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;

            if (id === 'addModal') {
                document.getElementById('addPage').value = getCurrentPage();
                resetAddForm();
            }
            if (id === 'editModal') {
                document.getElementById('editPage').value = getCurrentPage();
                // HAPUS resetEditForm() dari sini!
            }
            if (id === 'deleteModal') {
                document.getElementById('deletePage').value = getCurrentPage();
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            if (id === 'addModal') resetAddForm();
            if (id === 'editModal') {
                // Kosongkan form hanya saat modal ditutup
                document.getElementById('editName').value = '';
                document.getElementById('editBrand').value = '';
                document.getElementById('editCategory').value = '';
                document.getElementById('editDescription').value = '';
                document.getElementById('editImage').value = '';
                document.getElementById('currentImageContainer').classList.add('hidden');
                const error = document.getElementById('editError');
                if (error) error.classList.add('hidden');
            }
        }

        function resetAddForm() {
            document.getElementById('addName').value = '';
            document.getElementById('addBrand').value = '';
            document.getElementById('addDescription').value = '';
            document.getElementById('addCategory').value = '';
            document.getElementById('addImage').value = '';
            const error = document.getElementById('addError');
            if (error) error.classList.add('hidden');
        }

        function validateAddForm() {
            const name = document.getElementById('addName');
            const brand = document.getElementById('addBrand');
            const category = document.getElementById('addCategory');
            const description = document.getElementById('addDescription');
            const error = document.getElementById('addError');

            let messages = [];
            name.classList.remove('border-red-500');
            brand.classList.remove('border-red-500');
            category.classList.remove('border-red-500');
            description.classList.remove('border-red-500');

            if (name.value.trim() === '') {
                name.classList.add('border-red-500');
                messages.push('Nama produk wajib diisi.');
            }
            if (brand.value.trim() === '') {
                brand.classList.add('border-red-500');
                messages.push('Brand wajib diisi.');
            }
            if (category.value === '') {
                category.classList.add('border-red-500');
                messages.push('Kategori wajib dipilih.');
            }
            if (description.value.trim() === '') {
                description.classList.add('border-red-500');
                messages.push('Deskripsi wajib diisi.');
            }

            if (messages.length > 0) {
                error.innerHTML = messages.join('<br>');
                error.classList.remove('hidden');
                return false;
            }
            return true;
        }

        function validateEditForm() {
            const name = document.getElementById('editName');
            const brand = document.getElementById('editBrand');
            const category = document.getElementById('editCategory');
            const description = document.getElementById('editDescription');
            const error = document.getElementById('editError');

            let messages = [];
            name.classList.remove('border-red-500');
            brand.classList.remove('border-red-500');
            category.classList.remove('border-red-500');
            description.classList.remove('border-red-500');

            if (name.value.trim() === '') {
                name.classList.add('border-red-500');
                messages.push('Nama produk wajib diisi.');
            }
            if (brand.value.trim() === '') {
                brand.classList.add('border-red-500');
                messages.push('Brand wajib diisi.');
            }
            if (category.value === '') {
                category.classList.add('border-red-500');
                messages.push('Kategori wajib dipilih.');
            }
            if (description.value.trim() === '') {
                description.classList.add('border-red-500');
                messages.push('Deskripsi wajib diisi.');
            }

            if (messages.length > 0) {
                error.innerHTML = messages.join('<br>');
                error.classList.remove('hidden');
                return false;
            }
            return true;
        }

        function openEditModal(id, name, brand, description, category, imagePath) {
            const editForm = document.getElementById('editForm');

            // Langsung isi form tanpa reset terlebih dahulu
            document.getElementById('editName').value = name;
            document.getElementById('editBrand').value = brand;
            document.getElementById('editDescription').value = description;
            document.getElementById('editCategory').value = category;
            document.getElementById('editPage').value = getCurrentPage();

            // Tampilkan gambar saat ini jika ada
            if (imagePath && imagePath !== 'null') {
                const imageUrl = imagePath.startsWith('/') ? imagePath : '/' + imagePath;
                document.getElementById('currentImage').src = imageUrl;
                document.getElementById('currentImageContainer').classList.remove('hidden');
            } else {
                document.getElementById('currentImageContainer').classList.add('hidden');
            }

            // Reset field upload gambar
            document.getElementById('editImage').value = '';

            editForm.action = "{{ url('/admin/dataproduk') }}/" + id;
            openModal('editModal');
        }

        function openDeleteModal(id, name) {
            const deleteForm = document.getElementById('deleteForm');

            document.getElementById('deleteName').textContent = name;
            document.getElementById('deletePage').value = getCurrentPage();
            deleteForm.action = "{{ url('/admin/dataproduk') }}/" + id;

            openModal('deleteModal');
        }
    </script>

    @push('styles')
    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
    </style>
    @endpush
@endsection