<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $eventIds = auth()->user()->partner->events()->pluck('id');

        // Data untuk tabel (pagination)
        $transactions = Transaction::with('event')
            ->whereIn('event_id', $eventIds)
            ->latest()
            ->paginate(20);

        // Seluruh data untuk statistik
        $allTransactions = Transaction::with('event')
            ->whereIn('event_id', $eventIds)
            ->get();

        $paidStatuses = ['success', 'settlement'];

        $totalTransactions = $allTransactions->count();

        $totalPendapatan = $allTransactions
            ->whereIn('status', $paidStatuses)
            ->sum('total_price');

        $totalPendapatanShort = $this->formatRupiahSingkat($totalPendapatan);

        $totalSuccess = $allTransactions
            ->whereIn('status', $paidStatuses)
            ->count();

        $totalPending = $allTransactions
            ->filter(fn($trx) => strtolower($trx->status) === 'pending')
            ->count();

        $totalFailed = $allTransactions
            ->whereIn('status', ['failed', 'cancel', 'expired'])
            ->count();

        $successRate = $totalTransactions > 0
            ? round(($totalSuccess / $totalTransactions) * 100, 1)
            : 0;

        $pendingRate = $totalTransactions > 0
            ? round(($totalPending / $totalTransactions) * 100, 1)
            : 0;

        $failedRate = $totalTransactions > 0
            ? round(($totalFailed / $totalTransactions) * 100, 1)
            : 0;

        return view('organizer.transactions.index', compact(
            'transactions',
            'totalTransactions',
            'totalPendapatan',
            'totalPendapatanShort',
            'totalSuccess',
            'totalPending',
            'totalFailed',
            'successRate',
            'pendingRate',
            'failedRate'
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
