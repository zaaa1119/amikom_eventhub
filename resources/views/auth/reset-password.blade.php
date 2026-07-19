<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full">
        <h1 class="text-2xl font-black mb-6 text-center">Reset Password</h1>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $email) }}"
                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 outline-none" required>
                @error('email')<p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Password Baru</label>
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
                Reset Password
            </button>
        </form>
    </div>
</body>
</html>