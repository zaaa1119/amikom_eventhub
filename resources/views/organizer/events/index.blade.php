@extends('layouts.organizer')
@section('page_title', 'Event Saya')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('organizer.events.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm">
        + Tambah Event
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr>
                <th class="p-4">Judul</th>
                <th class="p-4">Tanggal</th>
                <th class="p-4">Stok</th>
                <th class="p-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr class="border-t">
                    <td class="p-4 font-bold">{{ $event->title }}</td>
                    <td class="p-4">{{ $event->date->translatedFormat('d F Y') }}</td>
                    <td class="p-4">{{ $event->stock }}</td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('organizer.events.edit', $event) }}" class="text-indigo-600 font-bold">Edit</a>
                        <form action="{{ route('organizer.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Yakin hapus event ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $events->links() }}</div>
@endsection