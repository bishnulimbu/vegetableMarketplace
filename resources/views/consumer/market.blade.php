@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ __('Marketplace') }}</h1>
            <p class="text-slate-500 mt-1">{{ __('Browse fresh vegetables from local vendors.') }}</p>
        </div>
        <span class="text-sm bg-green-100 text-green-700 px-4 py-2 rounded-full font-medium">{{ $vegetables->count() }} {{ __('items available') }}</span>
    </div>

    {{-- Location prompt banner --}}
    <div id="locationPrompt" class="mb-6 hidden">
        <div class="flex items-center gap-3 rounded-xl bg-sky-50 border border-sky-200 p-4 text-sky-800">
            <svg class="w-5 h-5 shrink-0 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="flex-1 text-sm">{{ __('Find products near you') }} — <strong>{{ __('Share your location') }}</strong> {{ __('to see nearby vendors.') }}</span>
            <button id="allowLocationBtn" class="shrink-0 rounded-full bg-sky-600 px-5 py-2 text-white text-sm font-medium hover:bg-sky-700 transition">{{ __('Allow') }}</button>
            <button id="dismissLocationBtn" class="shrink-0 text-sky-500 hover:text-sky-700 text-sm font-medium transition">{{ __('Skip') }}</button>
        </div>
    </div>

    {{-- Search & Filters --}}
    <form method="GET" action="{{ route('consumer.market') }}" class="mb-8 space-y-4">
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search vegetables...') }}" class="w-full rounded-xl border border-slate-200 pl-11 pr-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
            </div>
            {{-- Condition filter --}}
            <select name="condition" class="rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition bg-white min-w-[140px]">
                <option value="">{{ __('All Conditions') }}</option>
                @foreach($conditions as $c)
                    <option value="{{ $c }}" {{ request('condition') === $c ? 'selected' : '' }}>{{ __($c) }}</option>
                @endforeach
            </select>
            {{-- Category filter --}}
            <select name="category" class="rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition bg-white min-w-[140px]">
                <option value="">{{ __('All Categories') }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ __($cat) }}</option>
                @endforeach
            </select>
            {{-- Map toggle button --}}
            <button type="button" id="toggleMapBtn" class="rounded-xl border border-slate-200 px-4 py-3 bg-white text-slate-600 font-medium hover:bg-green-50 hover:border-market-300 transition flex items-center gap-2 min-w-[120px] justify-center">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                <span id="mapBtnText">{{ __('Map View') }}</span>
            </button>
            <input type="hidden" name="city" id="cityInput" value="{{ request('city') }}" />
            {{-- Near Me radius --}}
            <select name="radius" class="rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition bg-white min-w-[120px]">
                <option value="">{{ __('Near Me') }}</option>
                <option value="5" {{ request('radius') == '5' ? 'selected' : '' }}>{{ __('Within') }} 5 km</option>
                <option value="10" {{ request('radius') == '10' ? 'selected' : '' }}>{{ __('Within') }} 10 km</option>
                <option value="25" {{ request('radius') == '25' ? 'selected' : '' }}>{{ __('Within') }} 25 km</option>
                <option value="50" {{ request('radius') == '50' ? 'selected' : '' }}>{{ __('Within') }} 50 km</option>
                <option value="100" {{ request('radius') == '100' ? 'selected' : '' }}>{{ __('Within') }} 100 km</option>
            </select>
            <input type="hidden" name="near_lat" id="near_lat" value="{{ request('near_lat', old('near_lat')) }}" />
            <input type="hidden" name="near_lng" id="near_lng" value="{{ request('near_lng', old('near_lng')) }}" />
            {{-- Vendor filter --}}
            <input type="text" name="vendor" value="{{ request('vendor') }}" placeholder="{{ __('Vendor name...') }}" class="rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition min-w-[140px]" />
            {{-- Submit / Reset --}}
            <button type="submit" class="rounded-full veg-gradient px-6 py-3 text-white font-medium hover:opacity-90 transition">{{ __('Filter') }}</button>
            @if(request()->anyFilled(['search', 'condition', 'category', 'city', 'vendor', 'radius']))
                <a href="{{ route('consumer.market') }}" class="rounded-full border border-slate-200 px-6 py-3 text-slate-600 font-medium hover:bg-slate-50 transition text-center">{{ __('Clear') }}</a>
            @endif
        </div>
    </form>

    {{-- Interactive Map --}}
    <div id="marketMapContainer" class="mb-8 hidden">
        <div class="rounded-2xl overflow-hidden border border-green-100 bg-white">
            <div id="marketMap" class="w-full h-80"></div>
            <div class="px-5 py-3 flex items-center justify-between bg-slate-50 border-t border-slate-100">
                <p class="text-sm text-slate-500">
                    <span id="mapVendorCount">{{ count($vendorLocations) }}</span> {{ __('vendor locations') }}
                    @if(request('city'))
                        — <strong>{{ __('Showing') }}: {{ request('city') }}</strong>
                        <a href="{{ route('consumer.market', array_merge(request()->except('city', 'page'))) }}" class="text-rose-500 hover:text-rose-600 ml-2 text-xs">{{ __('Clear') }}</a>
                    @endif
                </p>
                <button id="fitAllMarkers" class="text-xs text-market-600 hover:text-market-700 font-medium">{{ __('Reset view') }}</button>
            </div>
        </div>
    </div>

    @if($vegetables->isEmpty())
        <div class="rounded-2xl border-2 border-dashed border-green-200 p-16 text-center">
            <div class="text-7xl mb-4">🔍</div>
            <h2 class="text-xl font-semibold text-slate-700 mb-2">{{ __('No matching vegetables') }}</h2>
            <p class="text-slate-500">{{ __('Try adjusting your search or filters.') }}</p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($vegetables as $vegetable)
                <a href="{{ route('product.view', $vegetable) }}" class="block rounded-2xl bg-white border border-green-100 overflow-hidden card-hover">
                    <div class="relative h-44 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-5xl">
                        @if($vegetable->first_image)
                            <img src="{{ $vegetable->first_image }}" alt="{{ $vegetable->name }}" class="w-full h-full object-cover">
                        @else
                            🥦
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
                    <div class="p-5">
                        <h2 class="font-semibold text-lg text-slate-900 hover:text-market-600 transition">{{ $vegetable->localized_name }}</h2>
                        <p class="text-slate-500 text-sm flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $vegetable->vendor->name }}
                        </p>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $vegetable->vendor->city ?? __('Unknown location') }}
                            @if(isset($vegetable->distance))
                                <span class="ml-auto text-xs font-medium {{ $vegetable->distance <= 10 ? 'text-green-600' : 'text-slate-400' }}">
                                    ~{{ $vegetable->distance }} km
                                </span>
                            @endif
                        </p>
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-green-50">
                            <span class="text-market-600 font-bold text-2xl">{{ __('Rs.') }} {{ format_price($vegetable->price) }} <span class="text-sm font-normal text-slate-400">{{ __('/ kg') }}</span></span>
                            <span class="text-sm {{ $vegetable->available_quantity > 5 ? 'text-green-600' : 'text-rose-500' }}">
                                {{ $vegetable->available_quantity > 5 ? '✓' : '⚠' }} {{ format_price($vegetable->available_quantity) }} {{ __('kg') }} {{ __('in stock') }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const latInput = document.getElementById('near_lat');
    const lngInput = document.getElementById('near_lng');
    const radiusSelect = document.querySelector('select[name="radius"]');
    const locationPrompt = document.getElementById('locationPrompt');
    const allowBtn = document.getElementById('allowLocationBtn');
    const dismissBtn = document.getElementById('dismissLocationBtn');

    // ─── Location Prompt ───────────────────────────────────────
    if (!latInput.value) {
        locationPrompt.classList.remove('hidden');
    }

    function requestLocation(andSubmit) {
        if (!navigator.geolocation) {
            alert('{{ __('Geolocation is not supported by your browser.') }}');
            return;
        }
        navigator.geolocation.getCurrentPosition(function (pos) {
            latInput.value = pos.coords.latitude;
            lngInput.value = pos.coords.longitude;
            locationPrompt.classList.add('hidden');
            if (andSubmit && radiusSelect.value) {
                radiusSelect.closest('form').submit();
            }
        }, function () {
            alert('{{ __('Please enable location access to find nearby products.') }}');
            locationPrompt.classList.add('hidden');
        });
    }

    allowBtn.addEventListener('click', function () { requestLocation(true); });
    dismissBtn.addEventListener('click', function () {
        locationPrompt.classList.add('hidden');
        try { localStorage.setItem('location_dismissed', '1'); } catch(e) {}
    });
    try {
        if (localStorage.getItem('location_dismissed') && !latInput.value) {
            locationPrompt.classList.add('hidden');
        }
    } catch(e) {}

    radiusSelect.addEventListener('change', function () {
        if (this.value && !latInput.value) requestLocation(true);
    });

    // ─── Interactive Map ───────────────────────────────────────
    const toggleBtn = document.getElementById('toggleMapBtn');
    const mapContainer = document.getElementById('marketMapContainer');
    const mapBtnText = document.getElementById('mapBtnText');
    const cityInput = document.getElementById('cityInput');
    const form = document.querySelector('form');
    let mapInitialized = false;
    let map, markersLayer;

    const vendorLocations = @json($vendorLocations);

    toggleBtn.addEventListener('click', function () {
        mapContainer.classList.toggle('hidden');
        const isVisible = !mapContainer.classList.contains('hidden');
        mapBtnText.textContent = isVisible ? '{{ __("Hide Map") }}' : '{{ __("Map View") }}';

        if (isVisible && !mapInitialized) {
            initMap();
        }
        if (isVisible && mapInitialized) {
            setTimeout(() => map.invalidateSize(), 100);
        }
    });

    function initMap() {
        mapInitialized = true;
        // Default center: Nepal
        const defaultCenter = vendorLocations.length > 0
            ? [vendorLocations[0].lat, vendorLocations[0].lng]
            : [27.7172, 85.3240];

        map = L.map('marketMap', { zoomControl: true, scrollWheelZoom: true }).setView(defaultCenter, 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 18,
        }).addTo(map);

        markersLayer = L.layerGroup().addTo(map);
        renderMarkers();

        // Fit to all markers
        if (vendorLocations.length > 0) {
            const bounds = L.latLngBounds(vendorLocations.map(v => [v.lat, v.lng]));
            map.fitBounds(bounds.pad(0.15));
        }
    }

    function renderMarkers() {
        markersLayer.clearLayers();
        const selectedCity = cityInput.value;

        vendorLocations.forEach(function (v) {
            const isSelected = selectedCity && v.city === selectedCity;
            const markerColor = isSelected ? '#16a34a' : '#22c55e';
            const markerSize = isSelected ? 14 : 10;

            const icon = L.divIcon({
                html: `<div style="
                    width: ${markerSize * 2}px; height: ${markerSize * 2}px;
                    background: ${markerColor}; border: 3px solid white;
                    border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                    display: flex; align-items: center; justify-content: center;
                    font-size: ${isSelected ? 10 : 8}px; font-weight: bold; color: white;
                ">${v.products}</div>`,
                className: '',
                iconSize: [markerSize * 2, markerSize * 2],
                iconAnchor: [markerSize, markerSize],
            });

            const marker = L.marker([v.lat, v.lng], { icon }).addTo(markersLayer);
            marker.bindPopup(`
                <div style="font-family: sans-serif; min-width:160px;">
                    <strong style="font-size:14px;">${v.name}</strong>
                    ${v.city ? '<br><span style="color:#64748b;font-size:12px;">📍 ' + v.city + '</span>' : ''}
                    <br><span style="color:#16a34a;font-size:12px;font-weight:600;">${v.products} products</span>
                    <br><button onclick="filterByCity('${v.city}')" style="
                        margin-top:8px; width:100%; padding:6px 12px;
                        background:#16a34a; color:white; border:none; border-radius:8px;
                        cursor:pointer; font-size:12px; font-weight:500;
                    ">{{ __('Show products') }}</button>
                </div>
            `);
        });
    }

    // Called from popup button
    window.filterByCity = function (city) {
        cityInput.value = city;
        form.submit();
    };

    // Reset map view
    document.getElementById('fitAllMarkers').addEventListener('click', function () {
        if (map && vendorLocations.length > 0) {
            const bounds = L.latLngBounds(vendorLocations.map(v => [v.lat, v.lng]));
            map.fitBounds(bounds.pad(0.15));
        }
    });
});
</script>
@endsection
