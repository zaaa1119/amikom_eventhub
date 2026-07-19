<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full">
        <h1 class="text-2xl font-black mb-2 text-center">Lupa Password</h1>
        <p class="text-slate-500 mb-6 text-center text-sm">Masukkan email kamu, kami kirimkan link reset password.</p>

        @if(session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4 text-sm font-medium text-center">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 outline-none" required autofocus>
                @error('email')<p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>@enderror
            </div>
            <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Kirim Link Reset
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Kembali ke Masuk</a>
        </p>
    </div>
</body>
</html>