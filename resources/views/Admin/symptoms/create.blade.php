@extends('layouts_admin.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Tambah Gejala</h2>

    <form action="{{ route('symptoms.store') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Nama Gejala"
            class="w-full border p-2 mb-3 rounded">

        <textarea name="description" placeholder="Deskripsi"
            class="w-full border p-2 mb-3 rounded"></textarea>

        <button class="bg-pink-500 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>
@endsection