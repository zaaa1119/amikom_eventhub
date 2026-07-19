@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    <h1 class="text-2xl font-black mb-1">Ulasan untuk {{ $partner->name }}</h1>

    <div class="flex gap-2 mb-6 mt-4">
        <a href="{{ route('partner.reviews', ['partner' => $partner, 'scope' => 'all']) }}"
           class="px-4 py-2 rounded-xl text-sm font-bold {{ $scope === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600' }}">
            Semua Event
        </a>
    </div>

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
                <p class="text-slate-500 text-xs mb-2">Event: {{ $review->event->title }}</p>
                @if($review->comment)
                    <p class="text-slate-700 text-sm">{{ $review->comment }}</p>
                @endif
                @if($review->photo_path)
                    <img src="{{ Storage::url($review->photo_path) }}" class="mt-3 rounded-xl max-h-64 object-cover">
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>
</div>
@endsection