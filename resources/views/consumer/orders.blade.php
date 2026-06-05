@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">My Orders</h1>
            <p class="text-slate-500 mt-1">Track all your purchases.</p>
        </div>
        <a href="{{ route('consumer.market') }}" class="text-sm text-market-600 hover:text-market-700 font-medium">← Browse market</a>
    </div>

    @if($orders->isEmpty())
        <div class="rounded-2xl border-2 border-dashed border-green-200 p-16 text-center">
            <div class="text-7xl mb-4">📦</div>
            <h2 class="text-xl font-semibold text-slate-700 mb-2">No orders yet</h2>
            <p class="text-slate-500 mb-5">Start shopping at the market.</p>
            <a href="{{ route('consumer.market') }}" class="inline-flex items-center gap-2 rounded-full veg-gradient px-6 py-3 text-white font-medium">Browse Market</a>
        </div>
    @else
        <div class="space-y-5">
            @foreach($orders as $order)
                <div class="rounded-2xl bg-white border border-green-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-semibold text-slate-900">Order #{{ $order->id }}</h3>
                            <p class="text-xs text-slate-400">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 capitalize">{{ $order->status }}</span>
                            <span class="font-bold text-market-600">Rs. {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="flex gap-3 flex-wrap">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3 py-2 text-sm">
                                <span class="w-6 h-6 rounded bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-xs overflow-hidden shrink-0">
                                    @if($item->vegetable->first_image)
                                        <img src="{{ $item->vegetable->first_image }}" class="w-full h-full object-cover">
                                    @else
                                        🥬
                                    @endif
                                </span>
                                <span>{{ $item->vegetable->localized_name }} × {{ $item->quantity }} kg</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 text-xs text-slate-400 capitalize">
                        Payment: {{ $order->payment_method }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
