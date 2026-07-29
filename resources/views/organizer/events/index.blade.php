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
                <th class="px-8 py-4">Poster</th>
                <th class="p-4">Event</th>
                <th class="p-4">Tanggal</th>
                <th class="p-4">Stok</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr class="border-t">
                <td class="px-8 py-6">
                    <img src="{{ asset('storage/' . $event->poster_path) }}" class="w-16 h-20 rounded-xl object-cover shadow-sm">
                </td>
                <td class="p-4 font-bold">{{ $event->title }}</td>
                <td class="p-4">{{ $event->date->translatedFormat('d F Y') }}</td>
                <td class="p-4">{{ $event->stock }}</td>
                <td class="p-4">
                    <div class="flex gap-2 text-center justify-center">
                        <!-- Catatan Modul: Deretan tombol fitur modifikasi (U dan D) akan ditanamkan pada tahap berikutnya -->
                        <form action="{{ route('organizer.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                        <a href="{{ route('organizer.events.edit', $event) }}" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('organizer.checkin.index', $event) }}"
                            class="p-2.5 bg-green-50 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm12 0h2m-2 4h4m-4-2h2m2-2v6"></path>
                            </svg>
                        </a>@if($event->certificate_enabled)
                        <a href="{{ route('organizer.certificates.index', $event) }}"
                            class="p-2.5 bg-purple-50 text-purple-600 rounded-xl hover:bg-purple-600 hover:text-white transition"
                            title="Kelola Sertifikat">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-5-3l5 3 5-3" />
                            </svg>
                        </a>
                        @endif

                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $events->links() }}</div>
@endsection