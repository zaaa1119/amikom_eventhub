@extends('layouts.admin')

@section('page_title', 'Data Jabatan')
@section('page_subtitle', 'Kelola data jabatan')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="flex justify-between items-center p-6 border-b border-slate-200">

        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Data Jabatan
            </h2>
            <p class="text-sm text-slate-500">
                Daftar seluruh jabatan yang tersedia.
            </p>
        </div>

        <a href="{{ route('jabatan.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-3 rounded-xl transition">
            + Tambah Jabatan
        </a>

    </div>

    @if(session('success'))
        <div class="mx-6 mt-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr class="text-left text-slate-700">

                    <th class="px-6 py-4 font-semibold">No</th>
                    <th class="px-6 py-4 font-semibold">Nama Jabatan</th>
                    <th class="px-6 py-4 font-semibold">Created By</th>
                    <th class="px-6 py-4 font-semibold">Updated By</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($jabatans as $index => $jabatan)

                    <tr class="border-t hover:bg-slate-50 transition">

                        <td class="px-6 py-4">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-slate-700">
                            {{ $jabatan->name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $jabatan->created_by }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $jabatan->updated_by ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('jabatan.edit',$jabatan->id) }}"
                                    class="bg-amber-400 hover:bg-amber-500 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    Edit
                                </a>

                                <form action="{{ route('jabatan.destroy',$jabatan->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-10 text-slate-500">
                            Belum ada data jabatan.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection