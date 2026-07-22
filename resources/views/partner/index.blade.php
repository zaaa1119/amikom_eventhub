@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-20">

    <h1 class="text-3xl font-black mb-10 text-center">
        Partner Kami
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach($partners as $partner)

        @if($partner->events_count > 0)
        <a href="{{ route('partner.show', $partner) }}"
            class="bg-white rounded-2xl shadow-sm p-6 flex flex-col items-center justify-center gap-3 hover:shadow-md transition">
            @else
            <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col items-center justify-center gap-3">
                @endif

                <!-- Logo -->
                <img src="{{ asset('storage/' . $partner->logo_url) }}"
                    class="h-16 object-contain"
                    alt="{{ $partner->name }}">

                <!-- Nama -->
                <p class="text-sm font-semibold text-slate-700 text-center">
                    {{ $partner->name }}
                </p>

                @if($partner->events_count > 0)
        </a>
        @else
    </div>
    @endif

    @endforeach

</div>

</div>

@endsection