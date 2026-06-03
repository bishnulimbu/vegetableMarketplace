@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Marketplace</h1>
            <p class="text-slate-500 mt-1">Browse fresh vegetables from local vendors.</p>
        </div>
        <span class="text-sm bg-green-100 text-green-700 px-4 py-2 rounded-full font-medium">{{ $vegetables->count() }} items available</span>
    </div>

    @if($vegetables->isEmpty())
        <div class="rounded-2xl border-2 border-dashed border-green-200 p-16 text-center">
            <div class="text-7xl mb-4">🥬</div>
            <h2 class="text-xl font-semibold text-slate-700 mb-2">No vegetables right now</h2>
            <p class="text-slate-500">Vendors haven't listed anything yet. Check back soon!</p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($vegetables as $vegetable)
                <div class="rounded-2xl bg-white border border-green-100 overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-6xl">
                        @if($vegetable->image)
                            <img src="{{ $vegetable->image }}" alt="{{ $vegetable->name }}" class="w-full h-full object-cover">
                        @else
                            🥦
                        @endif
                    </div>
                    <div class="p-5">
                        <h2 class="font-semibold text-lg">{{ $vegetable->name }}</h2>
                        <p class="text-slate-500 text-sm flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $vegetable->vendor->name }}
                        </p>
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-green-50">
                            <span class="text-market-600 font-bold text-2xl">${{ number_format($vegetable->price, 2) }}</span>
                            <span class="text-sm {{ $vegetable->available_quantity > 5 ? 'text-green-600' : 'text-rose-500' }}">
                                {{ $vegetable->available_quantity > 5 ? '✓' : '⚠' }} {{ $vegetable->available_quantity }} in stock
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
