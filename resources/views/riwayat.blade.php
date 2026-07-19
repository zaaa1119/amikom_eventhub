@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-black mb-8">Riwayat Tiket</h1>

    @if($transactions->isEmpty())
        <p class="text-slate-500">Kamu belum punya tiket yang tercatat di akun ini.</p>
    @endif

    <div class="space-y-4">
        @foreach($transactions as $trx)
            @php
                $eventDate = $trx->event->date;
                $isFinished = now()->greaterThanOrEqualTo($eventDate->copy()->addDay());
                $alreadyReviewed = $trx->event->reviews->isNotEmpty();
            @endphp

            <div class="bg-white rounded-2xl shadow p-6 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-lg">{{ $trx->event->title }}</h2>
                    <p class="text-slate-500 text-sm">{{ $eventDate->translatedFormat('d F Y, H:i') }}</p>
                    <p class="text-slate-400 text-xs mt-1">No. Pesanan: {{ $trx->order_id }}</p>
                </div>

                <div>
                    @if(!$isFinished)
                        <span class="text-slate-400 text-sm font-medium">Acara belum berlangsung</span>
                    @elseif($alreadyReviewed)
                        <span class="text-green-600 text-sm font-bold">✓ Sudah diulas</span>
                    @else
                        <a href="{{ route('review.create', $trx) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition">
                            Beri Ulasan
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection