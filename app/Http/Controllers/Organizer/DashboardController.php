<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $partner = auth()->user()->partner;

        $eventIds = $partner->events()->pluck('id');

        $totalEvent = $eventIds->count();
        $totalTiketTerjual = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->count();
        $totalPendapatan = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->sum('total_price');
        $avgRating = \App\Models\Review::whereIn('event_id', $eventIds)->avg('rating');

        return view('organizer.dashboard', compact(
            'partner', 'totalEvent', 'totalTiketTerjual', 'totalPendapatan', 'avgRating'
        ));
    }
}