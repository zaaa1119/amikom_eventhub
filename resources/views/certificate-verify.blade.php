@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-16">
    @if($certificate)
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">✓</div>
            <h1 class="text-2xl font-black">Sertifikat Terverifikasi</h1>
            <p class="text-slate-500 text-sm">Sertifikat ini sah dan tercatat di sistem AmikomEventHub.</p>
        </div>

        {{-- Replika visual sertifikat --}}
        <div class="relative bg-white rounded-2xl shadow-lg p-10 text-center overflow-hidden" style="border: 2px solid #c9a86a;">
            <div class="absolute inset-2 border border-amber-600/30 rounded-xl pointer-events-none"></div>

            @if($certificate->transaction->event->partner && $certificate->transaction->event->partner->logo_url)
                <img src="{{ asset('storage/' . $certificate->transaction->event->partner->logo_url) }}"
                     class="w-14 h-14 rounded-full object-cover mx-auto mb-3 border-2 border-amber-600">
            @else
                <div class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg mx-auto mb-3">AH</div>
            @endif

            <p class="text-xs font-bold tracking-widest text-indigo-600 mb-1">SERTIFIKAT PESERTA</p>
            <p class="text-2xl font-black text-slate-900 mb-6" style="font-family: Georgia, serif;">
                {{ $certificate->transaction->event->title }}
            </p>

            <p class="text-xs text-slate-400 uppercase tracking-widest">Diberikan kepada</p>
            <p class="text-3xl font-black text-slate-900 mb-2" style="font-family: Georgia, serif;">
                {{ $certificate->transaction->customer_name }}
            </p>
            <div class="w-48 h-0.5 bg-amber-600 mx-auto mb-6"></div>

            <p class="text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                Atas partisipasinya sebagai peserta dalam acara ini, yang diselenggarakan oleh
                <strong>{{ $certificate->transaction->event->partner->name ?? 'AmikomEventHub' }}</strong>
                pada {{ $certificate->transaction->event->date->translatedFormat('d F Y') }}.
            </p>
        </div>

        {{-- Info detail --}}
        <div class="grid grid-cols-2 gap-4 mt-8 text-sm">
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-400 font-bold uppercase">Kode Verifikasi</p>
                <p class="font-mono font-bold">{{ $certificate->certificate_code }}</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-400 font-bold uppercase">Diterbitkan</p>
                <p class="font-bold">{{ $certificate->sent_at?->translatedFormat('d F Y') ?? '-' }}</p>
            </div>
        </div>
    @else
        <div class="text-center py-10">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">✕</div>
            <h1 class="text-2xl font-black mb-2">Sertifikat Tidak Ditemukan</h1>
            <p class="text-slate-500">Kode ini tidak valid atau sertifikat tidak pernah diterbitkan.</p>
        </div>
    @endif
</div>
@endsection