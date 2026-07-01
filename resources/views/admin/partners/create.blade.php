@extends('layouts.admin')

@section('page_title', 'Partners')
@section('page_subtitle', 'Kelola Partners di sini')
@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">

    <h1 class="text-2xl font-bold mb-6">Tambah Partner</h1>

    <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Nama Partner</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Logo Partner</label>
            <input type="file" name="logo" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">
            Simpan
        </button>

    </form>

</div>
@endsection