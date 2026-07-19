<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full">
        <h1 class="text-2xl font-black mb-2 text-center">Buat Akun</h1>
        <p class="text-slate-500 mb-6 text-center">Daftar untuk mulai reservasi tiket event.</p>

        <a href="{{ route('google.redirect') }}"
           class="flex items-center justify-center gap-3 w-full py-3 border-2 border-slate-200 rounded-xl font-bold hover:bg-slate-50 transition mb-6">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
            Daftar dengan Google
        </a>

        <div class="flex items-center gap-3 mb-6">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="text-xs text-slate-400 font-bold uppercase">atau</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 outline-none" required autofocus>
                @error('name')<p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 outline-none" required>
                @error('email')<p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 outline-none" required>
                @error('password')<p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 outline-none" required>
            </div>
            <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Masuk</a>
        </p>
    </div>
</body>
</html>