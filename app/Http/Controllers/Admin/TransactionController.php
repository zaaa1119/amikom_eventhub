<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil transaksi terbaru dengan pembatasan 20 baris/halaman
        $transactions = Transaction::with('event')->latest()->paginate(20);

        // Untuk statistik (ambil semua data)
        $allTransactions = Transaction::with('event')->get();

        $totalPendapatan = Transaction::whereIn('status', ['settlement', 'success'])
            ->sum('total_price');

        $totalPendapatanShort = $this->formatRupiahSingkat($totalPendapatan);

        return view('admin.transactions.index', compact('transactions', 'allTransactions', 'totalPendapatan', 'totalPendapatanShort'));
    }

    private function formatRupiahSingkat($number)
    {
        if ($number >= 1_000_000_000) return 'Rp' . number_format($number / 1_000_000_000, 1) . ' M';
        if ($number >= 1_000_000) return 'Rp' . number_format($number / 1_000_000, 1) . ' Jt';
        return 'Rp' . number_format($number, 0, ',', '.');
    }
}
