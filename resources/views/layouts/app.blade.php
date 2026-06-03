<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Vegetable Marketplace' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        market: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .veg-gradient { background: linear-gradient(135deg, #166534 0%, #22c55e 100%); }
        .warm-gradient { background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%); }
        .sky-gradient { background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
        .nav-blur { backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-emerald-50 text-slate-900 min-h-screen">
    <nav class="sticky top-0 z-50 bg-white/80 nav-blur border-b border-green-100">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2 font-bold text-xl text-market-700">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a4 4 0 0 1 4 4c0 .5-.1 1-.3 1.5l.3-.5 4 7c.6 1.1.2 2.5-.9 3.1l-.1.1c-1 .6-2.4.2-3-.9l-4-7-.3-.5A4 4 0 0 1 12 2Z"/><path d="M12 2a4 4 0 0 0-4 4c0 .5.1 1 .3 1.5l-.3-.5-4 7c-.6 1.1-.2 2.5.9 3.1l.1.1c1 .6 2.4.2 3-.9l4-7 .3-.5A4 4 0 0 0 12 2Z"/><path d="M16 18c0 2.2-1.8 4-4 4s-4-1.8-4-4"/></svg>
                {{ config('app.name', 'Veggie Market') }}
            </a>
            <div class="flex items-center gap-2 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-full text-slate-700 hover:bg-green-50 hover:text-market-700 transition">Dashboard</a>
                    @if(auth()->user()->role === 'vendor')
                        <a href="{{ route('vendor.products') }}" class="px-4 py-2 rounded-full text-slate-700 hover:bg-green-50 hover:text-market-700 transition">My Products</a>
                    @endif
                    @if(auth()->user()->role === 'consumer')
                        <a href="{{ route('consumer.market') }}" class="px-4 py-2 rounded-full text-slate-700 hover:bg-green-50 hover:text-market-700 transition">Market</a>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.settings') }}" class="px-4 py-2 rounded-full text-slate-700 hover:bg-green-50 hover:text-market-700 transition">Settings</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="ml-2 px-5 py-2 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-100 transition font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 rounded-full text-slate-700 hover:bg-green-50 transition">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 rounded-full veg-gradient text-white hover:opacity-90 transition font-medium">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-800">
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-green-100 bg-white/50 mt-12">
        <div class="max-w-6xl mx-auto px-4 py-6 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'Vegetable Marketplace') }}. Fresh from farm to table.
        </div>
    </footer>
</body>
</html>
