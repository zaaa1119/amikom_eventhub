@extends('layouts.admin')
@section('page_title', $partner->name)
@section('page_subtitle', 'Detail performa penyelenggara')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow p-6">
        <p class="text-slate-400 text-sm font-bold uppercase">Total Event</p>
        <p class="text-3xl font-black mt-2">{{ $totalEvent }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow p-6">
        <p class="text-slate-400 text-sm font-bold uppercase">Tiket Terjual</p>
        <p class="text-3xl font-black mt-2">{{ $totalTiketTerjual }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow p-6">
        <p class="text-slate-400 text-sm font-bold uppercase">Pendapatan</p>
        <p class="text-3xl font-black mt-2">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow p-6">
        <p class="text-slate-400 text-sm font-bold uppercase">Rating</p>
        <p class="text-3xl font-black mt-2">{{ $avgRating ? number_format($avgRating, 1) : '-' }} <span class="text-sm text-slate-400 font-normal">({{ $reviewCount }})</span></p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr>
                <th class="p-4">Event</th>
                <th class="p-4">Tanggal</th>
                <th class="p-4">Ulasan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr class="border-t">
                    <td class="p-4 font-bold">{{ $event->title }}</td>
                    <td class="p-4">{{ $event->date->translatedFormat('d F Y') }}</td>
                    <td class="p-4">{{ $event->reviews_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection