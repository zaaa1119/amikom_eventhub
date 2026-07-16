@extends('layouts.admin')

@section('page_title', 'Tambah Pengurus')
@section('page_subtitle', 'Tambahkan data pengurus baru')

@section('content')

<div class="max-w-4xl">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">

        <div class="px-6 py-5 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">
                Form Tambah Pengurus
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Lengkapi data pengurus di bawah ini.
            </p>
        </div>

        <form action="{{ route('pengurus.store') }}" method="POST">
            @csrf

            <div class="p-6 space-y-6">

                @if ($errors->any())
                    <div class="rounded-xl bg-red-100 border border-red-200 text-red-700 p-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jabatan
                    </label>

                    <select
                        name="jabatan_id"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                        <option value="">-- Pilih Jabatan --</option>

                        @foreach($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}"
                                {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                {{ $jabatan->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Pengurus
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan nama pengurus">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan deskripsi">{{ old('description') }}</textarea>
                </div>

                <!-- Gaji -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Gaji
                    </label>

                    <input
                        type="number"
                        name="salary"
                        value="{{ old('salary') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: 5000000">
                </div>

            </div>

            <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-200 bg-slate-50 rounded-b-2xl">

                <a href="{{ route('pengurus.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 font-semibold transition">
                    Kembali
                </a>

                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition">
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>

@endsection