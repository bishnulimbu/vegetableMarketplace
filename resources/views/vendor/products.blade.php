@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ __('Your Vegetables') }}</h1>
            <p class="text-slate-500 mt-1">{{ __('Manage your product catalog and stock levels.') }}</p>
        </div>
        <span class="text-sm bg-green-100 text-green-700 px-4 py-2 rounded-full font-medium">{{ $vegetables->count() }} products</span>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
        <div>
            @if($vegetables->isEmpty())
                <div class="rounded-2xl border-2 border-dashed border-green-200 p-16 text-center">
                    <div class="text-7xl mb-4">🌱</div>
                    <h2 class="text-xl font-semibold text-slate-700 mb-2">{{ __('No products yet') }}</h2>
                    <p class="text-slate-500">Start listing your fresh vegetables using the form.</p>
                </div>
            @else
                <div class="grid gap-5 sm:grid-cols-2">
                    @foreach($vegetables as $vegetable)
                        <div class="rounded-2xl bg-white border border-green-100 overflow-hidden card-hover">
                            <div class="relative h-40 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-5xl">
                                @if($vegetable->first_image)
                                    <img src="{{ $vegetable->first_image }}" alt="{{ $vegetable->name }}" class="w-full h-full object-cover">
                                @else
                                    🥬
                                @endif
                                @if(count($vegetable->all_images) > 1)
                                    <span class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-full">+{{ count($vegetable->all_images) - 1 }}</span>
                                @endif
                            </div>
                            <div class="p-5">
                                <h2 class="font-semibold text-lg">{{ $vegetable->localized_name }}</h2>
                                <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full font-medium
                                    {{ $vegetable->condition === 'Organic' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $vegetable->condition === 'Premium' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $vegetable->condition === 'Fresh' ? 'bg-sky-100 text-sky-700' : '' }}
                                    {{ $vegetable->condition === 'Daily Harvest' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $vegetable->condition === 'Farm Fresh' ? 'bg-orange-100 text-orange-700' : '' }}">
                                    {{ __($vegetable->condition) }}
                                </span>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-market-600 font-bold text-xl">Rs. {{ number_format($vegetable->price, 2) }} <span class="text-sm font-normal text-slate-400">/ kg</span></span>
                                    <span class="text-sm text-slate-500">{{ $vegetable->available_quantity }} kg in stock</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-green-100 p-6 bg-white card-hover">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl veg-gradient flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h2 class="text-lg font-semibold">{{ __('Add New Vegetable') }}</h2>
            </div>
            <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Name') }} (English)</span>
                    <input name="name" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Name') }} (नेपाली) <span class="text-slate-400 font-normal">— auto-translated, optional override</span></span>
                    <input name="name_ne" class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" placeholder="Auto-translated from English if left empty" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Images') }} <span class="text-slate-400 font-normal">(optional, multiple allowed)</span></span>
                    <input name="images[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-market-700 hover:file:bg-green-100 transition cursor-pointer" />
                    <p class="text-xs text-slate-400 mt-1">JPEG, PNG, JPG, GIF or WebP. Max 5MB each.</p>
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Condition') }} <span class="text-rose-500">*</span></span>
                    <select name="condition" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition bg-white">
                        <option value="" disabled selected>{{ __('Select condition') }}</option>
                        <option value="Fresh">{{ __('Fresh') }}</option>
                        <option value="Organic">{{ __('Organic') }}</option>
                        <option value="Premium">{{ __('Premium') }}</option>
                        <option value="Daily Harvest">{{ __('Daily Harvest') }}</option>
                        <option value="Farm Fresh">{{ __('Farm Fresh') }}</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Price') }} (Rs.)</span>
                    <input name="price" type="number" step="0.01" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Available Quantity') }} (kg)</span>
                    <input name="available_quantity" type="number" step="0.1" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <button type="submit" class="w-full rounded-full veg-gradient px-4 py-3 text-white font-medium hover:opacity-90 transition">{{ __('Save vegetable') }}</button>
            </form>
        </div>
    </div>
@endsection
