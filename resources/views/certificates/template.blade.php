<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            width: 842px;
            height: 595px;
            margin: 0;
            padding: 0;
            background: #fdfcf9;
            position: relative;
        }

        .outer-border {
            position: absolute;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;
            border: 2px solid #c9a86a;
        }

        .inner-border {
            position: absolute;
            top: 33px;
            left: 33px;
            right: 33px;
            bottom: 33px;
            border: 1px solid #c9a86a;
        }

        .corner {
            position: absolute;
            width: 40px;
            height: 40px;
        }

        .corner-tl {
            top: 40px;
            left: 40px;
            border-top: 4px solid #4f46e5;
            border-left: 4px solid #4f46e5;
        }

        .corner-tr {
            top: 40px;
            right: 40px;
            border-top: 4px solid #4f46e5;
            border-right: 4px solid #4f46e5;
        }

        .corner-bl {
            bottom: 40px;
            left: 40px;
            border-bottom: 4px solid #4f46e5;
            border-left: 4px solid #4f46e5;
        }

        .corner-br {
            bottom: 40px;
            right: 40px;
            border-bottom: 4px solid #4f46e5;
            border-right: 4px solid #4f46e5;
        }

        .content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            padding-top: 60px;
        }

        .dots {
            margin: 0 auto 8px auto;
        }

        .dots span {
            display: inline-block;
            width: 6px;
            height: 6px;
            background: #c9a86a;
            border-radius: 50%;
            margin: 0 4px;
        }

        .label {
            font-size: 13px;
            letter-spacing: 6px;
            color: #6366f1;
            font-weight: bold;
            margin-top: 8px;
        }

        .title {
            font-size: 38px;
            font-weight: bold;
            color: #1e1b4b;
            margin: 8px 0 25px 0;
            font-family: 'Georgia', serif;
        }

        .given-to {
            font-size: 13px;
            color: #94a3b8;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .name {
            font-size: 36px;
            font-weight: bold;
            color: #1e1b4b;
            margin: 12px 0 8px 0;
            font-family: 'Georgia', serif;
        }

        .name-underline {
            width: 320px;
            height: 2px;
            background: #c9a86a;
            margin: 0 auto 28px auto;
        }

        .desc {
            font-size: 14px;
            color: #475569;
            width: 480px;
            margin: 0 auto;
            line-height: 1.8;
        }

        .event-name {
            font-weight: bold;
            color: #1e1b4b;
        }

        .footer {
            position: absolute;
            bottom: 65px;
            left: 90px;
            display: table;
        }

        .footer-left,
        .footer-text {
            display: table-cell;
            vertical-align: middle;
        }

        .footer-left {
            padding-right: 7px;
        }

        .qr-box img {
            width: 62px;
            height: 62px;
            display: block;
        }

        .footer-text {
            padding-top: 6px;
        }

        .organizer-name-inline {
            font-size: 14px;
            font-weight: bold;
            color: #1e1b4b;
            margin: 0 0 10px 0;
        }

        .code-text {
            font-size: 10px;
            color: #94a3b8;
            letter-spacing: 1px;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="outer-border"></div>
    <div class="inner-border"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    <div class="content">
        @if($event->partner && $event->partner->logo_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->partner->logo_url))
        @php
        $logoData = base64_encode(\Illuminate\Support\Facades\Storage::disk('public')->get($event->partner->logo_url));
        $logoMime = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($event->partner->logo_url);
        @endphp
        <img src="data:{{ $logoMime }};base64,{{ $logoData }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #c9a86a;">
        @else
        <div style="width: 60px; height: 60px; border-radius: 50%; background: #4f46e5; color: white; font-size: 22px; font-weight: bold; text-align: center; line-height: 60px; margin: 0 auto; display: inline-block;">AH</div>
        @endif

        <div class="dots">
            <span></span><span></span><span></span>
        </div>

        <p class="label">SERTIFIKAT PESERTA</p>
        <p class="title">{{ $event->title }}</p>

        <p class="given-to">Dengan bangga diberikan kepada</p>
        <p class="name">{{ $participantName }}</p>
        <div class="name-underline"></div>

        <p class="desc">
            Atas partisipasi dan kontribusinya sebagai peserta dalam acara
            <span class="event-name">{{ $event->title }}</span>
            yang diselenggarakan oleh {{ $event->partner->name ?? 'AmikomEventHub' }}
            pada tanggal {{ $event->date->translatedFormat('d F Y') }}.
        </p>
    </div>

    <div class="footer">
        <div class="footer-left">
            <div class="qr-box">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($verifyUrl) }}">
            </div>
        </div>
        <div class="footer-text">
            <p class="organizer-name-inline">{{ $event->partner->name ?? 'AmikomEventHub' }}</p>
            <p class="code-text">Kode: {{ $certificateCode }}</p>
        </div>
    </div>
</body>

</html>