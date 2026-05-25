@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-20">

    <h1 class="text-3xl font-black mb-10 text-center">
        Partner Kami
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach($partners as $partner)

        <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center justify-center">
            <img src="{{ asset('storage/' . $partner->logo_url) }}"
                 class="h-16 object-contain"
                 alt="{{ $partner->name }}">
        </div>

        @endforeach

    </div>

</div>

@endsection