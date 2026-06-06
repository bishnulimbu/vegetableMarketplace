@extends('layouts.app')

@section('content')
    <div class="grid gap-8 lg:grid-cols-[1fr_420px]">
        {{-- Cart Items --}}
        <div>
            <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ __('Checkout') }}</h1>
            <p class="text-slate-500 mb-6">{{ __('Review your order and choose a payment method.') }}</p>

            <div class="space-y-3 mb-8">
                @foreach($cartItems as $item)
                    <div class="rounded-xl bg-white border border-green-100 p-4 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-2xl shrink-0 overflow-hidden">
                            @if($item->vegetable->first_image)
                                <img src="{{ $item->vegetable->first_image }}" class="w-full h-full object-cover">
                            @else
                                🥬
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-900">{{ $item->vegetable->localized_name }}</p>
                            <p class="text-sm text-slate-500">{{ __('Qty') }}: {{ $item->quantity }} {{ __('kg') }} × {{ __('Rs.') }} {{ format_price($item->vegetable->price) }}</p>
                        </div>
                        <p class="font-bold text-market-600">{{ __('Rs.') }} {{ format_price($item->vegetable->price * $item->quantity) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Payment Section --}}
        <div>
            <div class="sticky top-24 rounded-2xl bg-white border border-green-100 p-6">
                <h2 class="text-lg font-semibold mb-2">{{ __('Payment Method') }}</h2>
                <p class="text-sm text-slate-500 mb-5">{{ __('Select a demo payment gateway to complete your order.') }}</p>

                <form action="{{ route('order.place') }}" method="POST" id="paymentForm">
                    @csrf

                    {{-- eSewa --}}
                    <label class="block mb-4 cursor-pointer">
                        <input type="radio" name="payment_method" value="esewa" class="peer hidden" onchange="selectPayment('esewa')">
                        <div class="rounded-xl border-2 border-slate-200 p-4 peer-checked:border-green-500 peer-checked:bg-green-50 transition flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-green-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                eSewa
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">eSewa</p>
                                <p class="text-xs text-slate-500">Pay via eSewa wallet</p>
                            </div>
                            <svg class="w-5 h-5 ml-auto text-green-500 opacity-0 peer-checked:opacity-100 transition" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                    </label>

                    {{-- Khalti --}}
                    <label class="block mb-6 cursor-pointer">
                        <input type="radio" name="payment_method" value="khalti" class="peer hidden" onchange="selectPayment('khalti')">
                        <div class="rounded-xl border-2 border-slate-200 p-4 peer-checked:border-purple-500 peer-checked:bg-purple-50 transition flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-purple-700 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                KHALTI
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Khalti</p>
                                <p class="text-xs text-slate-500">Pay via Khalti digital wallet</p>
                            </div>
                            <svg class="w-5 h-5 ml-auto text-purple-500 opacity-0 peer-checked:opacity-100 transition" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                    </label>

                    {{-- Demo eSewa Modal --}}
                    <div id="esewaModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl max-w-sm w-full p-6 relative animate-in">
                            <button type="button" onclick="closeModal('esewaModal')" class="absolute top-3 right-3 text-slate-400 hover:text-slate-600 text-xl">&times;</button>
                            <div class="text-center mb-5">
                                <div class="w-16 h-16 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-lg mx-auto mb-3">eSewa</div>
                                <h3 class="text-lg font-semibold">Demo eSewa Payment</h3>
                                <p class="text-sm text-slate-500">This is a demo — no real transaction will occur.</p>
                            </div>

                            <div class="space-y-3 text-sm mb-5">
                                <label class="block">
                                    <span class="text-slate-700 font-medium">eSewa ID / Mobile</span>
                                    <input type="text" value="98xxxxxxx" readonly class="mt-1 block w-full rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 text-slate-500">
                                </label>
                                <label class="block">
                                    <span class="text-slate-700 font-medium">MPIN</span>
                                    <input type="password" value="****" readonly class="mt-1 block w-full rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 text-slate-500">
                                </label>
                                <div class="rounded-xl bg-amber-50 border border-amber-200 p-3 text-amber-800 text-xs">
                                    🔒 Demo mode. Click "Pay Now" to simulate payment.
                                </div>
                            </div>

                            <div class="flex justify-between items-center mb-4 pb-3 border-b">
                                <span class="font-medium">Total Amount</span>
                                <span class="font-bold text-lg text-market-600">{{ __('Rs.') }} {{ format_price($total) }}</span>
                            </div>

                            <button type="submit" class="w-full rounded-full bg-green-600 py-3 text-white font-medium hover:bg-green-700 transition">
                                {{ __('Pay') }} {{ __('Rs.') }} {{ format_price($total) }}
                            </button>
                            <button type="button" onclick="closeModal('esewaModal')" class="w-full mt-2 text-sm text-slate-500 hover:text-slate-700 py-2">{{ __('Cancel') }}</button>
                        </div>
                    </div>

                    {{-- Demo Khalti Modal --}}
                    <div id="khaltiModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl max-w-sm w-full p-6 relative">
                            <button type="button" onclick="closeModal('khaltiModal')" class="absolute top-3 right-3 text-slate-400 hover:text-slate-600 text-xl">&times;</button>
                            <div class="text-center mb-5">
                                <div class="w-16 h-16 rounded-full bg-purple-700 flex items-center justify-center text-white font-bold text-lg mx-auto mb-3">K</div>
                                <h3 class="text-lg font-semibold">Demo Khalti Payment</h3>
                                <p class="text-sm text-slate-500">This is a demo — no real transaction will occur.</p>
                            </div>

                            <div class="space-y-3 text-sm mb-5">
                                <label class="block">
                                    <span class="text-slate-700 font-medium">Khalti Number</span>
                                    <input type="text" value="98xxxxxxx" readonly class="mt-1 block w-full rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 text-slate-500">
                                </label>
                                <label class="block">
                                    <span class="text-slate-700 font-medium">Khalti Password</span>
                                    <input type="password" value="********" readonly class="mt-1 block w-full rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 text-slate-500">
                                </label>
                                <div class="rounded-xl bg-amber-50 border border-amber-200 p-3 text-amber-800 text-xs">
                                    🔒 Demo mode. Click "Pay Now" to simulate payment.
                                </div>
                            </div>

                            <div class="flex justify-between items-center mb-4 pb-3 border-b">
                                <span class="font-medium">{{ __('Total Amount') }}</span>
                                <span class="font-bold text-lg text-market-600">{{ __('Rs.') }} {{ format_price($total) }}</span>
                            </div>

                            <button type="submit" class="w-full rounded-full bg-purple-700 py-3 text-white font-medium hover:bg-purple-800 transition">
                                {{ __('Pay') }} {{ __('Rs.') }} {{ format_price($total) }}
                            </button>
                            <button type="button" onclick="closeModal('khaltiModal')" class="w-full mt-2 text-sm text-slate-500 hover:text-slate-700 py-2">{{ __('Cancel') }}</button>
                        </div>
                    </div>
                </form>

                <div class="rounded-xl bg-slate-50 p-4 text-sm">
                    <div class="flex justify-between mb-2">
                        <span class="text-slate-600">{{ __('Subtotal') }}</span>
                        <span class="font-medium">{{ __('Rs.') }} {{ format_price($total) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-slate-200">
                        <span class="font-semibold">{{ __('Total') }}</span>
                        <span class="font-bold text-market-600 text-lg">{{ __('Rs.') }} {{ format_price($total) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectPayment(method) {
            document.querySelectorAll('[id$="Modal"]').forEach(m => m.classList.add('hidden'));
            if (method === 'esewa') document.getElementById('esewaModal').classList.remove('hidden');
            if (method === 'khalti') document.getElementById('khaltiModal').classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.querySelectorAll('input[name="payment_method"]').forEach(r => r.checked = false);
        }
    </script>

    <style>
        .animate-in { animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    </style>
@endsection
