@extends('layouts.admin')

@section('page_title', 'Categories')
@section('page_subtitle', 'Kelola kategori event di sini')
@section('content')
<div class="mb-4 flex justify-between items-center">

    <!-- SEARCH -->
    <form method="GET"
        action="{{ route('admin.categories.index') }}"
        class="flex gap-2">

        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari kategori..."
            class="border px-4 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <button type="submit"
            class="px-4 py-2 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition">
            Search
        </button>

    </form>

    <!-- BUTTON TAMBAH -->
    <a href="{{ route('admin.categories.create') }}"
        class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-semibold">
        + Tambah Category
    </a>

</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-100">
            <tr>
                <th class="p-4 text-left">No</th>
                <th class="p-4 text-left">Nama Category</th>
                <th class="p-4 text-left">Slug</th>
                <th class="p-4 text-left">Jumlah Event</th>
                <th class="p-4 text-left">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @if($categories->count() > 0)

            @foreach($categories as $category)
            <tr class="border-t">

                <td class="p-4">
                    {{ $loop->iteration }}
                </td>

                <td class="p-4">
                    {{ $category->name }}
                </td>

                <td class="p-4">
                    {{ $category->slug }}
                </td>

                <td class="p-4">
                    {{ $category->events_count }}
                </td>

                <td class="p-4 flex gap-2">
                    <div class="flex gap-2">
                        <!-- Catatan Modul: Deretan tombol fitur modifikasi (U dan D) akan ditanamkan pada tahap berikutnya -->
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                    </div>



                </td>

            </tr>
            @endforeach
            @else

            <tr>
                <td colspan="5" class="text-center p-6 text-gray-500">
                    🚫 Kategori tidak ditemukan
                </td>
            </tr>

            @endif

        </tbody>

    </table>

</div>

@endsection