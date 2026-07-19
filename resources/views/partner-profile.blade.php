@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="bg-white rounded-2xl shadow p-8 flex items-center gap-6 mb-8">
        <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="{{ $partner->name }}" class="w-20 h-20 rounded-full object-cover border">
        <div>
            <h1 class="text-2xl font-black">{{ $partner->name }}</h1>
            @if($reviewCount > 0)
                <a href="{{ route('partner.reviews', ['partner' => $partner, 'scope' => 'all']) }}"
                   class="text-amber-500 font-bold hover:underline">
                    ⭐ {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
                </a>
            @else
                <p class="text-slate-400 text-sm">Belum ada ulasan</p>
            @endif
        </div>
    </div>

    <h2 class="text-xl font-black mb-4">Event yang Diselenggarakan</h2>
    <div class="grid gap-4">
        @foreach($partner->events as $event)
            <a href="{{ route('event.reviews', $event) }}" class="bg-white rounded-xl shadow p-4 flex justify-between items-center hover:shadow-md transition">
                <span class="font-semibold">{{ $event->title }}</span>
                <span class="text-slate-400 text-sm">{{ $event->date->translatedFormat('d F Y') }}</span>
            </a>
        @endforeach
    </div>
</div>
@endsection