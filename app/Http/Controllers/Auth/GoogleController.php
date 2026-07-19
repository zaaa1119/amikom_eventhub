<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Melempar user ke halaman login Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google mengarahkan balik ke sini setelah user setuju
    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (! $user) {
            // Belum punya akun -> daftar otomatis
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(24)), // password acak, tidak dipakai
                'email_verified_at' => now(),
            ]);
        } elseif (! $user->google_id) {
            // Email sudah terdaftar manual -> tautkan ke Google
            $user->update(['google_id' => $googleUser->getId()]);
        }

        Auth::login($user);
        $user->claimPendingTransaction();
        return redirect()->intended('/');
    }
}
