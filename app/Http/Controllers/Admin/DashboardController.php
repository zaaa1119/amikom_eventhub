<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;


class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');

        // 2. Menghitung Berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();

        // 3. Menghitung Jumlah Acara Mendatang yang aktif diselenggarakan
        $activeEvents = Event::where('date', '>=', now())->count();

        // 4. Menghitung Transaksi Ngadat (Status belum dibayar pelanggan / Expired)
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir di panel
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        // 6. Menyertakan grafik pertumbuhan pengguna dan acara
        $period = request('period', 'year');
        $selectedMonth = request('month', now()->format('Y-m'));

        if ($period === 'month') {
            $start = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $groupFormat = 'DATE(created_at)';
        } else {
            $start = now()->subMonths(11)->startOfMonth();
            $end = now()->endOfMonth();
            $groupFormat = 'DATE_FORMAT(created_at, "%Y-%m")';
        }

        $userGrowth = \App\Models\User::selectRaw("$groupFormat as label, COUNT(*) as jumlah")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('label')->orderBy('label')->pluck('jumlah', 'label');

        $eventGrowth = \App\Models\Event::selectRaw("$groupFormat as label, COUNT(*) as jumlah")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('label')->orderBy('label')->pluck('jumlah', 'label');

        $transactionGrowth = \App\Models\Transaction::selectRaw("$groupFormat as label, SUM(total_price) as jumlah")
            ->whereIn('status', ['settlement', 'success'])
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('label')->orderBy('label')->pluck('jumlah', 'label');

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'userGrowth',
            'eventGrowth',
            'period',
            'selectedMonth',
            'transactionGrowth'
        ));
    }
}
