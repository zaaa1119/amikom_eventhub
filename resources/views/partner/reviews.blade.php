@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    <a href="{{ route('partner.show', $partner) }}"
        class="bg-white rounded-2xl shadow p-6 flex items-center gap-6 mb-8 hover:shadow-md transition">
        <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="{{ $partner->name }}"
            class="w-16 h-16 rounded-full object-cover border">
        <div>
            <h1 class="text-xl font-black hover:text-indigo-600 transition">{{ $partner->name }}</h1>
            @if($reviewCount > 0)
            <div class="flex items-center gap-2">
                <div class="relative inline-block text-lg" style="line-height:1">
                    <div class="text-slate-200">★★★★★</div>
                    <div class="absolute top-0 left-0 overflow-hidden text-amber-500"
                        style="width: {{ min(100, max(0, ($avgRating / 5) * 100)) }}%">
                        <div class="whitespace-nowrap">★★★★★</div>
                    </div>
                </div>
                <span class="text-slate-700 font-bold">{{ number_format($avgRating, 1) }}</span>
                <span class="text-slate-400 font-normal text-sm">({{ $reviewCount }} ulasan)</span>
            </div>
            @else
            <p class="text-slate-400 text-sm">Belum ada ulasan untuk pilihan ini</p>
            @endif
        </div>
    </a>



    {{-- Breakdown rating per bintang --}}
    @if($reviewCount > 0)
    <div class="bg-white rounded-2xl shadow p-6 mb-6 space-y-2">
        @foreach($breakdown as $star => $data)
        <div class="flex items-center gap-3 text-sm">
            <span class="w-10 font-bold text-slate-600">{{ $star }} ★</span>
            <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-amber-400" style="width: {{ $data['percent'] }}%"></div>
            </div>
            <span class="w-10 text-right text-slate-400">{{ $data['count'] }}</span>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Filter & Urutkan --}}
    <div class="flex flex-wrap items-center gap-2 mb-6">
        <a href="{{ route('partner.reviews', array_merge(['partner' => $partner], request()->except('sort'), ['sort' => 'terbaru'])) }}"
            class="px-4 py-2 rounded-xl text-sm font-bold {{ $sort === 'terbaru' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition">
            Terbaru
        </a>
        <a href="{{ route('partner.reviews', array_merge(['partner' => $partner], request()->except('sort'), ['sort' => 'tertinggi'])) }}"
            class="px-4 py-2 rounded-xl text-sm font-bold {{ $sort === 'tertinggi' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition">
            Rating Tertinggi
        </a>
        <a href="{{ route('partner.reviews', array_merge(['partner' => $partner], request()->except('foto'), $onlyPhoto ? [] : ['foto' => 1])) }}"
            class="ml-auto px-4 py-2 rounded-xl text-sm font-bold {{ $onlyPhoto ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition">
            Dengan Gambar
        </a>
    </div>

    {{-- Daftar ulasan --}}
    <div class="space-y-4">
        @forelse($reviews as $review)
        <div class="bg-white rounded-2xl shadow p-5">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-sm">{{ $review->user->name }}</p>
                        <p class="text-amber-500 text-xs">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold whitespace-nowrap">
                    {{ $review->event->title }}
                </span>
            </div>
            @if($review->comment)
            <p class="text-slate-700 text-sm mt-2">{{ $review->comment }}</p>
            @endif
            @if($review->photo_path)
            <img src="{{ Storage::url($review->photo_path) }}" class="mt-3 rounded-xl max-h-64 object-cover">
            @endif
        </div>
        @empty
        <p class="text-slate-400 text-center py-10">Belum ada ulasan untuk pilihan ini.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $reviews->links() }}</div>

</div>
@endsection