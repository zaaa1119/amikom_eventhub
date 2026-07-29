<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Mail\CertificateMail;
use App\Models\Certificate;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index(Event $event)
    {
        $this->authorizeOwnership($event);

        abort_unless($event->certificate_enabled, 404, 'Sertifikat tidak diaktifkan untuk event ini.');

        $participants = $event->transactions()
            ->whereNotNull('checked_in_at')
            ->with('certificate')
            ->orderBy('customer_name')
            ->get();

        return view('organizer.certificates.index', compact('event', 'participants'));
    }

    public function send(Request $request, Event $event)
    {
        $this->authorizeOwnership($event);
        abort_unless($event->certificate_enabled, 404);

        $request->validate(['transaction_ids' => 'required|array']);

        $sent = 0;

        foreach ($request->transaction_ids as $transactionId) {
            $transaction = $event->transactions()->find($transactionId);
            if (! $transaction || ! $transaction->checked_in_at) {
                continue;
            }

            $certificate = $transaction->certificate ?? Certificate::create([
                'transaction_id' => $transaction->id,
                'certificate_code' => Str::upper(Str::random(10)),
                'type' => 'peserta',
            ]);

            try {
                Mail::to($transaction->customer_email)->send(new CertificateMail($certificate));
                $certificate->update(['sent_at' => now()]);
                $sent++;
            } catch (\Exception $e) {
                \Log::error('Gagal kirim sertifikat: ' . $e->getMessage());
            }
        }

        return redirect()->route('organizer.certificates.index', $event)
            ->with('success', "$sent sertifikat berhasil dikirim.");
    }

    public function preview(\App\Models\Transaction $transaction)
    {
        $event = $transaction->event;
        $this->authorizeOwnership($event);

        $code = $transaction->certificate->certificate_code ?? 'PREVIEW-' . Str::upper(Str::random(8));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.template', [
            'event' => $event,
            'participantName' => $transaction->customer_name,
            'certificateCode' => $code,
            'verifyUrl' => route('certificate.verify', $code),
        ])->setPaper('a4', 'landscape')
            ->setOptions([
                'isRemoteEnabled' => true,
                'dpi' => 72,
            ]);

        return $pdf->stream('preview-sertifikat.pdf');
    }

    private function authorizeOwnership(Event $event): void
    {
        abort_if($event->partner_id !== auth()->user()->partner_id, 403, 'Event ini bukan milik kamu.');
    }
}
