<?php

namespace App\Http\Controllers;

use App\Models\Vegetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // For consumers, gather products grouped by category
        $grouped = collect();
        $categories = ['Vegetables', 'Fruits', 'Leafy Greens', 'Herbs', 'Exotic', 'Others'];
        $nearbyCities = collect();

        // Use browser-geolocation coordinates (query params) if provided, else fall back to profile
        $browserLat = $request->input('near_lat');
        $browserLng = $request->input('near_lng');
        $useBrowserLocation = $browserLat && $browserLng;

        if ($user->isConsumer()) {
            $query = Vegetable::with('vendor')->where('available_quantity', '>', 0);

            $vegetables = $query->latest()->get();

            $originLat = $useBrowserLocation ? (float) $browserLat : ($user->latitude ? (float) $user->latitude : null);
            $originLng = $useBrowserLocation ? (float) $browserLng : ($user->longitude ? (float) $user->longitude : null);

            // If we have coordinates, sort by distance (closest first) and attach distance
            if ($originLat && $originLng) {
                $vegetables = $vegetables->map(function ($v) use ($originLat, $originLng) {
                    if ($v->vendor->latitude && $v->vendor->longitude) {
                        $v->distance = round($this->haversineDistance(
                            $originLat, $originLng,
                            (float) $v->vendor->latitude,
                            (float) $v->vendor->longitude
                        ), 1);
                    } else {
                        $v->distance = null;
                    }
                    return $v;
                })->sortBy(function ($v) {
                    return $v->distance ?? 999999;
                });
            }

            foreach ($categories as $cat) {
                $items = $vegetables->where('category', $cat);
                if ($items->isNotEmpty()) {
                    $grouped->put($cat, $items);
                }
            }

            // Get nearby cities for the badge
            $nearbyCities = \App\Models\User::where('role', 'vendor')
                ->whereNotNull('city')
                ->whereHas('vegetables', fn ($q) => $q->where('available_quantity', '>', 0))
                ->distinct()
                ->pluck('city')
                ->sort()
                ->values();
        }

        return view('dashboard', compact('user', 'grouped', 'categories', 'nearbyCities', 'useBrowserLocation', 'browserLat', 'browserLng'));
    }

    /**
     * Haversine distance in km.
     */
    private function haversineDistance($lat1, $lng1, $lat2, $lng2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
