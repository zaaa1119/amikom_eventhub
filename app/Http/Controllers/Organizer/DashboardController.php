<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $partner = auth()->user()->partner;
        $eventIds = $partner->events()->pluck('id');

        $totalEvent = $eventIds->count();
        $totalTiketTerjual = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])->count();
        $totalPendapatan = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])->sum('total_price');
        $totalPendapatanShort = $this->formatRupiahSingkat($totalPendapatan);
        $avgRating = Review::whereIn('event_id', $eventIds)->avg('rating');

        // --- Bagian grafik, sama pola kayak Admin ---
        $period = request('period', 'year');
        $selectedMonth = request('month', now()->format('Y-m'));

        if ($period === 'month') {
            $start = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $groupFormat = 'DATE(created_at)';
        } else {
            $start = now()->subMonths(11)->startOfMonth();
            $end = now()->endOfMonth();
            $groupFormat = 'DATE_FORMAT(created_at, "%Y-%m")';
        }

        $tiketGrowth = Transaction::selectRaw("$groupFormat as label, COUNT(*) as jumlah")
            ->whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('label')->orderBy('label')->pluck('jumlah', 'label');

        $pendapatanGrowth = Transaction::selectRaw("$groupFormat as label, SUM(total_price) as jumlah")
            ->whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('label')->orderBy('label')->pluck('jumlah', 'label');

        return view('organizer.dashboard', compact(
            'partner', 'totalEvent', 'totalTiketTerjual', 'totalPendapatan','totalPendapatanShort', 'avgRating',
            'period', 'selectedMonth', 'tiketGrowth', 'pendapatanGrowth'
        ));
    }

    private function formatRupiahSingkat($number)
    {
        if ($number >= 1_000_000_000) {
            return 'Rp' . number_format($number / 1_000_000_000, 1) . ' M';
        }

        if ($number >= 1_000_000) {
            return 'Rp' . number_format($number / 1_000_000, 1) . ' Jt';
        }

        return 'Rp' . number_format($number, 0, ',', '.');
    }

}