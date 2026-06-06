@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ __('Your Cart') }}</h1>
            <p class="text-slate-500 mt-1">{{ $cartItems->count() }} {{ __('item(s) in your cart') }}</p>
        </div>
        <a href="{{ route('consumer.market') }}" class="text-sm text-market-600 hover:text-market-700 font-medium">← {{ __('Continue shopping') }}</a>
    </div>

    @if($cartItems->isEmpty())
        <div class="rounded-2xl border-2 border-dashed border-green-200 p-16 text-center">
            <div class="text-7xl mb-4">🛒</div>
            <h2 class="text-xl font-semibold text-slate-700 mb-2">{{ __('Your cart is empty') }}</h2>
            <p class="text-slate-500 mb-5">{{ __('Browse the market and add items to your cart.') }}</p>
            <a href="{{ route('consumer.market') }}" class="inline-flex items-center gap-2 rounded-full veg-gradient px-6 py-3 text-white font-medium">{{ __('Browse Market') }}</a>
        </div>
    @else
        <div class="grid gap-8 lg:grid-cols-[1fr_380px]">
            <div class="space-y-4">
                @foreach($cartItems as $item)
                    <div class="rounded-2xl bg-white border border-green-100 p-4 flex gap-4 items-center">
                        <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-3xl shrink-0 overflow-hidden">
                            @if($item->vegetable->first_image)
                                <img src="{{ $item->vegetable->first_image }}" class="w-full h-full object-cover">
                            @else
                                🥬
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-slate-900">{{ $item->vegetable->localized_name }}</h3>
                            <p class="text-sm text-slate-500">{{ __('Rs.') }} {{ format_price($item->vegetable->price) }} {{ __('/ kg') }}</p>
                        </div>
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input name="quantity" type="number" step="0.1" value="{{ $item->quantity }}" min="0.1" max="{{ $item->vegetable->available_quantity }}" class="w-20 text-center rounded-lg border border-slate-200 px-2 py-1.5 text-sm" />
                            <button type="submit" class="text-xs text-market-600 hover:text-market-700 font-medium">{{ __('Update') }}</button>
                        </form>
                        <div class="text-right">
                            <p class="font-bold text-market-600">{{ __('Rs.') }} {{ format_price($item->vegetable->price * $item->quantity) }}</p>
                        </div>
                        <form action="{{ route('cart.remove', $item) }}" method="POST" class="ml-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-400 hover:text-rose-600 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="rounded-2xl bg-white border border-green-100 p-6 h-fit">
                <h2 class="text-lg font-semibold mb-4">{{ __('Order Summary') }}</h2>
                @php
                    $subtotal = $cartItems->sum(fn($i) => $i->vegetable->price * $i->quantity);
                    $delivery = $subtotal >= 500 ? 0 : 50;
                @endphp
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-600">{{ __('Subtotal') }}</span>
                        <span class="font-medium">{{ __('Rs.') }} {{ format_price($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">{{ __('Delivery') }}</span>
                        <span class="font-medium">{{ $delivery === 0 ? __('Free') : 'Rs. ' . format_price($delivery) }}</span>
                    </div>
                    <div class="border-t border-green-100 pt-3 flex justify-between text-lg">
                        <span class="font-semibold">{{ __('Total') }}</span>
                        <span class="font-bold text-market-600">{{ __('Rs.') }} {{ format_price($subtotal + $delivery) }}</span>
                    </div>
                </div>
                <a href="{{ route('checkout.show') }}" class="mt-6 w-full rounded-full veg-gradient py-3 text-white font-medium hover:opacity-90 transition flex items-center justify-center gap-2">
                    {{ __('Proceed to Checkout') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        </div>
    @endif
@endsection
