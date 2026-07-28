<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Organizer Panel - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex min-h-screen">
    <aside class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
            <span class="text-xl font-bold text-white tracking-tight">Organizer Panel</span>
        </div>
        <nav class="flex-1 space-y-2">
            <a href="{{ route('organizer.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Dashboard
            </a>
            <a href="{{ route('organizer.transactions.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Transaction
            </a>
            <a href="{{ route('organizer.events.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Event
            </a>
            <a href="{{ route('organizer.coupons.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.coupons.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Kupon
            </a>
            <a href="{{ route('organizer.checkin.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.checkin.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                Check-in Scanner
            </a>
        </nav>
        <div class="pt-6 border-t border-indigo-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-indigo-300 hover:text-white transition font-medium text-left">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto w-full">
        <header class="mb-10">
            <h1 class="text-3xl font-black">@yield('page_title', 'Dashboard')</h1>
            <p class="text-slate-500 font-medium">@yield('page_subtitle', 'Selamat datang, ' . auth()->user()->name . '!')</p>
        </header>
        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold text-sm">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm font-medium">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif
        @yield('content')
    </main>
</body>

</html>