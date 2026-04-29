@extends('layouts_admin.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Edit Gejala</h2>

    <form action="{{ route('symptoms.update', $symptom->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $symptom->name }}"
            class="w-full border p-2 mb-3 rounded">

        <textarea name="description"
            class="w-full border p-2 mb-3 rounded">{{ $symptom->description }}</textarea>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>
</div>
@endsection