@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto text-center">
        <div class="rounded-2xl bg-white border border-green-100 p-8 md:p-12">
            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>

            <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ __('Order Confirmed! 🎉') }}</h1>
            <p class="text-slate-500 mb-2">{{ __("Thank you for your order. Here's a summary.") }}</p>
            <p class="text-sm text-slate-400 mb-8">Order #{{ $order->id }} · {{ $order->created_at->format('M d, Y h:i A') }}</p>

            <div class="rounded-xl bg-slate-50 p-5 text-left mb-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-slate-900">{{ __('Items') }}</span>
                    <span class="text-sm text-slate-500 capitalize">Payment: {{ $order->payment_method }}</span>
                </div>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-xl shrink-0 overflow-hidden">
                                    @if($item->vegetable->first_image)
                                        <img src="{{ $item->vegetable->first_image }}" class="w-full h-full object-cover">
                                    @else
                                        🥬
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-sm text-slate-900">{{ $item->vegetable->localized_name }}</p>
                                    <p class="text-xs text-slate-500">{{ __('Qty') }}: {{ $item->quantity }} {{ __('kg') }} × {{ __('Rs.') }} {{ format_price($item->price) }}</p>
                                </div>
                            </div>
                            <span class="font-medium text-sm">{{ __('Rs.') }} {{ format_price($item->price * $item->quantity) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-slate-200">
                    <span class="font-semibold text-lg">{{ __('Total Paid') }}</span>
                    <span class="font-bold text-market-600 text-xl">{{ __('Rs.') }} {{ format_price($order->total_amount) }}</span>
                </div>
            </div>

            <div class="rounded-xl bg-green-50 border border-green-100 p-4 text-sm text-green-800 mb-6">
                🚚 {{ __('Your order has been placed and is being processed. You will receive updates shortly.') }}
            </div>

            <div class="flex gap-3 justify-center">
                <a href="{{ route('consumer.market') }}" class="rounded-full veg-gradient px-6 py-3 text-white font-medium hover:opacity-90 transition">{{ __('Continue Shopping') }}</a>
                <a href="{{ route('orders.index') }}" class="rounded-full border border-slate-200 px-6 py-3 text-slate-700 font-medium hover:bg-slate-50 transition">{{ __('View Orders') }}</a>
            </div>
        </div>
    </div>
@endsection
