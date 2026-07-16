@extends('layouts.admin')

@section('page_title', 'Tambah Jabatan')
@section('page_subtitle', 'Tambahkan data jabatan baru')

@section('content')

<div class="max-w-3xl">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">

        <div class="px-6 py-5 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">
                Form Tambah Jabatan
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Lengkapi data jabatan di bawah ini.
            </p>
        </div>

        <form action="{{ route('jabatan.store') }}" method="POST">

            @csrf

            <div class="p-6">

                @if ($errors->any())
                    <div class="mb-6 rounded-xl bg-red-100 border border-red-200 text-red-700 p-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Jabatan
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh : Ketua Umum"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

            </div>

            <div class="flex justify-end gap-3 px-6 py-5 border-t border-slate-200 bg-slate-50 rounded-b-2xl">

                <a href="{{ route('jabatan.index') }}"
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