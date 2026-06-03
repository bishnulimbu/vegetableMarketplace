@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="text-center mb-8">
            <div class="text-5xl mb-3">🥬</div>
            <h1 class="text-3xl font-bold text-slate-900">Welcome back</h1>
            <p class="text-slate-500 mt-1">Log in to continue shopping fresh.</p>
        </div>

        <div class="rounded-2xl bg-white border border-green-100 p-8">
            <form method="POST" action="{{ route('login.perform') }}" class="space-y-5">
                @csrf
                <label class="block text-sm font-medium text-slate-700">
                    <span>Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Password</span>
                    <input name="password" type="password" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <button type="submit" class="w-full rounded-full veg-gradient px-4 py-3 text-white font-medium hover:opacity-90 transition">Log in</button>
            </form>
            <p class="mt-5 text-sm text-center text-slate-500">Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-market-600 hover:text-market-700">Register here</a>.</p>
        </div>

        <div class="mt-6 rounded-xl bg-green-50 border border-green-100 p-4">
            <p class="text-xs text-slate-500 text-center">
                <strong class="text-slate-700">Demo accounts:</strong><br>
                admin@example.com / vendor@example.com / consumer@example.com<br>
                Password: <strong>password</strong>
            </p>
        </div>
    </div>
@endsection
