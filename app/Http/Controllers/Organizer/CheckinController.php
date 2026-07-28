<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function index()
    {
        return view('organizer.checkin.index');
    }

    public function scan(Request $request)
    {
        $request->validate(['order_id' => 'required|string']);

        $transaction = Transaction::with('event')
            ->where('order_id', $request->order_id)
            ->first();

        if (! $transaction) {
            return response()->json(['status' => 'error', 'message' => 'Tiket tidak ditemukan.']);
        }

        if ($transaction->event->partner_id !== auth()->user()->partner_id) {
            return response()->json(['status' => 'error', 'message' => 'Tiket ini bukan untuk event kamu.']);
        }

        if (! in_array($transaction->status, ['settlement', 'success'])) {
            return response()->json(['status' => 'error', 'message' => 'Tiket ini belum lunas dibayar.']);
        }

        if ($transaction->checked_in_at) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Tiket ini SUDAH pernah check-in sebelumnya, pada ' . $transaction->checked_in_at->format('d M Y H:i'),
                'name' => $transaction->customer_name,
            ]);
        }

        $transaction->update(['checked_in_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in berhasil!',
            'name' => $transaction->customer_name,
            'event' => $transaction->event->title,
        ]);
    }
}