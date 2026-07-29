<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #334155;">
    <h2>Sertifikat Kamu Sudah Terbit! 🎉</h2>
    <p>Halo {{ $certificate->transaction->customer_name }},</p>
    <p>
        Terima kasih sudah berpartisipasi di acara
        <strong>{{ $certificate->transaction->event->title }}</strong>.
        E-Sertifikat kamu terlampir di email ini dalam format PDF.
    </p>
    <p style="font-size: 12px; color: #94a3b8;">
        Kode verifikasi: {{ $certificate->certificate_code }}
    </p>
</body>
</html>