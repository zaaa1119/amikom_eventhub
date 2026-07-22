@extends('layouts.organizer')
@section('page_title', 'Tambah Event')

@section('content')
<div class="bg-white rounded-2xl shadow p-8 max-w-2xl">
    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block font-bold mb-1 text-sm">Kategori</label>
            <select name="category_id" class="w-full border rounded-xl px-4 py-3" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Judul Event</label>
            <input type="text" name="title" class="w-full border rounded-xl px-4 py-3" required>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border rounded-xl px-4 py-3"></textarea>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Tanggal & Waktu</label>
            <input type="datetime-local" name="date" class="w-full border rounded-xl px-4 py-3" required>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Lokasi</label>
            <input type="text" name="location" class="w-full border rounded-xl px-4 py-3" required>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold mb-1 text-sm">Harga</label>
                <input type="number" name="price" class="w-full border rounded-xl px-4 py-3" required>
            </div>
            <div>
                <label class="block font-bold mb-1 text-sm">Stok Tiket</label>
                <input type="number" name="stock" class="w-full border rounded-xl px-4 py-3" required>
            </div>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Poster</label>
            <input type="file" name="poster" class="w-full border rounded-xl px-4 py-3">
        </div>
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold">Simpan</button>
    </form>
</div>
@endsection