@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="text-center mb-8">
            <div class="text-5xl mb-3">🌱</div>
            <h1 class="text-3xl font-bold text-slate-900">Join the market</h1>
            <p class="text-slate-500 mt-1">Create an account and start selling or shopping.</p>
        </div>

        <div class="rounded-2xl bg-white border border-green-100 p-8">
            <form method="POST" action="{{ route('register.perform') }}" class="space-y-4">
                @csrf
                <label class="block text-sm font-medium text-slate-700">
                    <span>Name</span>
                    <input name="name" type="text" value="{{ old('name') }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Password</span>
                    <input name="password" type="password" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Confirm Password</span>
                    <input name="password_confirmation" type="password" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Account type</span>
                    <select name="role" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition">
                        <option value="consumer" {{ old('role') === 'consumer' ? 'selected' : '' }}>🥦 Consumer — Shop for vegetables</option>
                        <option value="vendor" {{ old('role') === 'vendor' ? 'selected' : '' }}>🧑‍🌾 Vendor — Sell your produce</option>
                    </select>
                </label>
                <button type="submit" class="w-full rounded-full veg-gradient px-4 py-3 text-white font-medium hover:opacity-90 transition">Create account</button>
            </form>
            <p class="mt-5 text-sm text-center text-slate-500">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-market-600 hover:text-market-700">Log in here</a>.</p>
        </div>
    </div>
@endsection
