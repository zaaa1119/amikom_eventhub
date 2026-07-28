<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function index(\App\Models\Event $event)
    {
        $this->authorizeOwnership($event);
        return view('organizer.checkin.index', compact('event'));
    }

    public function scan(Request $request, \App\Models\Event $event)
    {
        $this->authorizeOwnership($event);

        $request->validate(['order_id' => 'required|string']);

        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if (! $transaction) {
            return response()->json(['status' => 'error', 'message' => 'Tiket tidak ditemukan.']);
        }

        if ($transaction->event_id !== $event->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket ini BUKAN untuk event "' . $event->title . '".',
                'name' => $transaction->customer_name . ' — tiket ini untuk: ' . $transaction->event->title,
            ]);
        }

        if (! in_array($transaction->status, ['settlement', 'success'])) {
            return response()->json(['status' => 'error', 'message' => 'Tiket ini belum lunas dibayar.']);
        }

        if ($transaction->checked_in_at) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Tiket ini SUDAH check-in sebelumnya, pada ' . $transaction->checked_in_at->format('d M Y H:i'),
                'name' => $transaction->customer_name,
            ]);
        }

        $transaction->update(['checked_in_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in berhasil!',
            'name' => $transaction->customer_name . ' — ' . $event->title . ', ' . $event->date->format('d M Y H:i'),
        ]);
    }

    private function authorizeOwnership(\App\Models\Event $event): void
    {
        abort_if($event->partner_id !== auth()->user()->partner_id, 403, 'Event ini bukan milik kamu.');
    }
}
