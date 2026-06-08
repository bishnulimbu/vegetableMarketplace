@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="text-center mb-8">
            <div class="text-5xl mb-3">🌱</div>
            <h1 class="text-3xl font-bold text-slate-900">Join the market</h1>
            <p class="text-slate-500 mt-1">Create an account and start selling or shopping.</p>
        </div>

        <div class="rounded-2xl bg-white border border-green-100 p-8">
            <form method="POST" action="{{ route('register.perform') }}" class="space-y-4">
                @csrf
                <label class="block text-sm font-medium text-slate-700">
                    <span>Name</span>
                    <input name="name" type="text" value="{{ old('name') }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Password</span>
                    <input name="password" type="password" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Confirm Password</span>
                    <input name="password_confirmation" type="password" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>Account type</span>
                    <select name="role" required class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition">
                        <option value="consumer" {{ old('role') === 'consumer' ? 'selected' : '' }}>🥦 Consumer — Shop for vegetables</option>
                        <option value="vendor" {{ old('role') === 'vendor' ? 'selected' : '' }}>🧑‍🌾 Vendor — Sell your produce</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('City') }} <span class="text-slate-400 font-normal">({{ __('optional') }})</span></span>
                    <input name="city" type="text" value="{{ old('city') }}" id="cityInput" placeholder="e.g. Kathmandu, Pokhara..." class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition" />
                </label>
                <label class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Address') }} <span class="text-slate-400 font-normal">({{ __('optional') }})</span></span>
                    <textarea name="address" rows="2" id="addressInput" placeholder="e.g. Thamel, Ward No. 12..." class="mt-1 block w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition">{{ old('address') }}</textarea>
                </label>

                {{-- Map location picker --}}
                <div class="block text-sm font-medium text-slate-700">
                    <span>{{ __('Pin your location on the map') }} <span class="text-slate-400 font-normal">({{ __('optional') }})</span></span>
                    <div id="location-search" class="relative mt-2">
                        <input id="searchBox" type="text" placeholder="{{ __('Search for a place...') }}" class="block w-full rounded-xl border border-slate-200 px-4 py-3 pl-10 focus:border-market-400 focus:ring-2 focus:ring-market-100 outline-none transition text-sm" />
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <div id="map" class="mt-2 w-full h-64 rounded-xl border border-slate-200 overflow-hidden z-0"></div>
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" />
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" />
                    <p id="coord-display" class="text-xs text-slate-400 mt-1.5"></p>
                </div>

                <button type="submit" class="w-full rounded-full veg-gradient px-4 py-3 text-white font-medium hover:opacity-90 transition">Create account</button>
            </form>
            <p class="mt-5 text-sm text-center text-slate-500">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-market-600 hover:text-market-700">Log in here</a>.</p>
        </div>
    </div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultLat = 27.7172;
    const defaultLng = 85.3240;

    const map = L.map('map').setView([defaultLat, defaultLng], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18,
    }).addTo(map);

    const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    function updateCoords(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
        document.getElementById('coord-display').textContent = lat.toFixed(4) + ', ' + lng.toFixed(4);
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], map.getZoom());
    }

    // If we have old values from validation errors, restore them
    const oldLat = document.getElementById('latitude').value;
    const oldLng = document.getElementById('longitude').value;
    if (oldLat && oldLng) {
        updateCoords(parseFloat(oldLat), parseFloat(oldLng));
    }

    // Draggable marker
    marker.on('dragend', function () {
        const pos = marker.getLatLng();
        updateCoords(pos.lat, pos.lng);

        // Reverse geocode to fill city/address
        fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + pos.lat + '&lon=' + pos.lng + '&accept-language=en')
            .then(r => r.json())
            .then(data => {
                const addr = data.address || {};
                if (!document.getElementById('cityInput').value) {
                    document.getElementById('cityInput').value = addr.city || addr.town || addr.village || addr.county || '';
                }
                if (!document.getElementById('addressInput').value) {
                    document.getElementById('addressInput').value = addr.road ? addr.road + (addr.house_number ? ' ' + addr.house_number : '') : data.display_name || '';
                }
            })
            .catch(() => {});
    });

    // Click on map to move marker
    map.on('click', function (e) {
        updateCoords(e.latlng.lat, e.latlng.lng);
        marker.fire('dragend');
    });

    // Search for a place using Nominatim
    document.getElementById('searchBox').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const query = this.value.trim();
            if (!query) return;

            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&limit=5&accept-language=en')
                .then(r => r.json())
                .then(results => {
                    if (results.length === 0) return;
                    const loc = results[0];
                    updateCoords(parseFloat(loc.lat), parseFloat(loc.lon));

                    // Fill city from result
                    if (!document.getElementById('cityInput').value) {
                        document.getElementById('cityInput').value = loc.display_name.split(',')[0].trim();
                    }
                    marker.fire('dragend');
                })
                .catch(() => {});
        }
    });
});
</script>
@endsection
