<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Transaction $transaction)
    {
        $this->authorizeReview($transaction);

        return view('review.create', compact('transaction'));
    }

    public function store(Request $request, Transaction $transaction)
    {
        $this->authorizeReview($transaction);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('review-photos', 'public');
        }

        Review::create([
            'event_id' => $transaction->event_id,
            'user_id' => auth()->id(),
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('riwayat')->with('status', 'Terima kasih atas ulasannya!');
    }

    private function authorizeReview(Transaction $transaction): void
    {
        // 1. Tiket ini harus punya user yang lagi login
        abort_if($transaction->user_id !== auth()->id(), 403);

        // 2. Transaksinya harus lunas
        abort_if(! in_array($transaction->status, ['settlement', 'success']), 403);

        // 3. Event-nya harus sudah lewat minimal 1 hari
        abort_if(now()->lessThan($transaction->event->date->copy()->addDay()), 403,
            'Ulasan baru bisa diberikan setelah acara selesai.');

        // 4. Belum pernah review event ini sebelumnya
        abort_if(
            Review::where('event_id', $transaction->event_id)->where('user_id', auth()->id())->exists(),
            403,
            'Kamu sudah pernah memberi ulasan untuk event ini.'
        );
    }
}