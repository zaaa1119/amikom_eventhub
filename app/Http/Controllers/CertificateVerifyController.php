<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateVerifyController extends Controller
{
    public function show(string $code)
    {
        $certificate = Certificate::where('certificate_code', $code)
            ->with(['transaction.event.partner'])
            ->first();

        return view('certificate-verify', compact('certificate'));
    }
}