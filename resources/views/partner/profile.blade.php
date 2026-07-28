@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">

    {{-- Header profil --}}
    <div class="bg-white rounded-3xl shadow-sm overflow-hidden mb-10">
        <div class="h-28 bg-gradient-to-r from-indigo-600 to-indigo-400"></div>
        <div class="px-8 pb-8 -mt-14">
            <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="{{ $partner->name }}"
                 class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-md bg-white">

            <div class="mt-4">
                <h1 class="text-2xl font-black">{{ $partner->name }}</h1>

                @if($reviewCount > 0)
                    <div class="flex items-center gap-2 mt-2">
                        <div class="relative inline-block text-lg" style="line-height:1">
                            <div class="text-slate-200">★★★★★</div>
                            <div class="absolute top-0 left-0 overflow-hidden text-amber-500"
                                 style="width: {{ min(100, max(0, ($avgRating / 5) * 100)) }}%">
                                <div class="whitespace-nowrap">★★★★★</div>
                            </div>
                        </div>
                        <span class="font-bold text-slate-700">{{ number_format($avgRating, 1) }}</span>
                        <a href="{{ route('partner.reviews', $partner) }}"
                           class="text-indigo-600 text-sm font-bold hover:underline">
                            {{ $reviewCount }} ulasan
                        </a>
                    </div>
                @else
                    <p class="text-slate-400 text-sm mt-2">Belum ada ulasan</p>
                @endif

                <div class="flex gap-6 mt-5 pt-5 border-t border-slate-100">
                    <div>
                        <p class="text-2xl font-black">{{ $upcomingEvents->count() }}</p>
                        <p class="text-xs text-slate-400 font-bold uppercase">Event Akan Datang</p>
                    </div>
                    <div>
                        <p class="text-2xl font-black">{{ $pastEvents->count() }}</p>
                        <p class="text-xs text-slate-400 font-bold uppercase">Event Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Event akan datang / sedang berlangsung --}}
    @if($upcomingEvents->isNotEmpty())
        <h2 class="text-xl font-black mb-4">Akan Datang</h2>
        <div class="grid gap-4 mb-10">
            @foreach($upcomingEvents as $event)
                <a href="{{ route('event.detail', $event) }}"
                   class="bg-white rounded-2xl shadow-sm p-5 flex justify-between items-center hover:shadow-md transition">
                    <div>
                        <p class="font-bold">{{ $event->title }}</p>
                        <p class="text-slate-400 text-sm">{{ $event->date->translatedFormat('d F Y') }}</p>
                    </div>
                    <span class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold">
                        Lihat Detail
                    </span>
                </a>
            @endforeach
        </div>
    @endif

    {{-- Event yang sudah selesai --}}
    @if($pastEvents->isNotEmpty())
        <h2 class="text-xl font-black mb-4">Sudah Berlangsung</h2>
        <div class="grid gap-4">
            @foreach($pastEvents as $event)
                <a href="{{ route('event.reviews', $event) }}"
                   class="bg-white rounded-2xl shadow-sm p-5 flex justify-between items-center hover:shadow-md transition">
                    <div>
                        <p class="font-bold">{{ $event->title }}</p>
                        <p class="text-slate-400 text-sm">{{ $event->date->translatedFormat('d F Y') }}</p>
                    </div>
                    <span class="text-sm font-bold text-slate-500">
                        {{ $event->reviews_count }} ulasan
                    </span>
                </a>
            @endforeach
        </div>
    @endif

    @if($upcomingEvents->isEmpty() && $pastEvents->isEmpty())
        <p class="text-slate-400 text-center py-10">Belum ada event dari penyelenggara ini.</p>
    @endif
</div>
@endsection