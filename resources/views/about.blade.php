@extends('layouts.app')

@section('content')
    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl veg-gradient p-8 md:p-12 mb-10 text-center">
        <div class="relative z-10">
            <div class="text-6xl mb-4">🌾</div>
            <h1 class="text-4xl font-bold text-white mb-3">{{ __('About') }} Digital KrishiBazaar</h1>
            <p class="text-green-100 text-lg max-w-2xl mx-auto">{{ __('A direct farm-to-consumer marketplace — empowering farmers, fair prices for all.') }}</p>
        </div>
        <div class="absolute -top-10 -right-10 w-56 h-56 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-8 -right-8 w-40 h-40 rounded-full bg-white/10"></div>
        <div class="absolute top-6 left-16 text-8xl opacity-10">🚜</div>
    </div>

    {{-- Mission --}}
    <div class="grid gap-8 md:grid-cols-2 mb-10">
        <div class="rounded-2xl bg-white border border-green-100 p-8 card-hover">
            <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center text-green-600 text-3xl mb-5">🎯</div>
            <h2 class="text-2xl font-bold text-slate-900 mb-3">{{ __('Our Mission') }}</h2>
            <p class="text-slate-600 leading-relaxed">
                {{ __('Digital KrishiBazaar was built with a single mission: to eliminate the middlemen who drive up vegetable prices and cut into farmers earnings. We connect farmers directly with consumers, ensuring that farmers get fair prices for their hard work and consumers pay only for the produce — not inflated margins.') }}
            </p>
        </div>
        <div class="rounded-2xl bg-white border border-green-100 p-8 card-hover">
            <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 text-3xl mb-5">👨‍🌾</div>
            <h2 class="text-2xl font-bold text-slate-900 mb-3">{{ __('For the Farmers') }}</h2>
            <p class="text-slate-600 leading-relaxed">
                {{ __('Farmers are the backbone of our nation, yet they often receive only a fraction of the final market price. Traditional supply chains involve multiple intermediaries — each taking a cut. Digital KrishiBazaar gives farmers a direct digital storefront to list their produce, set their own prices, and reach consumers without exploitation.') }}
            </p>
        </div>
    </div>

    {{-- Problem & Solution --}}
    <div class="rounded-2xl bg-white border border-green-100 overflow-hidden mb-10">
        <div class="grid md:grid-cols-2">
            {{-- The Problem --}}
            <div class="p-8 bg-rose-50">
                <div class="text-4xl mb-4">📉</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ __('The Problem') }}</h3>
                <ul class="space-y-3 text-slate-600">
                    <li class="flex items-start gap-3">
                        <span class="text-rose-500 mt-0.5">✕</span>
                        <span>{{ __('Multiple layers of middlemen inflate vegetable prices by') }} <strong>{{ __('200–400%') }}</strong></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-rose-500 mt-0.5">✕</span>
                        <span>{{ __('Farmers receive less than') }} <strong>{{ __('20%') }}</strong> {{ __('of what consumers pay') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-rose-500 mt-0.5">✕</span>
                        <span>{{ __('Lack of transparency in pricing and sourcing') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-rose-500 mt-0.5">✕</span>
                        <span>{{ __('Perishable produce goes to waste due to delayed market access') }}</span>
                    </li>
                </ul>
            </div>
            {{-- The Solution --}}
            <div class="p-8 bg-green-50">
                <div class="text-4xl mb-4">📈</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ __('The Solution') }}</h3>
                <ul class="space-y-3 text-slate-600">
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>{{ __('Farmers list and sell directly to consumers') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>{{ __('Farmers set their own fair prices — no intermediaries') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>{{ __('Full transparency — see exactly which farm your food comes from') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>{{ __('Consumers get fresh, affordable produce straight from the source') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- How It Works --}}
    <div class="rounded-2xl bg-white border border-green-100 p-8 mb-10">
        <h2 class="text-2xl font-bold text-slate-900 mb-8 text-center">{{ __('How It Works') }}</h2>
        <div class="grid gap-8 md:grid-cols-3">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full veg-gradient flex items-center justify-center text-white text-2xl mx-auto mb-4">1</div>
                <h3 class="font-semibold text-lg mb-2">{{ __('Farmers Register') }}</h3>
                <p class="text-slate-500 text-sm">{{ __('Farmers create an account and set up their digital storefront with their produce listings.') }}</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 rounded-full veg-gradient flex items-center justify-center text-white text-2xl mx-auto mb-4">2</div>
                <h3 class="font-semibold text-lg mb-2">{{ __('Consumers Browse') }}</h3>
                <p class="text-slate-500 text-sm">{{ __('Consumers browse fresh vegetables, filter by condition or vendor, and add to cart.') }}</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 rounded-full veg-gradient flex items-center justify-center text-white text-2xl mx-auto mb-4">3</div>
                <h3 class="font-semibold text-lg mb-2">{{ __('Direct Purchase') }}</h3>
                <p class="text-slate-500 text-sm">{{ __('Orders go directly to the farmer. No middlemen, no hidden markups — just fair trade.') }}</p>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="rounded-2xl veg-gradient p-8 md:p-12 text-center">
        <h2 class="text-3xl font-bold text-white mb-3">{{ __('Ready to join the change?') }}</h2>
        <p class="text-green-100 mb-6 max-w-xl mx-auto">{{ __("Whether you're a farmer looking to sell directly or a consumer wanting fresh, fair-priced vegetables — Digital KrishiBazaar is for you.") }}</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-market-700 font-medium hover:bg-green-50 transition shadow-lg">
                {{ __('Get Started') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full bg-white/20 px-6 py-3 text-white font-medium hover:bg-white/30 transition backdrop-blur-sm">{{ __('Log In') }}</a>
        </div>
    </div>
@endsection
