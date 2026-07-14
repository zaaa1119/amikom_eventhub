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

        return view('admin.transactions.index', compact('transactions', 'allTransactions'));
    }
}
