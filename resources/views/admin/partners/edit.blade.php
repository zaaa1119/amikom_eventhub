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

        <div class="mb-6 p-4 bg-slate-50 rounded-xl">
            @if($partner->organizerAccount)
            <p class="font-semibold text-sm text-slate-500 mb-1">Akun Penyelenggara</p>
            <p class="font-bold text-green-700">✓ Sudah punya akun ({{ $partner->organizerAccount->email }})</p>
            @else
            <label class="flex items-center gap-2 font-bold mb-3">
                <input type="checkbox" name="create_login" value="1" id="create_login" onchange="document.getElementById('login_fields').classList.toggle('hidden', !this.checked)">
                Buatkan akun login untuk penyelenggara ini
            </label>

            <div id="login_fields" class="hidden space-y-3">
                <div>
                    <label class="block mb-1 text-sm">Email Login</label>
                    <input type="email" name="organizer_email" class="w-full border rounded-xl px-4 py-3">
                </div>
                <div>
                    <label class="block mb-1 text-sm">Password</label>
                    <input type="password" name="organizer_password" class="w-full border rounded-xl px-4 py-3">
                </div>
                <div>
                    <label class="block mb-1 text-sm">Konfirmasi Password</label>
                    <input type="password" name="organizer_password_confirmation" class="w-full border rounded-xl px-4 py-3">
                </div>
            </div>
            @endif
        </div>

        <!-- Button -->
        <button type="submit"
            class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold">
            Update
        </button>

    </form>

</div>
@endsection