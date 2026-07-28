@extends('layouts.organizer')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan performa transaksi event kamu.')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">

    <!-- REVENUE -->
    <div class="bg-gradient-to-br from-emerald-200 to-white rounded-2xl border border-emerald-100 shadow-sm p-6">
        <p class="text-[11px] uppercase tracking-widest text-emerald-600">Revenue</p>
        <h2 class="text-2xl font-black text-emerald-700 mt-2">
            {{ $totalPendapatanShort }}
        </h2>
        <p class="text-xs text-slate-400 mt-2">Total pendapatan sukses</p>
    </div>

    <!-- TOTAL TRANSACTIONS -->
    <div class="bg-gradient-to-br from-slate-200 to-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <p class="text-[11px] uppercase tracking-widest text-slate-500">Transactions</p>
        <h2 class="text-2xl font-black text-slate-800 mt-2">
            {{ $totalTransactions }}
        </h2>
        <p class="text-xs text-slate-400 mt-2">Total semua transaksi</p>
    </div>

    <!-- SUCCESS -->
    <div class="bg-gradient-to-br from-cyan-200 to-white rounded-2xl border border-emerald-100 shadow-sm p-6">
        <p class="text-[11px] uppercase tracking-widest text-emerald-600">Success</p>
        <h2 class="text-2xl font-black text-emerald-700 mt-2">
            {{ $totalSuccess }}
        </h2>
        <p class="text-xs text-slate-400 mt-2">{{ $successRate }}% conversion rate</p>
    </div>

    <!-- PENDING -->
    <div class="bg-gradient-to-br from-amber-200 to-white rounded-2xl border border-amber-100 shadow-sm p-6">
        <p class="text-[11px] uppercase tracking-widest text-amber-600">Pending</p>
        <h2 class="text-2xl font-black text-amber-600 mt-2">
            {{ $totalPending }}
        </h2>
        <p class="text-xs text-slate-400 mt-2">{{ $pendingRate }}% waiting payment</p>
    </div>

    <!-- FAILED / OTHER -->
    <div class="bg-gradient-to-br from-rose-200 to-white rounded-2xl border border-rose-100 shadow-sm p-6">
        <p class="text-[11px] uppercase tracking-widest text-rose-600">Failed</p>
        <h2 class="text-2xl font-black text-rose-600 mt-2">
            {{ $totalFailed }}
        </h2>
        <p class="text-xs text-slate-400 mt-2">{{ $failedRate }}% Cancelled / expired</p>
    </div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

    <div class="px-8 py-6 border-b bg-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-800">Transaction Ledger</h3>
                <p class="text-xs text-slate-400">Detail seluruh aktivitas pembayaran</p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">

            <thead class="sticky top-0 z-10 bg-slate-50/80 backdrop-blur text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                <tr>
                    <th class="px-8 py-4">Order</th>
                    <th class="px-8 py-4">Customer</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Time</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Amount</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($transactions as $transaction)
                <tr class="group hover:bg-slate-50/70 transition">

                    <td class="px-8 py-5">
                        <span class="font-mono text-[11px] font-semibold px-3 py-1 rounded-md
                            {{ in_array($transaction->status, ['success', 'settlement']) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                            #{{ $transaction->order_id }}
                        </span>
                    </td>

                    <td class="px-8 py-5">
                        <p class="font-semibold text-slate-800 group-hover:text-slate-900">
                            {{ $transaction->customer_name }}
                        </p>
                        <p class="text-[11px] text-slate-400">
                            {{ $transaction->customer_email }}
                        </p>
                    </td>

                    <td class="px-8 py-5">
                        <p class="text-slate-700 font-medium">
                            {{ $transaction->event->title ?? '-' }}
                        </p>
                    </td>

                    <td class="px-8 py-5 text-xs text-slate-400">
                        {{ $transaction->created_at->format('d M Y • H:i') }}
                    </td>

                    <td class="px-8 py-5">
                        @if(in_array($transaction->status, ['success', 'settlement']))
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold uppercase bg-emerald-50 text-emerald-700 border border-emerald-100">
                            ● Paid
                        </span>
                        @elseif($transaction->status === 'pending')
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold uppercase bg-amber-50 text-amber-700 border border-amber-100">
                            ● Pending
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold uppercase bg-rose-50 text-rose-700 border border-rose-100">
                            ● {{ $transaction->status }}
                        </span>
                        @endif
                    </td>

                    <td class="px-8 py-5 text-right font-black text-slate-900 tabular-nums">
                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-400">
                        No transactions found
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <div class="px-8 py-5 border-t bg-gradient-to-r from-white to-slate-50 flex items-center justify-between">
        <p class="text-[11px] text-slate-400">
            Financial transaction ledger
        </p>
        <div class="text-sm">
            {{ $transactions->links() }}
        </div>
    </div>

</div>
@endsection