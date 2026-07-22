<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function detail(Event $event)
    {
        return view('event.detail', compact('event'));
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function ticket()
    {
        return view('ticket'); // halaman tiket user
    }

    public function indexAdmin()
    {
        return view('admin.events'); // halaman admin event list
    }

    public function riwayat()
    {
        $transactions = auth()->user()
            ->transactions()
            ->whereIn('status', ['settlement', 'success'])
            ->with(['event', 'event.reviews' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->latest()
            ->get();

        return view('riwayat', compact('transactions'));
    }

    public function reviews(Event $event)
    {
        $avgRating = $event->reviews()->avg('rating');
        $reviewCount = $event->reviews()->count();
        $reviews = $event->reviews()->with('user')->latest()->paginate(10);

        return view('event.reviews', compact('event', 'avgRating', 'reviewCount', 'reviews'));
    }
}
