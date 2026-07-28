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

        $upcomingEvents = $partner->events()->where('date', '>=', now())->orderBy('date')->get();
        $pastEvents = $partner->events()->where('date', '<', now())
            ->withCount('reviews')
            ->orderByDesc('date')
            ->get();

        return view('partner.profile', compact(
            'partner',
            'avgRating',
            'reviewCount',
            'upcomingEvents',
            'pastEvents'
        ));
    }

    public function reviews(Request $request, Partner $partner)
{
    abort_if($partner->events()->count() === 0, 404);

    $eventIds = $partner->events()->pluck('id');

    $avgRating = \App\Models\Review::whereIn('event_id', $eventIds)->avg('rating');
    $reviewCount = \App\Models\Review::whereIn('event_id', $eventIds)->count();

    $breakdown = [];
    for ($star = 5; $star >= 1; $star--) {
        $count = \App\Models\Review::whereIn('event_id', $eventIds)->where('rating', $star)->count();
        $breakdown[$star] = [
            'count' => $count,
            'percent' => $reviewCount > 0 ? round($count / $reviewCount * 100) : 0,
        ];
    }

    $sort = $request->query('sort', 'terbaru');
    $onlyPhoto = $request->boolean('foto');

    $query = \App\Models\Review::whereIn('event_id', $eventIds)->with(['user', 'event']);

    if ($onlyPhoto) {
        $query->whereNotNull('photo_path');
    }

    if ($sort === 'tertinggi') {
        $query->orderByDesc('rating')->latest();
    } else {
        $query->latest();
    }

    $reviews = $query->paginate(10)->withQueryString();

    return view('partner.reviews', compact(
        'partner', 'reviews', 'avgRating', 'reviewCount', 'breakdown', 'sort', 'onlyPhoto'
    ));
}
}
