@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Left: Poster -->
    <div class="lg:col-span-1">
        <div class="sticky top-32">
            <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white">

            @if($event->partner)
            <a href="{{ route('partner.show', $event->partner) }}"
               class="block mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                <h4 class="font-bold mb-4">Penyelenggara</h4>
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/' . $event->partner->logo_url) }}"
                         class="w-12 h-12 rounded-full object-cover border">
                    <div>
                        <p class="font-bold text-slate-800">{{ $event->partner->name }}</p>
                        <p class="text-xs text-slate-500">Lihat profil & ulasan lain →</p>
                    </div>
                </div>
            </a>
            @endif
        </div>
    </div>

    <!-- Right: Details -->
    <div class="lg:col-span-2 space-y-12">
        <div class="space-y-4">
            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">{{ $event->category->name }}</span>
            <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>
            <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                <div class="flex items-center gap-2">
                    <span>{{ $event->date->format('d F Y H:i') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>{{ $event->location }}</span>
                </div>
            </div>
        </div>

        <div class="prose prose-slate max-w-none">
            <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
            <p class="text-lg text-slate-600 leading-relaxed">{{ $event->description }}</p>
        </div>

        <!-- Ganti kotak harga jadi ringkasan ulasan -->
        <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Ulasan Peserta</p>
                @if($reviewCount > 0)
                    <h2 class="text-5xl font-black">⭐ {{ number_format($avgRating, 1) }}</h2>
                    <p class="mt-2 text-indigo-100">Dari {{ $reviewCount }} ulasan</p>
                @else
                    <h2 class="text-2xl font-bold">Belum ada ulasan untuk event ini</h2>
                @endif
            </div>
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
        </div>

        <!-- Daftar ulasan -->
        <div class="space-y-4">
            @foreach($reviews as $review)
                <div class="bg-white rounded-2xl shadow p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-sm">{{ $review->user->name }}</p>
                            <p class="text-amber-500 text-xs">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</p>
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="text-slate-700 text-sm">{{ $review->comment }}</p>
                    @endif
                    @if($review->photo_path)
                        <img src="{{ Storage::url($review->photo_path) }}" class="mt-3 rounded-xl max-h-64 object-cover">
                    @endif
                </div>
            @endforeach
        </div>

        <div>
            {{ $reviews->links() }}
        </div>
    </div>
</main>
@endsection