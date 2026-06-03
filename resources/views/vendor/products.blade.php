@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Your Vegetables</h1>
            <p class="text-slate-500 mt-1">Manage your product catalog and stock levels.</p>
        </div>
        <span class="text-sm bg-green-100 text-green-700 px-4 py-2 rounded-full font-medium">{{ $vegetables->count() }} products</span>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
        <div>
            @if($vegetables->isEmpty())
                <div class="rounded-2xl border-2 border-dashed border-green-200 p-16 text-center">
                    <div class="text-7xl mb-4">🌱</div>
                    <h2 class="text-xl font-semibold text-slate-700 mb-2">No products yet</h2>
                    <p class="text-slate-500">Start listing your fresh vegetables using the form.</p>
                </div>
            @else
                <div class="grid gap-5 sm:grid-cols-2">
                    @foreach($vegetables as $vegetable)
                        <div class="rounded-2xl bg-white border border-green-100 overflow-hidden card-hover">
                            <div class="h-40 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-5xl">
                                @if($vegetable->image)
                                    <img src="{{ $vegetable->image }}" alt="{{ $vegetable->name }}" class="w-full h-full object-cover">
                                @else
                                    🥬
                                @endif
                            </div>
                            <div class="p-5">
                                <h2 class="font-semibold text-lg">{{ $vegetable->name }}</h2>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-market-600 font-bold text-xl">${{ number_format($vegetable->price, 2) }}</span>
                                    <span class="text-sm text-slate-500">{{ $vegetable->available_quantity }} in stock</span>
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
                <h2 class="text-lg font-semibold">Add New Vegetable</h2>
            </div>
            <form action="{{ route('vendor.products.store') }}" method="POST" class="space-y-4">
                @csrf
                <label class="block text-sm font-medium text-slate-700">
                    <span>Name</span>
                    <input name="name" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Image URL <span class="text-slate-400 font-normal">(optional)</span></span>
                    <input name="image" type="url" placeholder="https://example.com/veg.jpg" class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Price ($)</span>
                    <input name="price" type="number" step="0.01" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Available Quantity</span>
                    <input name="available_quantity" type="number" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <button type="submit" class="w-full rounded-full veg-gradient px-4 py-3 text-white font-medium hover:opacity-90 transition">Save vegetable</button>
            </form>
        </div>
    </div>
@endsection
