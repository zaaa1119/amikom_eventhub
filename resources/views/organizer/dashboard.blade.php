@extends('layouts.organizer')
@section('page_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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
        <p class="text-slate-400 text-sm font-bold uppercase">Rating Rata-rata</p>
        <p class="text-3xl font-black mt-2">{{ $avgRating ? number_format($avgRating, 1) : '-' }}</p>
    </div>
</div>
@endsection