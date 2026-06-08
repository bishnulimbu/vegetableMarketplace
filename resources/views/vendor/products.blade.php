@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ __('Your Vegetables') }}</h1>
            <p class="text-slate-500 mt-1">{{ __('Manage your product catalog and stock levels.') }}</p>
        </div>
        <span class="text-sm bg-green-100 text-green-700 px-4 py-2 rounded-full font-medium">{{ $vegetables->count() }} {{ __('products') }}</span>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
        <div>
            @if($vegetables->isEmpty())
                <div class="rounded-2xl border-2 border-dashed border-green-200 p-16 text-center">
                    <div class="text-7xl mb-4">🌱</div>
                    <h2 class="text-xl font-semibold text-slate-700 mb-2">{{ __('No products yet') }}</h2>
                    <p class="text-slate-500">{{ __('Start listing your fresh vegetables using the form.') }}</p>
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
                                <div class="flex items-start justify-between gap-2">
                                    <h2 class="font-semibold text-lg">{{ $vegetable->localized_name }}</h2>
                                    <span class="shrink-0 inline-block mt-1 text-xs px-2 py-0.5 rounded-full font-medium
                                        {{ $vegetable->condition === 'Organic' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $vegetable->condition === 'Premium' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $vegetable->condition === 'Fresh' ? 'bg-sky-100 text-sky-700' : '' }}
                                        {{ $vegetable->condition === 'Daily Harvest' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $vegetable->condition === 'Farm Fresh' ? 'bg-orange-100 text-orange-700' : '' }}">
                                        {{ __($vegetable->condition) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-indigo-100 text-indigo-700">{{ __($vegetable->category) }}</span>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-market-600 font-bold text-xl">{{ __('Rs.') }} {{ format_price($vegetable->price) }} <span class="text-sm font-normal text-slate-400">{{ __('/ kg') }}</span></span>
                                    <span class="text-sm text-slate-500">{{ $vegetable->available_quantity }} {{ __('kg') }} {{ __('in stock') }}</span>
                                </div>

                                {{-- Action buttons --}}
                                <div class="flex items-center gap-2 mt-4 pt-3 border-t border-slate-100">
                                    <a href="{{ route('vendor.product.edit', $vegetable) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-market-600 hover:text-market-700 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        {{ __('Edit') }}
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ $vegetable->id }}, '{{ $vegetable->localized_name }}')" class="inline-flex items-center gap-1.5 text-sm font-medium text-rose-500 hover:text-rose-600 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        {{ __('Delete') }}
                                    </button>
                                    <form id="delete-form-{{ $vegetable->id }}" action="{{ route('vendor.product.destroy', $vegetable) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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
                    <span>{{ __('Category') }} <span class="text-rose-500">*</span></span>
                    <select name="category" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition bg-white">
                        <option value="" disabled selected>{{ __('Select category') }}</option>
                        <option value="Vegetables">{{ __('Vegetables') }}</option>
                        <option value="Fruits">{{ __('Fruits') }}</option>
                        <option value="Leafy Greens">{{ __('Leafy Greens') }}</option>
                        <option value="Herbs">{{ __('Herbs') }}</option>
                        <option value="Exotic">{{ __('Exotic') }}</option>
                        <option value="Others">{{ __('Others') }}</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Price') }} ({{ __('Rs.') }})</span>
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

@section('scripts')
<script>
    function confirmDelete(id, name) {
        if (confirm(`{{ __('Are you sure you want to delete') }} "${name}"?`)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection
