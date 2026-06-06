@extends('layouts.app')

@php
    $images = $vegetable->all_images;
    $defaultImg = count($images) > 0 ? $images[0] : null;
@endphp

@section('content')
    <div class="grid gap-8 lg:grid-cols-[1fr_420px]">
        {{-- Left: Image Gallery --}}
        <div>
            <div class="rounded-2xl overflow-hidden bg-white border border-green-100">
                {{-- Main Image with Zoom --}}
                <div id="imageZoomContainer" class="relative h-80 md:h-[440px] bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center overflow-hidden cursor-crosshair group">
                    @if($defaultImg)
                        <img id="mainImage" src="{{ $defaultImg }}" alt="{{ $vegetable->name }}" class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-150">
                    @else
                        <span class="text-8xl">🥦</span>
                    @endif
                    {{-- Zoom lens --}}
                    <div id="zoomLens" class="hidden group-hover:block absolute w-32 h-32 bg-white/20 border-2 border-white rounded-full pointer-events-none backdrop-blur-[1px]"></div>
                </div>

                {{-- Thumbnail gallery --}}
                @if(count($images) > 0)
                    <div class="px-6 pb-6 pt-4">
                        <div class="flex gap-3 flex-wrap">
                            @foreach($images as $idx => $img)
                                <button onclick="selectImage(this, '{{ $img }}')" class="w-16 h-16 rounded-xl overflow-hidden border-2 transition {{ $idx === 0 ? 'border-market-500 ring-2 ring-market-200' : 'border-slate-200 hover:border-slate-300' }}">
                                    <img src="{{ $img }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Product info --}}
                <div class="px-6 pb-6">
                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ __('Sold by') }} <strong class="text-slate-700">{{ $vegetable->vendor->name }}</strong>
                    </div>
                    <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $vegetable->localized_name }}</h1>

                    <div class="flex items-baseline gap-3 mb-2">
                        <p class="text-market-600 font-bold text-4xl">{{ __('Rs.') }} {{ format_price($vegetable->price) }}</p>
                        <span class="text-sm text-slate-400">{{ __('/ kg') }}</span>
                    </div>

                    <span class="inline-block mb-4 text-xs px-2.5 py-1 rounded-full font-medium shadow-sm
                        {{ $vegetable->condition === 'Organic' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $vegetable->condition === 'Premium' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $vegetable->condition === 'Fresh' ? 'bg-sky-100 text-sky-700' : '' }}
                        {{ $vegetable->condition === 'Daily Harvest' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $vegetable->condition === 'Farm Fresh' ? 'bg-orange-100 text-orange-700' : '' }}">
                        {{ __($vegetable->condition) }}
                    </span>

                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $vegetable->available_quantity > 0 ? 'bg-green-100 text-green-700' : 'bg-rose-100 text-rose-700' }}">
                            @if($vegetable->available_quantity > 0)
                                {{ format_price($vegetable->available_quantity) }} {{ __('kg') }} {{ __('in stock') }}
                            @else
                                {{ __('out of stock') }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Add to Cart --}}
        <div>
            <div class="sticky top-24 rounded-2xl bg-white border border-green-100 p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Order this item') }}</h2>

                @guest
                    <p class="text-slate-500 mb-4">{{ __('Please log in to purchase.') }} <a href="{{ route('login') }}" class="text-market-600 font-medium">{{ __('log in') }}</a></p>
                @elseif(Auth::user()->role !== 'consumer')
                    <div class="rounded-xl bg-amber-50 border border-amber-200 p-4 text-amber-800 text-sm">
                        {{ __('Only consumers can purchase items.') }} <a href="{{ route('register') }}" class="font-medium underline">{{ __('Create a consumer account') }}</a>.
                    </div>
                @elseif($vegetable->available_quantity < 0.1)
                    <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-700 text-sm">{{ __('This item is currently out of stock.') }}</div>
                @else
                    <form action="{{ route('cart.add', $vegetable) }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="quantity" id="hiddenQty" value="1">

                        {{-- KG Selector --}}
                        <label class="block text-sm font-medium text-slate-700">
                            <span>{{ __('Quantity') }} ({{ __('kg') }})</span>
                            <div class="mt-2 flex items-center gap-3">
                                <button type="button" onclick="adjustKg(-0.5)" class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition text-lg font-medium">−</button>
                                <input id="kgInput" type="number" value="1" min="0.1" step="0.1" max="{{ $vegetable->available_quantity }}"
                                    onchange="syncFromKg()" oninput="syncFromKg()"
                                    class="w-24 text-center rounded-xl border border-slate-200 px-3 py-2.5 text-lg font-semibold focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition">
                                <button type="button" onclick="adjustKg(0.5)" class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition text-lg font-medium">+</button>
                            </div>
                        </label>

                        {{-- Gram quick picks --}}
                        <div>
                            <p class="text-xs text-slate-400 mb-2">{{ __('Quick gram add-ons') }}:</p>
                            <div class="flex gap-2 flex-wrap">
                                @foreach([100, 200, 500] as $g)
                                    <button type="button" onclick="addGrams({{ $g }})"
                                        class="px-3 py-1.5 rounded-full border border-slate-200 text-xs text-slate-600 hover:bg-green-50 hover:border-green-300 transition">
                                        +{{ $g }}g
                                    </button>
                                @endforeach
                                <button type="button" onclick="setKg(1)" class="px-3 py-1.5 rounded-full border border-slate-200 text-xs text-slate-600 hover:bg-green-50 hover:border-green-300 transition">1 kg</button>
                                <button type="button" onclick="setKg(2)" class="px-3 py-1.5 rounded-full border border-slate-200 text-xs text-slate-600 hover:bg-green-50 hover:border-green-300 transition">2 kg</button>
                                <button type="button" onclick="setKg(5)" class="px-3 py-1.5 rounded-full border border-slate-200 text-xs text-slate-600 hover:bg-green-50 hover:border-green-300 transition">5 kg</button>
                            </div>
                        </div>

                        {{-- Price breakdown --}}
                        <div class="rounded-xl bg-slate-50 p-4 space-y-2 text-sm">
                            <div class="flex justify-between text-slate-600">
                                <span>{{ __('Price per kg') }}</span>
                                <span>{{ __('Rs.') }} {{ format_price($vegetable->price) }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>{{ __('Quantity') }}</span>
                                <span id="displayQty">1.00 kg</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-slate-200 text-base">
                                <span class="font-semibold text-slate-900">{{ __('Total') }}</span>
                                <span class="font-bold text-market-600 text-2xl" id="totalPrice">{{ __('Rs.') }} {{ format_price($vegetable->price) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full rounded-full veg-gradient py-3.5 text-white font-medium hover:opacity-90 transition flex items-center justify-center gap-2 text-base">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            {{ __('Add to Cart') }}
                        </button>
                    </form>
                @endif

                <div class="mt-5 pt-4 border-t border-slate-100 space-y-2 text-sm text-slate-500">
                    <div class="flex items-center gap-2">✅ {{ __('Fresh & organic produce') }}</div>
                    <div class="flex items-center gap-2">🚚 {{ __('Free delivery on orders over Rs. 500') }}</div>
                    <div class="flex items-center gap-2">💳 {{ __('Pay with eSewa or Khalti') }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pricePerKg = {{ $vegetable->price }};
        const maxQty = {{ $vegetable->available_quantity }};

        // --- Image gallery ---
        function selectImage(btn, url) {
            document.querySelectorAll('[onclick^="selectImage"]').forEach(el => {
                el.classList.remove('border-market-500', 'ring-2', 'ring-market-200');
                el.classList.add('border-slate-200');
            });
            btn.classList.remove('border-slate-200');
            btn.classList.add('border-market-500', 'ring-2', 'ring-market-200');
            document.getElementById('mainImage').src = url;
        }

        // --- Zoom on mouse move ---
        const zoomContainer = document.getElementById('imageZoomContainer');
        const mainImage = document.getElementById('mainImage');

        if (zoomContainer && mainImage) {
            zoomContainer.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                mainImage.style.transformOrigin = x + '% ' + y + '%';
            });

            zoomContainer.addEventListener('mouseleave', function() {
                mainImage.style.transformOrigin = 'center center';
            });
        }

        // --- Quantity in kg/gram ---
        function syncFromKg() {
            const kg = parseFloat(document.getElementById('kgInput').value) || 0;
            const clamped = Math.min(Math.max(kg, 0.1), maxQty);
            document.getElementById('kgInput').value = clamped.toFixed(1);
            updateOrder(clamped);
        }

        function adjustKg(delta) {
            const input = document.getElementById('kgInput');
            const current = parseFloat(input.value) || 0;
            const next = Math.min(Math.max(current + delta, 0.1), maxQty);
            input.value = next.toFixed(1);
            updateOrder(next);
        }

        function addGrams(grams) {
            const input = document.getElementById('kgInput');
            const current = parseFloat(input.value) || 0;
            const next = Math.min(Math.max(current + (grams / 1000), 0.1), maxQty);
            input.value = next.toFixed(1);
            updateOrder(next);
        }

        function setKg(kg) {
            const input = document.getElementById('kgInput');
            const val = Math.min(kg, maxQty);
            input.value = val.toFixed(1);
            updateOrder(val);
        }

        function updateOrder(kg) {
            kg = Math.round(kg * 100) / 100;
            const total = (kg * pricePerKg).toFixed(2);
            document.getElementById('hiddenQty').value = kg;
            document.getElementById('displayQty').innerText = kg.toFixed(2) + ' kg';
            document.getElementById('totalPrice').innerText = 'Rs. ' + Number(total).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Init
        updateOrder(1);
    </script>
@endsection
