@extends('layouts.admin')

@section('page_title', 'Edit Partners')
@section('page_subtitle', 'Perbarui data partners')
@section('content')
<div class="bg-white rounded-2xl shadow-sm p-8">

    <form action="{{ route('admin.partners.update', $partner->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- Nama Partner -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Nama Partner
            </label>
            <input type="text"
                   name="name"
                   value="{{ $partner->name }}"
                   class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Logo Lama (preview) -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Logo Saat Ini
            </label>

            <img src="{{ asset('storage/' . $partner->logo_url) }}"
                 alt="Logo Partner"
                 class="h-20 rounded-xl border p-2 bg-gray-50">
        </div>

        <!-- Upload Logo Baru -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Ganti Logo (opsional)
            </label>

            <input type="file"
                   name="logo"
                   class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Button -->
        <button type="submit"
                class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold">
            Update
        </button>

    </form>

</div>
@endsection