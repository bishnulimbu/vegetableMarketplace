@extends('layouts.app')

@section('content')
    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl veg-gradient p-8 md:p-12 mb-10 text-center md:text-left">
        <div class="relative z-10">
            <div class="text-5xl mb-4">🥦</div>
            <h1 class="text-4xl font-bold text-white mb-3">{{ $settings['market_name'] ?? __('Digital KrishiBazaar') }}</h1>
            <p class="text-green-100 text-lg max-w-2xl">{{ $settings['market_description'] ?? __('A direct farm-to-consumer platform — cutting out middlemen, fair prices for all.') }}</p>
            <div class="flex flex-wrap gap-3 mt-6 justify-center md:justify-start">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-market-700 font-medium hover:bg-green-50 transition shadow-lg">
                    {{ __('Get Started') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full bg-white/20 px-6 py-3 text-white font-medium hover:bg-white/30 transition backdrop-blur-sm">
                    {{ __('Login') }}
                </a>
            </div>
        </div>
        <div class="absolute -top-10 -right-10 w-56 h-56 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-8 -right-8 w-40 h-40 rounded-full bg-white/10"></div>
        <div class="absolute top-6 right-16 text-8xl opacity-10">🥕</div>
    </div>

    {{-- Features --}}
    <div class="grid gap-6 md:grid-cols-3 mb-10">
        <div class="rounded-2xl bg-white border border-green-100 p-6 card-hover">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600 text-2xl mb-4">🥦</div>
            <h2 class="font-semibold text-lg mb-2">{{ __('For Consumers') }}</h2>
            <p class="text-slate-500 mb-4">Browse fresh vegetables, check stock, and shop directly from local vendors.</p>
            <a href="{{ route('register') }}" class="text-market-600 font-medium text-sm hover:text-market-700">Start shopping →</a>
        </div>
        <div class="rounded-2xl bg-white border border-green-100 p-6 card-hover">
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 text-2xl mb-4">🧑‍🌾</div>
            <h2 class="font-semibold text-lg mb-2">{{ __('For Vendors') }}</h2>
            <p class="text-slate-500 mb-4">List your produce, set prices, and manage your inventory with ease.</p>
            <a href="{{ route('register') }}" class="text-market-600 font-medium text-sm hover:text-market-700">Start selling →</a>
        </div>
        <div class="rounded-2xl bg-white border border-green-100 p-6 card-hover">
            <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600 text-2xl mb-4">⚙️</div>
            <h2 class="font-semibold text-lg mb-2">{{ __('For Admins') }}</h2>
            <p class="text-slate-500 mb-4">Control marketplace settings, manage platform name and description.</p>
            <a href="{{ route('login') }}" class="text-market-600 font-medium text-sm hover:text-market-700">Admin login →</a>
        </div>
    </div>

    {{-- Info card --}}
    <div class="rounded-2xl bg-white border border-green-100 p-6 text-center">
        <p class="text-sm text-slate-500">
            <strong class="text-slate-700">{{ __('Demo accounts') }}:</strong><br>
            <span class="font-mono text-xs">admin@example.com</span> ·
            <span class="font-mono text-xs">vendor@example.com</span> ·
            <span class="font-mono text-xs">consumer@example.com</span><br>
            {{ __('Password') }}: <strong>password</strong>
        </p>
    </div>
@endsection
