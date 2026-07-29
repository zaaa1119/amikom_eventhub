@extends('layouts.organizer')
@section('page_title', 'Edit Event')

@section('content')
<div class="bg-white rounded-2xl shadow p-8 max-w-2xl">
    <form action="{{ route('organizer.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block font-bold mb-1 text-sm">Kategori</label>
            <select name="category_id" class="w-full border rounded-xl px-4 py-3" required>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $event->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Judul Event</label>
            <input type="text" name="title" value="{{ $event->title }}" class="w-full border rounded-xl px-4 py-3" required>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border rounded-xl px-4 py-3">{{ $event->description }}</textarea>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Tanggal & Waktu</label>
            <input type="datetime-local" name="date" value="{{ $event->date->format('Y-m-d\TH:i') }}" class="w-full border rounded-xl px-4 py-3" required>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Lokasi</label>
            <input type="text" name="location" value="{{ $event->location }}" class="w-full border rounded-xl px-4 py-3" required>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold mb-1 text-sm">Harga</label>
                <input type="number" name="price" value="{{ $event->price }}" class="w-full border rounded-xl px-4 py-3" required>
            </div>
            <div>
                <label class="block font-bold mb-1 text-sm">Stok Tiket</label>
                <input type="number" name="stock" value="{{ $event->stock }}" class="w-full border rounded-xl px-4 py-3" required>
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Poster Event (Opsional)</label>
            <input type="file" name="poster" accept="image/*" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">
            @if($event->poster_path)
            <div class="mt-3">
                <p class="text-sm text-slate-500 mb-2">Poster saat ini:</p>

                <img src="{{ asset('storage/' . $event->poster_path) }}"
                    alt="Poster Event"
                    class="w-40 h-40 object-cover rounded-2xl border shadow-sm">
            </div>
            @endif
            @error('poster') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
        <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
            <input type="checkbox" name="certificate_enabled" id="certificate_enabled" value="1" class="w-5 h-5"
                {{ $event->certificate_enabled ? 'checked' : '' }}>
            <label for="certificate_enabled" class="font-bold text-sm">
                Aktifkan E-Sertifikat untuk peserta event ini
            </label>
        </div>
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold">Update</button>
    </form>
</div>
@endsection