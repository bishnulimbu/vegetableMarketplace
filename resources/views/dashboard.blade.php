@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <div class="relative overflow-hidden rounded-3xl veg-gradient p-8 md:p-12 mb-8">
        <div class="relative z-10">
            <div class="flex items-center gap-2 text-green-100 text-sm font-medium mb-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                <span>{{ ucfirst($user->role) }} {{ $user->isConsumer() ? __('Home') : __('Dashboard') }}</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">{{ __('Welcome back') }}, {{ $user->name }}!</h1>
            <p class="text-green-100 text-lg max-w-xl">{{ __("We're glad to see you. Everything fresh and organic is just a click away.") }}</p>
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
        use App\Models\OrderItem;
        $totalUsers = User::count();
        $totalVeggies = Vegetable::count();
        $myProducts = $user->role === 'vendor' ? $user->vegetables()->count() : 0;
    @endphp

    <div class="grid gap-5 {{ $user->isConsumer() ? 'md:grid-cols-1' : ($user->isVendor() ? 'md:grid-cols-4' : 'md:grid-cols-3') }} mb-8">
        @if($user->isVendor())
            {{-- Vendor: Products Sold --}}
            @php
                $vendorProductIds = $user->vegetables()->pluck('id');
                $productsSold = OrderItem::whereIn('vegetable_id', $vendorProductIds)->sum('quantity');
                $totalOrders = OrderItem::whereIn('vegetable_id', $vendorProductIds)
                    ->distinct('order_id')
                    ->count('order_id');
                $totalEarnings = OrderItem::whereIn('vegetable_id', $vendorProductIds)
                    ->selectRaw('SUM(quantity * price) as total')
                    ->value('total') ?? 0;
            @endphp
            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">{{ __('Products Sold') }}</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $productsSold }} <span class="text-sm font-normal text-slate-400">{{ __('kg') }}</span></p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">{{ __('Total Orders') }}</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">{{ __('Earnings') }}</p>
                        <p class="text-2xl font-bold text-slate-900">{{ __('Rs.') }} {{ format_price($totalEarnings) }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">{{ __('My Products') }}</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $myProducts }}</p>
                    </div>
                </div>
            </div>
        @elseif(!$user->isConsumer())
            {{-- Admin stats --}}
            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">{{ __('Total Users') }}</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">{{ __('Total Listings') }}</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalVeggies }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">{{ __('Role') }}</p>
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
                    <h2 class="text-lg font-semibold">{{ __('Marketplace Settings') }}</h2>
                </div>
                <p class="text-slate-600 mb-5">{{ __('Manage the marketplace name, description, and overall configuration.') }}</p>
                <a href="{{ route('admin.settings') }}" class="inline-flex items-center gap-2 rounded-full veg-gradient px-5 py-2.5 text-white font-medium hover:opacity-90 transition">
                    {{ __('Open Settings') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>

            <div class="rounded-2xl bg-white p-6 border border-green-100 card-hover">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl warm-gradient flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h2 class="text-lg font-semibold">{{ __('Platform Overview') }}</h2>
                </div>
                <p class="text-slate-600 mb-5">{{ __('You have') }} <strong>{{ $totalUsers }}</strong> {{ __('users and') }} <strong>{{ $totalVeggies }}</strong> {{ __('vegetable listings across the platform.') }}</p>
                <div class="flex gap-3 text-sm">
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">{{ $totalUsers }} {{ __('Users') }}</span>
                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 font-medium">{{ $totalVeggies }} {{ __('Listings') }}</span>
                </div>
            </div>
        </div>

    @elseif($user->role === 'vendor')
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
            <div class="col-span-full">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ __('Your Inventory') }}</h2>
                <p class="text-slate-500 mb-6">{{ __('Manage your vegetable listings and keep your stock up to date.') }}</p>
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
                        <h3 class="font-semibold text-lg">{{ $product->localized_name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $product->condition === 'Organic' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $product->condition === 'Premium' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $product->condition === 'Fresh' ? 'bg-sky-100 text-sky-700' : '' }}
                                {{ $product->condition === 'Daily Harvest' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $product->condition === 'Farm Fresh' ? 'bg-orange-100 text-orange-700' : '' }}">
                                {{ __($product->condition) }}
                            </span>
                            <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium bg-indigo-100 text-indigo-700">{{ __($product->category) }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-market-600 font-bold text-xl">{{ __('Rs.') }} {{ format_price($product->price) }} <span class="text-sm font-normal text-slate-400">{{ __('/ kg') }}</span></span>
                            <span class="text-sm text-slate-500">{{ $product->available_quantity }} {{ __('kg') }} {{ __('in stock') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border-2 border-dashed border-green-200 p-10 text-center">
                    <div class="text-6xl mb-4">🌱</div>
                    <h3 class="text-lg font-semibold text-slate-700 mb-2">{{ __('No products yet') }}</h3>
                    <p class="text-slate-500 mb-5">{{ __('Start adding your fresh vegetables to the marketplace.') }}</p>
                    <a href="{{ route('vendor.products') }}" class="inline-flex items-center gap-2 rounded-full veg-gradient px-6 py-3 text-white font-medium hover:opacity-90 transition">
                        {{ __('Add Your First Product') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </a>
                </div>
            @endforelse
        </div>

        <div class="rounded-2xl veg-gradient p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                    <h3 class="text-white font-semibold text-lg">{{ __('Want to add more products?') }}</h3>
                <p class="text-green-100 text-sm">{{ __('Head to your product management page.') }}</p>
            </div>
            <a href="{{ route('vendor.products') }}" class="shrink-0 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-market-700 font-medium hover:bg-green-50 transition">
                {{ __('Manage Products') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>

    @else
        {{-- Consumer Dashboard --}}
        @php
            $categoryIcons = [
                'Vegetables' => '🥦',
                'Fruits' => '🍎',
                'Leafy Greens' => '🥬',
                'Herbs' => '🌿',
                'Exotic' => '🥭',
                'Others' => '🌱',
            ];
            $categoryColors = [
                'Vegetables' => 'from-green-100 to-emerald-100',
                'Fruits' => 'from-rose-100 to-orange-100',
                'Leafy Greens' => 'from-lime-100 to-green-100',
                'Herbs' => 'from-purple-100 to-violet-100',
                'Exotic' => 'from-amber-100 to-yellow-100',
                'Others' => 'from-sky-100 to-blue-100',
            ];
        @endphp

        {{-- Location notice --}}
        <div id="dashboardLocationBanner" class="mb-6 {{ $useBrowserLocation ? '' : 'hidden' }}">
            <div class="flex items-center gap-3 rounded-xl bg-sky-50 border border-sky-200 p-4 text-sky-800">
                <svg class="w-5 h-5 shrink-0 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="flex-1 text-sm">{{ __('Showing products near your current location') }}</span>
                <button id="refreshLocation" class="shrink-0 text-xs text-sky-600 hover:text-sky-800 font-medium underline">{{ __('Update') }}</button>
                <button id="clearLocation" class="shrink-0 text-xs text-rose-500 hover:text-rose-700 font-medium">{{ __('Clear') }}</button>
            </div>
        </div>

        <div id="dashboardLocationPrompt" class="mb-6 {{ $useBrowserLocation ? 'hidden' : '' }}">
            <div class="flex items-center gap-3 rounded-xl bg-sky-50 border border-sky-200 p-4 text-sky-800">
                <svg class="w-5 h-5 shrink-0 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="flex-1 text-sm">{{ __('Find products near you') }} — <strong>{{ __('Share your location') }}</strong> {{ __('to see nearby vendors first.') }}</span>
                <button id="dashboardAllowLocation" class="shrink-0 rounded-full bg-sky-600 px-5 py-2 text-white text-sm font-medium hover:bg-sky-700 transition">{{ __('Allow') }}</button>
                <button id="dashboardDismissLocation" class="shrink-0 text-sky-500 hover:text-sky-700 text-sm font-medium transition">{{ __('Skip') }}</button>
            </div>
        </div>

        @foreach($grouped as $category => $items)
            <div class="mb-10">
                {{-- Section header --}}
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $categoryIcons[$category] ?? '🌱' }}</span>
                        <h2 class="text-2xl font-bold text-slate-900">{{ __($category) }}</h2>
                        <span class="text-sm bg-slate-100 text-slate-500 px-3 py-1 rounded-full font-medium">{{ $items->count() }} {{ __('items') }}</span>
                    </div>
                    <a href="{{ route('consumer.market', ['category' => $category]) }}" class="text-sm font-medium text-market-600 hover:text-market-700 transition">
                        {{ __('View All') }} &rarr;
                    </a>
                </div>

                {{-- Horizontal scrolling row, limit 5 items --}}
                @php $displayItems = $items->take(5); @endphp
                <div class="flex gap-5 overflow-x-auto pb-3 snap-x snap-mandatory scrollbar-thin">
                    @foreach($displayItems as $vegetable)
                        <a href="{{ route('product.view', $vegetable) }}" class="block shrink-0 w-64 snap-start rounded-2xl bg-white border border-green-100 overflow-hidden card-hover">
                            <div class="relative h-40 bg-gradient-to-br {{ $categoryColors[$category] ?? 'from-green-100 to-emerald-100' }} flex items-center justify-center text-5xl">
                                @if($vegetable->first_image)
                                    <img src="{{ $vegetable->first_image }}" alt="{{ $vegetable->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ $categoryIcons[$category] ?? '🥦' }}
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
                            <div class="p-4">
                                <h2 class="font-semibold text-base text-slate-900 hover:text-market-600 transition truncate">{{ $vegetable->localized_name }}</h2>
                                <p class="text-slate-500 text-xs flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span class="truncate">{{ $vegetable->vendor->name }}</span>
                                    @if(isset($vegetable->distance))
                                        <span class="ml-auto shrink-0 text-xs font-medium {{ $vegetable->distance <= 10 ? 'text-green-600' : 'text-slate-400' }}">
                                            ~{{ $vegetable->distance }} km
                                        </span>
                                    @elseif($vegetable->vendor->city)
                                        <span class="ml-auto shrink-0 inline-flex items-center gap-0.5">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $vegetable->vendor->city }}
                                        </span>
                                    @endif
                                </p>
                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-green-50">
                                    <span class="text-market-600 font-bold text-lg">{{ __('Rs.') }} {{ format_price($vegetable->price) }} <span class="text-xs font-normal text-slate-400">{{ __('/ kg') }}</span></span>
                                    <span class="text-xs {{ $vegetable->available_quantity > 5 ? 'text-green-600' : 'text-rose-500' }}">
                                        {{ $vegetable->available_quantity > 5 ? '✓' : '⚠' }} {{ format_price($vegetable->available_quantity) }} {{ __('kg') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach

                    {{-- Explore More card at the end of the row --}}
                    @if($items->count() > 5)
                        <a href="{{ route('consumer.market', ['category' => $category]) }}" class="shrink-0 w-64 snap-start rounded-2xl border-2 border-dashed border-green-200 bg-white/60 flex flex-col items-center justify-center gap-2 p-6 hover:bg-green-50 hover:border-market-400 transition group">
                            <span class="text-3xl group-hover:scale-110 transition-transform">{{ $categoryIcons[$category] ?? '🌱' }}</span>
                            <span class="text-sm font-medium text-market-600">{{ __('Explore More') }}</span>
                            <span class="text-xs text-slate-400">+{{ $items->count() - 5 }} {{ __('more') }}</span>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="rounded-2xl sky-gradient p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                    <h3 class="text-white font-semibold text-lg">{{ __('Browse the full market') }}</h3>
                <p class="text-sky-100 text-sm">{{ __('See everything vendors have to offer.') }}</p>
            </div>
            <a href="{{ route('consumer.market') }}" class="shrink-0 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sky-700 font-medium hover:bg-sky-50 transition">
                {{ __('Visit Market') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    @endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const prompt = document.getElementById('dashboardLocationPrompt');
    const banner = document.getElementById('dashboardLocationBanner');
    const allowBtn = document.getElementById('dashboardAllowLocation');
    const dismissBtn = document.getElementById('dashboardDismissLocation');
    const refreshBtn = document.getElementById('refreshLocation');
    const clearBtn = document.getElementById('clearLocation');

    // Reload page with browser coordinates
    function goWithLocation(lat, lng) {
        const url = new URL(window.location.href);
        url.searchParams.set('near_lat', lat);
        url.searchParams.set('near_lng', lng);
        window.location.href = url.toString();
    }

    // Reload page without location params
    function clearLocation() {
        const url = new URL(window.location.href);
        url.searchParams.delete('near_lat');
        url.searchParams.delete('near_lng');
        window.location.href = url.toString();
    }

    function requestLocation() {
        if (!navigator.geolocation) {
            alert('{{ __('Geolocation is not supported by your browser.') }}');
            return;
        }
        navigator.geolocation.getCurrentPosition(function (pos) {
            goWithLocation(pos.coords.latitude, pos.coords.longitude);
        }, function () {
            alert('{{ __('Please enable location access to find nearby products.') }}');
            prompt.classList.add('hidden');
        });
    }

    // Only show prompt if not already using browser location
    @if(!$useBrowserLocation)
        // Check if previously dismissed
        let dismissed = false;
        try { dismissed = localStorage.getItem('dash_location_dismissed'); } catch(e) {}
        if (dismissed) {
            prompt.classList.add('hidden');
        }

        allowBtn.addEventListener('click', function () {
            requestLocation();
        });

        dismissBtn.addEventListener('click', function () {
            prompt.classList.add('hidden');
            try { localStorage.setItem('dash_location_dismissed', '1'); } catch(e) {}
        });
    @endif

    // Refresh / Clear buttons when using browser location
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function () {
            requestLocation();
        });
    }
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            clearLocation();
        });
    }
});
</script>
@endsection
