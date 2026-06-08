<?php

namespace App\Http\Controllers;

use App\Models\Vegetable;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // For consumers, gather products grouped by category
        $grouped = collect();
        $categories = ['Vegetables', 'Fruits', 'Leafy Greens', 'Herbs', 'Exotic', 'Others'];
        $nearbyCities = collect();
        if ($user->isConsumer()) {
            $query = Vegetable::with('vendor')->where('available_quantity', '>', 0);

            $vegetables = $query->latest()->get();

            // If consumer has coordinates, sort by distance (closest first)
            if ($user->latitude && $user->longitude) {
                $vegetables = $vegetables->sortBy(function ($v) use ($user) {
                    if (!$v->vendor->latitude || !$v->vendor->longitude) return 999999;
                    return $this->haversineDistance(
                        $user->latitude, $user->longitude,
                        $v->vendor->latitude, $v->vendor->longitude
                    );
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

        return view('dashboard', compact('user', 'grouped', 'categories', 'nearbyCities'));
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
