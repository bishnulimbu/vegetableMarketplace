@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ __('Marketplace') }}</h1>
            <p class="text-slate-500 mt-1">{{ __('Browse fresh vegetables from local vendors.') }}</p>
        </div>
        <span class="text-sm bg-green-100 text-green-700 px-4 py-2 rounded-full font-medium">{{ $vegetables->count() }} {{ __('items available') }}</span>
    </div>

    {{-- Search & Filters --}}
    <form method="GET" action="{{ route('consumer.market') }}" class="mb-8 space-y-4">
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search vegetables...') }}" class="w-full rounded-xl border border-slate-200 pl-11 pr-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
            </div>
            {{-- Condition filter --}}
            <select name="condition" class="rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition bg-white min-w-[140px]">
                <option value="">{{ __('All Conditions') }}</option>
                @foreach($conditions as $c)
                    <option value="{{ $c }}" {{ request('condition') === $c ? 'selected' : '' }}>{{ __($c) }}</option>
                @endforeach
            </select>
            {{-- Vendor filter --}}
            <input type="text" name="vendor" value="{{ request('vendor') }}" placeholder="{{ __('Vendor name...') }}" class="rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition min-w-[140px]" />
            {{-- Submit / Reset --}}
            <button type="submit" class="rounded-full veg-gradient px-6 py-3 text-white font-medium hover:opacity-90 transition">{{ __('Filter') }}</button>
            @if(request()->anyFilled(['search', 'condition', 'vendor']))
                <a href="{{ route('consumer.market') }}" class="rounded-full border border-slate-200 px-6 py-3 text-slate-600 font-medium hover:bg-slate-50 transition text-center">{{ __('Clear') }}</a>
            @endif
        </div>
    </form>

    @if($vegetables->isEmpty())
        <div class="rounded-2xl border-2 border-dashed border-green-200 p-16 text-center">
            <div class="text-7xl mb-4">🔍</div>
            <h2 class="text-xl font-semibold text-slate-700 mb-2">{{ __('No matching vegetables') }}</h2>
            <p class="text-slate-500">{{ __('Try adjusting your search or filters.') }}</p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($vegetables as $vegetable)
                <a href="{{ route('product.view', $vegetable) }}" class="block rounded-2xl bg-white border border-green-100 overflow-hidden card-hover">
                    <div class="relative h-48 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-6xl">
                        @if($vegetable->first_image)
                            <img src="{{ $vegetable->first_image }}" alt="{{ $vegetable->name }}" class="w-full h-full object-cover">
                        @else
                            🥦
                        @endif
                        @if(count($vegetable->all_images) > 1)
                            <span class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-full">+{{ count($vegetable->all_images) - 1 }}</span>
                        @endif
                        {{-- Condition badge --}}
                        <span class="absolute top-3 left-3 text-xs px-2.5 py-1 rounded-full font-medium shadow-sm
                            {{ $vegetable->condition === 'Organic' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $vegetable->condition === 'Premium' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $vegetable->condition === 'Fresh' ? 'bg-sky-100 text-sky-700' : '' }}
                            {{ $vegetable->condition === 'Daily Harvest' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $vegetable->condition === 'Farm Fresh' ? 'bg-orange-100 text-orange-700' : '' }}">
                            {{ __($vegetable->condition) }}
                        </span>
                    </div>
                    <div class="p-5">
                        <h2 class="font-semibold text-lg text-slate-900 hover:text-market-600 transition">{{ $vegetable->localized_name }}</h2>
                        <p class="text-slate-500 text-sm flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $vegetable->vendor->name }}
                        </p>
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-green-50">
                            <span class="text-market-600 font-bold text-2xl">{{ __('Rs.') }} {{ format_price($vegetable->price) }} <span class="text-sm font-normal text-slate-400">{{ __('/ kg') }}</span></span>
                            <span class="text-sm {{ $vegetable->available_quantity > 5 ? 'text-green-600' : 'text-rose-500' }}">
                                {{ $vegetable->available_quantity > 5 ? '✓' : '⚠' }} {{ format_price($vegetable->available_quantity) }} {{ __('kg') }} {{ __('in stock') }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
