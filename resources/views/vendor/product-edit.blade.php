@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('vendor.products') }}" class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-900">{{ __('Edit Product') }}</h1>
                <p class="text-slate-500 mt-1">{{ __('Update your vegetable listing details.') }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-green-100 p-6 bg-white card-hover">
            <form action="{{ route('vendor.product.update', $vegetable) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Name (English) --}}
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Name') }} (English) <span class="text-rose-500">*</span></span>
                    <input name="name" value="{{ old('name', $vegetable->name) }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                    @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </label>

                {{-- Name (Nepali) --}}
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Name') }} (नेपाली) <span class="text-slate-400 font-normal">— auto-translated, optional override</span></span>
                    <input name="name_ne" value="{{ old('name_ne', $vegetable->name_ne) }}" class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" placeholder="Auto-translated from English if left empty" />
                    @error('name_ne') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </label>

                {{-- Condition --}}
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Condition') }} <span class="text-rose-500">*</span></span>
                    <select name="condition" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition bg-white">
                        <option value="Fresh" {{ $vegetable->condition === 'Fresh' ? 'selected' : '' }}>{{ __('Fresh') }}</option>
                        <option value="Organic" {{ $vegetable->condition === 'Organic' ? 'selected' : '' }}>{{ __('Organic') }}</option>
                        <option value="Premium" {{ $vegetable->condition === 'Premium' ? 'selected' : '' }}>{{ __('Premium') }}</option>
                        <option value="Daily Harvest" {{ $vegetable->condition === 'Daily Harvest' ? 'selected' : '' }}>{{ __('Daily Harvest') }}</option>
                        <option value="Farm Fresh" {{ $vegetable->condition === 'Farm Fresh' ? 'selected' : '' }}>{{ __('Farm Fresh') }}</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Category') }} <span class="text-rose-500">*</span></span>
                    <select name="category" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition bg-white">
                        <option value="Vegetables" {{ $vegetable->category === 'Vegetables' ? 'selected' : '' }}>{{ __('Vegetables') }}</option>
                        <option value="Fruits" {{ $vegetable->category === 'Fruits' ? 'selected' : '' }}>{{ __('Fruits') }}</option>
                        <option value="Leafy Greens" {{ $vegetable->category === 'Leafy Greens' ? 'selected' : '' }}>{{ __('Leafy Greens') }}</option>
                        <option value="Herbs" {{ $vegetable->category === 'Herbs' ? 'selected' : '' }}>{{ __('Herbs') }}</option>
                        <option value="Exotic" {{ $vegetable->category === 'Exotic' ? 'selected' : '' }}>{{ __('Exotic') }}</option>
                        <option value="Others" {{ $vegetable->category === 'Others' ? 'selected' : '' }}>{{ __('Others') }}</option>
                    </select>
                </label>

                {{-- Price --}}
                <div class="grid grid-cols-2 gap-4">
                    <label class="block text-sm font-medium text-slate-700">
                        <span>{{ __('Price') }} ({{ __('Rs.') }}) <span class="text-rose-500">*</span></span>
                        <input name="price" type="number" step="0.01" value="{{ old('price', $vegetable->price) }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                        @error('price') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </label>
                    <label class="block text-sm font-medium text-slate-700">
                        <span>{{ __('Available Quantity') }} (kg) <span class="text-rose-500">*</span></span>
                        <input name="available_quantity" type="number" step="0.1" value="{{ old('available_quantity', $vegetable->available_quantity) }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                        @error('available_quantity') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </label>
                </div>

                {{-- Current Images --}}
                <div class="block text-sm font-medium text-slate-700">
                    <span class="mb-2 block">{{ __('Current Images') }}</span>
                    @if(count($vegetable->all_images) > 0)
                        <div class="flex flex-wrap gap-3" id="current-images">
                            @foreach($vegetable->all_images as $index => $img)
                                <div class="relative group w-24 h-24 rounded-xl overflow-hidden border border-slate-200" data-index="{{ $index }}">
                                    <img src="{{ $img }}" class="w-full h-full object-cover" alt="">
                                    <button type="button" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition" onclick="removeImage({{ $index }})">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-400 mt-1">{{ __('Hover over an image and click to mark it for removal.') }}</p>
                    @else
                        <p class="text-sm text-slate-400">{{ __('No images uploaded.') }}</p>
                    @endif
                    <input type="hidden" name="remove_images" id="remove_images" value="" />
                </div>

                {{-- Upload New Images --}}
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Add New Images') }} <span class="text-slate-400 font-normal">(optional)</span></span>
                    <input name="images[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-market-700 hover:file:bg-green-100 transition cursor-pointer" />
                    <p class="text-xs text-slate-400 mt-1">JPEG, PNG, JPG, GIF or WebP. Max 5MB each.</p>
                </label>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="rounded-full veg-gradient px-8 py-3 text-white font-medium hover:opacity-90 transition">
                        {{ __('Update Product') }}
                    </button>
                    <a href="{{ route('vendor.products') }}" class="rounded-full border border-slate-200 px-6 py-3 text-slate-600 font-medium hover:bg-slate-50 transition">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let imagesToRemove = [];

    function removeImage(index) {
        if (!imagesToRemove.includes(index)) {
            imagesToRemove.push(index);
        }
        document.getElementById('remove_images').value = imagesToRemove.join(',');
        // Visually mark as removed
        document.querySelector(`[data-index="${index}"]`).classList.add('opacity-30', 'ring-2', 'ring-rose-500');
    }
</script>
@endsection
