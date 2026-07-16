@extends('layouts.admin')

@section('page_title', 'Edit Pengurus')
@section('page_subtitle', 'Ubah data pengurus')

@section('content')

<div class="max-w-4xl">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">

        <div class="px-6 py-5 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">
                Form Edit Pengurus
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Perbarui data pengurus di bawah ini.
            </p>
        </div>

        <form action="{{ route('pengurus.update', $pengurus->id) }}" method="POST">
            @csrf
            @method('PUT')

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

                        @foreach($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}"
                                {{ old('jabatan_id', $pengurus->jabatan_id) == $jabatan->id ? 'selected' : '' }}>
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
                        value="{{ old('name', $pengurus->name) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $pengurus->description) }}</textarea>
                </div>

                <!-- Gaji -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Gaji
                    </label>

                    <input
                        type="number"
                        name="salary"
                        value="{{ old('salary', $pengurus->salary) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

            </div>

            <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-200 bg-slate-50 rounded-b-2xl">

                <a href="{{ route('pengurus.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 font-semibold transition">
                    Kembali
                </a>

                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold transition">
                    Update Data
                </button>

            </div>

        </form>

    </div>

</div>

@endsection