<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full">
        <h1 class="text-2xl font-black mb-2 text-center">Login</h1>
        <p class="text-slate-500 mb-6 text-center">Selamat datang kembali di AmikomEventHub.</p>

        @if(session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4 text-sm font-medium text-center">
                {{ session('status') }}
            </div>
        @endif

        

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4 mb-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 outline-none" required autofocus>
                @error('email')
                    <p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 outline-none" required>
            </div>
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>
                <a href="{{ route('password.request') }}" class="text-indigo-600 font-semibold hover:underline">Lupa password?</a>
            </div>
            <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Masuk
            </button>
        </form>

        <div class="flex items-center gap-3 mb-6">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="text-xs text-slate-400 font-bold uppercase">atau</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <a href="{{ route('google.redirect') }}"
           class="flex items-center justify-center gap-3 w-full py-3 border-2 border-slate-200 rounded-xl font-bold hover:bg-slate-50 transition mb-6">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
            Lanjutkan dengan Google
        </a>

        

        <p class="text-center text-sm text-slate-500 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Daftar</a>
        </p>
    </div>
</body>
</html>