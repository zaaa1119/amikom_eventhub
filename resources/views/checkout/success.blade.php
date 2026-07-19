@extends('layouts.app')
@section('title', 'Pembayaran Berhasil')
@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-black mb-4">Terima Kasih!</h2>
        <p class="text-slate-500 mb-8 leading-relaxed">
            Pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong> sedang diproses atau telah berhasil.
            E-Ticket akan dikirim ke email Anda (<strong>{{ $transaction->customer_email }}</strong>) setelah pembayaran terkonfirmasi lunas.
        </p>
        @guest
        <div class="mt-6 p-5 bg-indigo-50 rounded-2xl text-left">
            <p class="font-bold text-indigo-700 mb-1">Simpan tiket ini ke akunmu</p>
            <p class="text-sm text-indigo-600 mb-4">Biar tiket ini otomatis masuk ke Riwayat kamu dan bisa kamu review setelah acaranya selesai.</p>
            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-white border-2 border-indigo-200 text-indigo-600 rounded-xl font-bold text-sm hover:bg-indigo-50 transition">
                    Daftar
                </a>
            </div>
        </div>
        @endguest
        <a href="{{ route('home') }}" class="inline-block px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition mt-8">
            Kembali ke Beranda
        </a>
    </div>
</main>
@endsection