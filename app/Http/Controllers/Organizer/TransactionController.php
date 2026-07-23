<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $eventIds = auth()->user()->partner->events()->pluck('id');

        $transactions = Transaction::with('event')
            ->whereIn('event_id', $eventIds)
            ->latest()
            ->paginate(20);

        $allTransactions = Transaction::with('event')
            ->whereIn('event_id', $eventIds)
            ->get();

        return view('organizer.transactions.index', compact('transactions', 'allTransactions'));
    }
}