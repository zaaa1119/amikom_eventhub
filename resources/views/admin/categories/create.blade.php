@extends('layouts.admin')

@section('page_title', 'Tambah Category')

@section('page_subtitle', 'Tambahkan kategori event baru')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-8">

    <form action="{{ route('admin.categories.store') }}" method="POST">

        @csrf

        <div class="mb-6">

            <label class="block mb-2 font-semibold">
                Nama Category
            </label>

            <input type="text"
                name="name"
                class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Masukkan nama category">

        </div>

        <button type="submit"
            class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold">
            Simpan
        </button>

    </form>

</div>

@endsection