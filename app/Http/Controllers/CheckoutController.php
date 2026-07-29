<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class CheckoutController extends Controller
{
    public function create(Request $request, Event $event)
    {
        $categories = \App\Models\Category::all();

        $coupon = null;
        $discount = 0;
        $couponError = null;

        if ($request->filled('coupon')) {
            $coupon = \App\Models\Coupon::where('code', strtoupper($request->coupon))
                ->where('partner_id', $event->partner_id)
                ->first();

            if (! $coupon) {
                $couponError = 'Kode kupon tidak ditemukan.';
            } elseif ($coupon->valid_until && now()->gt($coupon->valid_until->endOfDay())) {
                $couponError = 'Kupon ini sudah kadaluarsa.';
            } elseif ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                $couponError = 'Kupon ini sudah mencapai batas maksimal penggunaan.';
            } elseif ($coupon->min_purchase && $event->price < $coupon->min_purchase) {
                $couponError = 'Kupon ini minimal berlaku untuk pembelian Rp' . number_format($coupon->min_purchase, 0, ',', '.') . '.';
            } else {
                $discount = $coupon->calculateDiscount($event->price);
            }
        }

        $totalPrice = $event->price > 0 ? ($event->price + 5000 - $discount) : 0;

        return view('checkout.create', compact('event', 'categories', 'coupon', 'discount', 'couponError', 'totalPrice'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        if (auth()->check() && ! auth()->user()->phone && $request->boolean('save_phone')) {
            auth()->user()->update(['phone' => $request->customer_phone]);
        }

        $orderId = 'TRX-' . time() . '-' . Str::random(5);

        // --- Bypass Midtrans khusus event gratis ---
        if ($event->price == 0) {
            $transaction = Transaction::create([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'order_id' => $orderId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'total_price' => 0,
                'status' => 'settlement',
            ]);

            $event->decrement('stock');

            try {
                \Illuminate\Support\Facades\Mail::to($transaction->customer_email)
                    ->send(new \App\Mail\EventTicketMail($transaction));
            } catch (\Throwable $e) {
                \Log::error('Gagal mengirim email E-Ticket event gratis: ' . $e->getMessage());
            }

            session(['pending_claim_order_id' => $orderId]);

            return redirect()->route('checkout.success', $orderId);
        }

        // Alur normal (event berbayar), tetap seperti sebelumnya
        $coupon = null;
        $discount = 0;

        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', $request->coupon_code)
                ->where('partner_id', $event->partner_id)
                ->first();

            if ($coupon && $coupon->isValid($event->price)) {
                $discount = $coupon->calculateDiscount($event->price);
            } else {
                $coupon = null; // jaga-jaga kalau ternyata kupon sudah tidak valid lagi pas submit (misal keburu habis kuota)
            }
        }

        $totalPrice = max(0, $event->price + 5000 - $discount);

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => 'Pending',
        ]);

        if ($coupon) {
            $coupon->increment('used_count');
        }

        // --- INTEGRASI SNAP MIDTRANS ---


        // Konfigurasi Kredensial Environment Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false; // Mode Sandbox!
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Susun Paket Array Data Transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {
            // Perintah Tembak Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update rekaman kita bahwa transaksi terkait sudah memiliki id token pelunasan
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman antarmuka pembayaran final pelanggan
            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        $categories = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        // Transaksi event gratis sudah lunas dari awal, tidak pernah lewat Midtrans -- skip pengecekan API
        if (in_array(strtolower($transaction->status), ['success', 'settlement'])) {
            session(['pending_claim_order_id' => $order_id]);
            return view('checkout.success', compact('transaction', 'categories'));
        }

        session(['pending_claim_order_id' => $order_id]);

        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        // Konfigurasi Midtrans untuk mengecek status transaksi langsung ke API
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            // Mengecek status pesanan secara mandiri (Bypass)
            $status = \Midtrans\Transaction::status($order_id);

            if ($status) {
                // Mengambil nilai status transaksi
                $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');

                // Jika API Midtrans mengonfirmasi bahwa transaksi telah berhasil (settlement / capture)
                if (in_array($trx_status, ['settlement', 'capture'])) {
                    // Hanya lakukan update jika status di database lokal masih 'pending' (indikasi Webhook tidak masuk)
                    if (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'success']);

                        if ($transaction->event && $transaction->event->stock > 0) {
                            $transaction->event->stock = $transaction->event->stock - 1;

                            $transaction->event->save();

                            try {
                                \Illuminate\Support\Facades\Mail::to($transaction->customer_email)
                                    ->send(new \App\Mail\EventTicketMail($transaction));
                            } catch (\Throwable $e) {
                                \Log::error('Gagal mengirim email E-Ticket secara manual (Bypass): ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Jika terjadi error dari API Midtrans (transaksi tidak valid), kembalikan ke beranda
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}
