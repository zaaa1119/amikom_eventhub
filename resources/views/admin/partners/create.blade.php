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

        <div class="mb-4 p-4 bg-slate-50 rounded-xl">
            <label class="flex items-center gap-2 font-bold mb-3">
                <input type="checkbox" name="create_login" value="1" id="create_login" onchange="document.getElementById('login_fields').classList.toggle('hidden', !this.checked)">
                Buatkan akun login untuk penyelenggara ini
            </label>

            <div id="login_fields" class="hidden space-y-3">
                <div>
                    <label class="block mb-1 text-sm">Email Login</label>
                    <input type="email" name="organizer_email" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block mb-1 text-sm">Password</label>
                    <input type="password" name="organizer_password" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block mb-1 text-sm">Konfirmasi Password</label>
                    <input type="password" name="organizer_password_confirmation" class="w-full border rounded-xl px-4 py-3">
                </div>
            </div>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">
            Simpan
        </button>

    </form>

</div>
@endsection