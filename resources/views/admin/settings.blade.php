@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Marketplace Settings</h1>
            <p class="text-slate-500 mt-1">Customize your marketplace name and description.</p>
        </div>
    </div>

    <div class="max-w-2xl rounded-2xl bg-white border border-green-100 p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl veg-gradient flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h2 class="text-lg font-semibold">General Settings</h2>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
            @csrf
            <label class="block text-sm font-medium text-slate-700">
                <span>Market Name</span>
                <input name="market_name" value="{{ old('market_name', $settings['market_name'] ?? 'Digital KrishiBazaar') }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
            </label>

            <label class="block text-sm font-medium text-slate-700">
                <span>Market Description</span>
                <textarea name="market_description" rows="4" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition">{{ old('market_description', $settings['market_description'] ?? 'A direct farm-to-consumer platform — cutting out middlemen, fair prices for all.') }}</textarea>
            </label>

            <button type="submit" class="inline-flex items-center gap-2 rounded-full veg-gradient px-6 py-3 text-white font-medium hover:opacity-90 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Save Settings
            </button>
        </form>
    </div>
@endsection
