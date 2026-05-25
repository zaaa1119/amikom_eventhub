@extends('layouts.admin')

@section('page_title', 'Partners')
@section('page_subtitle', 'Kelola Partners di sini')
@section('content')
<div class="mb-4 flex justify-between items-center">

    <!-- SEARCH -->
    <form method="GET"
        action="{{ route('admin.partners.index') }}"
        class="flex gap-2">

        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari partner..."
            class="border px-4 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <button type="submit"
            class="px-4 py-2 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition">
            Search
        </button>

    </form>

    <!-- BUTTON TAMBAH -->
    <a href="{{ route('admin.partners.create') }}"
        class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-semibold">
        + Tambah Partner
    </a>

</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-100">
            <tr>
                <th class="p-4 text-left">No</th>
                <th class="p-4 text-left">Nama Partner</th>
                <th class="p-4 text-left">Logo</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @if($partners->count() > 0)

            @foreach($partners as $partner)
            <tr class="border-t">

                <td class="p-4">
                    {{ $loop->iteration }}
                </td>

                <td class="p-4 font-semibold">
                    {{ $partner->name }}
                </td>

                <td class="p-4">
                    <img src="{{ asset('storage/' . $partner->logo_url) }}"
                        class="h-12 w-12 object-cover rounded-lg border">
                </td>

                <td class="p-4">
                    <div class="flex justify-center gap-2">
                        <!-- Delete -->
                        <form action="{{ route('admin.partners.destroy', $partner->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus partner ini?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>

                            </button>

                        </form>

                        <!-- Edit -->
                        <a href="{{ route('admin.partners.edit', $partner->id) }}"
                            class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>

                        </a>
                    </div>
                </td>

            </tr>
            @endforeach

            @else

            <tr>
                <td colspan="4" class="p-6 text-center text-gray-500">
                    🚫 Partner tidak ditemukan
                </td>
            </tr>

            @endif

        </tbody>

    </table>

</div>
@endsection