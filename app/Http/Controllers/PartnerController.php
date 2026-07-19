<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function show(Partner $partner)
    {
        abort_if($partner->events()->count() === 0, 404);

        $eventIds = $partner->events()->pluck('id');

        $avgRating = \App\Models\Review::whereIn('event_id', $eventIds)->avg('rating');
        $reviewCount = \App\Models\Review::whereIn('event_id', $eventIds)->count();

        $latestReviews = \App\Models\Review::whereIn('event_id', $eventIds)
            ->with(['user', 'event'])
            ->latest()
            ->take(5)
            ->get();

        return view('partner-profile', compact('partner', 'avgRating', 'reviewCount', 'latestReviews'));
    }

    public function reviews(Request $request, Partner $partner)
    {
        abort_if($partner->events()->count() === 0, 404);

        $scope = $request->query('scope', 'all'); // 'all' atau id event tertentu

        $query = \App\Models\Review::whereIn('event_id', $partner->events()->pluck('id'))
            ->with(['user', 'event']);

        if ($scope !== 'all') {
            $query->where('event_id', $scope);
        }

        $reviews = $query->latest()->paginate(10);

        return view('partner-reviews', compact('partner', 'reviews', 'scope'));
    }
}
