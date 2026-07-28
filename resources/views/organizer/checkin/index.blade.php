@extends('layouts.organizer')
@section('page_title', 'Check-in Scanner')
@section('page_subtitle', 'Arahkan kamera ke QR Code tiket peserta')

@section('content')
<div class="max-w-md mx-auto">
    <div id="reader" class="rounded-2xl overflow-hidden shadow"></div>

    <div id="result" class="mt-6 hidden rounded-2xl p-6 text-center font-bold"></div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    const resultBox = document.getElementById('result');
    let isProcessing = false;

    function showResult(status, message, extra = '') {
        resultBox.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700', 'bg-yellow-100', 'text-yellow-700');
        if (status === 'success') resultBox.classList.add('bg-green-100', 'text-green-700');
        else if (status === 'warning') resultBox.classList.add('bg-yellow-100', 'text-yellow-700');
        else resultBox.classList.add('bg-red-100', 'text-red-700');
        resultBox.innerHTML = message + (extra ? `<br><span class="font-normal text-sm">${extra}</span>` : '');
    }

    function onScanSuccess(decodedText) {
        if (isProcessing) return;
        isProcessing = true;

        fetch('{{ route("organizer.checkin.scan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ order_id: decodedText }),
        })
        .then(res => res.json())
        .then(data => {
            showResult(data.status, data.message, data.name ? `Nama: ${data.name}` : '');
        })
        .finally(() => {
            setTimeout(() => { isProcessing = false; }, 2500); // jeda 2.5 detik sebelum bisa scan lagi
        });
    }

    const scanner = new Html5Qrcode("reader");
    scanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        onScanSuccess
    );
</script>
@endsection