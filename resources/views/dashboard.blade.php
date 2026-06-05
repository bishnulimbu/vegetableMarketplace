@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <div class="relative overflow-hidden rounded-3xl veg-gradient p-8 md:p-12 mb-8">
        <div class="relative z-10">
            <div class="flex items-center gap-2 text-green-100 text-sm font-medium mb-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                <span>{{ ucfirst($user->role) }} Dashboard</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Welcome back, {{ $user->name }}!</h1>
            <p class="text-green-100 text-lg max-w-xl">We're glad to see you. Everything fresh and organic is just a click away.</p>
        </div>
        {{-- Decorative circles --}}
        <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full bg-white/10"></div>
        <div class="absolute top-4 right-20 text-7xl opacity-10">🥦</div>
    </div>

    {{-- Stats Cards --}}
    @php
        use App\Models\User;
        use App\Models\Vegetable;
        $totalUsers = User::count();
        $totalVeggies = Vegetable::count();
        $myProducts = $user->role === 'vendor' ? $user->vegetables()->count() : 0;
    @endphp

    <div class="grid gap-5 {{ $user->isConsumer() ? 'md:grid-cols-1' : 'md:grid-cols-3' }} mb-8">
        @if(!$user->isConsumer())
        <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm">Total Users</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        @endif
        <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm">{{ $user->isAdmin() ? 'Total Listings' : ($user->isVendor() ? 'My Products' : 'Available Items') }}</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $user->isVendor() ? $myProducts : $totalVeggies }}</p>
                </div>
            </div>
        </div>
        @if(!$user->isConsumer())
        <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm">Role</p>
                    <p class="text-2xl font-bold text-slate-900 capitalize">{{ $user->role }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Role-specific content --}}
    @if($user->role === 'admin')
        <div class="grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl veg-gradient flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h2 class="text-lg font-semibold">Marketplace Settings</h2>
                </div>
                <p class="text-slate-600 mb-5">Manage the marketplace name, description, and overall configuration.</p>
                <a href="{{ route('admin.settings') }}" class="inline-flex items-center gap-2 rounded-full veg-gradient px-5 py-2.5 text-white font-medium hover:opacity-90 transition">
                    Open Settings
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>

            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl warm-gradient flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h2 class="text-lg font-semibold">Platform Overview</h2>
                </div>
                <p class="text-slate-600 mb-5">You have <strong>{{ $totalUsers }}</strong> users and <strong>{{ $totalVeggies }}</strong> vegetable listings across the platform.</p>
                <div class="flex gap-3 text-sm">
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">{{ $totalUsers }} Users</span>
                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 font-medium">{{ $totalVeggies }} Listings</span>
                </div>
            </div>
        </div>

    @elseif($user->role === 'vendor')
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
            <div class="col-span-full">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Your Inventory</h2>
                <p class="text-slate-500 mb-6">Manage your vegetable listings and keep your stock up to date.</p>
            </div>

            @php $products = $user->vegetables()->orderByDesc('created_at')->get(); @endphp

            @forelse($products as $product)
                <div class="rounded-2xl bg-white border border-green-100 overflow-hidden card-hover">
                    <div class="relative h-44 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-6xl">
                        @if($product->first_image)
                            <img src="{{ $product->first_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            🥬
                        @endif
                        @if(count($product->all_images) > 1)
                            <span class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-full">+{{ count($product->all_images) - 1 }}</span>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                        <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full font-medium
                            {{ $product->condition === 'Organic' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $product->condition === 'Premium' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $product->condition === 'Fresh' ? 'bg-sky-100 text-sky-700' : '' }}
                            {{ $product->condition === 'Daily Harvest' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $product->condition === 'Farm Fresh' ? 'bg-orange-100 text-orange-700' : '' }}">
                            {{ $product->condition }}
                        </span>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-market-600 font-bold text-xl">Rs. {{ number_format($product->price, 2) }} <span class="text-sm font-normal text-slate-400">/ kg</span></span>
                            <span class="text-sm text-slate-500">{{ $product->available_quantity }} kg in stock</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border-2 border-dashed border-green-200 p-10 text-center">
                    <div class="text-6xl mb-4">🌱</div>
                    <h3 class="text-lg font-semibold text-slate-700 mb-2">No products yet</h3>
                    <p class="text-slate-500 mb-5">Start adding your fresh vegetables to the marketplace.</p>
                    <a href="{{ route('vendor.products') }}" class="inline-flex items-center gap-2 rounded-full veg-gradient px-6 py-3 text-white font-medium hover:opacity-90 transition">
                        Add Your First Product
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </a>
                </div>
            @endforelse
        </div>

        <div class="rounded-2xl veg-gradient p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-white font-semibold text-lg">Want to add more products?</h3>
                <p class="text-green-100 text-sm">Head to your product management page.</p>
            </div>
            <a href="{{ route('vendor.products') }}" class="shrink-0 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-market-700 font-medium hover:bg-green-50 transition">
                Manage Products
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>

    @else
        {{-- Consumer Dashboard --}}
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
            <div class="col-span-full">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Fresh Picks</h2>
                <p class="text-slate-500 mb-6">Check out what's available in the marketplace right now.</p>
            </div>

            @php $latestVeggies = App\Models\Vegetable::with('vendor')->where('available_quantity', '>', 0)->latest()->take(3)->get(); @endphp

            @forelse($latestVeggies as $veg)
                <a href="{{ route('product.view', $veg) }}" class="rounded-2xl bg-white border border-green-100 overflow-hidden card-hover">
                    <div class="relative h-44 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-6xl">
                        @if($veg->first_image)
                            <img src="{{ $veg->first_image }}" alt="{{ $veg->name }}" class="w-full h-full object-cover">
                        @else
                            🥕
                        @endif
                        @if(count($veg->all_images) > 1)
                            <span class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-full">+{{ count($veg->all_images) - 1 }}</span>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-lg">{{ $veg->name }}</h3>
                        <p class="text-slate-500 text-sm mb-1">by {{ $veg->vendor->name }}</p>
                        <span class="inline-block mb-2 text-xs px-2 py-0.5 rounded-full font-medium
                            {{ $veg->condition === 'Organic' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $veg->condition === 'Premium' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $veg->condition === 'Fresh' ? 'bg-sky-100 text-sky-700' : '' }}
                            {{ $veg->condition === 'Daily Harvest' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $veg->condition === 'Farm Fresh' ? 'bg-orange-100 text-orange-700' : '' }}">
                            {{ $veg->condition }}
                        </span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-market-600 font-bold text-xl">Rs. {{ number_format($veg->price, 2) }} <span class="text-sm font-normal text-slate-400">/ kg</span></span>
                            <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-full">{{ $veg->available_quantity }} kg left</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full rounded-2xl border-2 border-dashed border-green-200 p-10 text-center">
                    <div class="text-6xl mb-4">🛒</div>
                    <h3 class="text-lg font-semibold text-slate-700 mb-2">Nothing available yet</h3>
                    <p class="text-slate-500">Come back later to see fresh listings.</p>
                </div>
            @endforelse
        </div>

        <div class="rounded-2xl sky-gradient p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-white font-semibold text-lg">Browse the full market</h3>
                <p class="text-sky-100 text-sm">See everything vendors have to offer.</p>
            </div>
            <a href="{{ route('consumer.market') }}" class="shrink-0 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sky-700 font-medium hover:bg-sky-50 transition">
                Visit Market
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    @endif
@endsection
