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
        <p class="text-3xl font-black mt-2">{{ $totalPendapatanShort }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow p-6">
        <p class="text-slate-400 text-sm font-bold uppercase">Rating Rata-rata</p>
        <p class="text-3xl font-black mt-2">{{ $avgRating ? number_format($avgRating, 1) : '-' }}</p>
    </div>
</div>
<div class="bg-white rounded-2xl shadow p-6 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-bold text-lg">Statistik Event Saya</h3>
        <div class="flex items-center gap-2">
            <a href="?period=year" class="px-3 py-1.5 rounded-lg text-sm font-bold {{ $period === 'year' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                Per Tahun
            </a>
            <a href="?period=month&month={{ $selectedMonth }}" class="px-3 py-1.5 rounded-lg text-sm font-bold {{ $period === 'month' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                Per Bulan
            </a>
            @if($period === 'month')
            <form method="GET" class="inline">
                <input type="hidden" name="period" value="month">
                <input type="month" name="month" value="{{ $selectedMonth }}" onchange="this.form.submit()"
                    class="border rounded-lg px-2 py-1 text-sm">
            </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="text-sm font-bold text-slate-500 mb-2">Tiket Terjual</p>
            <div class="relative h-64"><canvas id="tiketChart"></canvas></div>
        </div>
        <div>
            <p class="text-sm font-bold text-slate-500 mb-2">Pendapatan</p>
            <div class="relative h-64"><canvas id="pendapatanChart"></canvas></div>
        </div>
    </div>
</div>

<script>
    function buildLineChart(canvasId, data, label, color) {
        new Chart(document.getElementById(canvasId), {
            type: 'line',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: label,
                    data: Object.values(data),
                    borderColor: color,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    buildLineChart('tiketChart', @json($tiketGrowth), 'Tiket Terjual', '#6366f1');
    buildLineChart('pendapatanChart', @json($pendapatanGrowth), 'Pendapatan', '#f59e0b');
</script>
@endsection