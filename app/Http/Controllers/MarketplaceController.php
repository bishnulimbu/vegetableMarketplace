<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Vegetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class MarketplaceController extends Controller
{
    public function vendorProducts()
    {
        $user = Auth::user();
        abort_unless($user->role === 'vendor', 403);

        $vegetables = $user->vegetables()->orderByDesc('created_at')->get();

        return view('vendor.products', compact('vegetables'));
    }

    public function storeVendorProduct(Request $request)
    {
        $user = Auth::user();
        abort_unless($user->role === 'vendor', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_ne' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_quantity' => ['required', 'numeric', 'min:0'],
            'condition' => ['required', 'string', 'in:Fresh,Organic,Premium,Daily Harvest,Farm Fresh'],
            'category' => ['required', 'string', 'in:Vegetables,Fruits,Leafy Greens,Herbs,Exotic,Others'],
        ]);

        // Auto-translate name to Nepali if no manual name_ne provided
        if (empty($data['name_ne'])) {
            try {
                $tr = new GoogleTranslate('ne');
                $data['name_ne'] = $tr->translate($data['name']);
            } catch (\Exception $e) {
                // Fallback: leave name_ne null — localized_name will use English
            }
        }

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vegetables', 'public');
                $imagePaths[] = Storage::url($path);
            }
        }

        $data['image'] = $imagePaths;
        unset($data['images']);

        $user->vegetables()->create($data);

        return back()->with('success', 'Vegetable added successfully.');
    }

    public function editVendorProduct(Vegetable $vegetable)
    {
        $user = Auth::user();
        abort_unless($user->role === 'vendor' && $vegetable->vendor_id === $user->id, 403);

        return view('vendor.product-edit', compact('vegetable'));
    }

    public function updateVendorProduct(Request $request, Vegetable $vegetable)
    {
        $user = Auth::user();
        abort_unless($user->role === 'vendor' && $vegetable->vendor_id === $user->id, 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_ne' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'remove_images' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_quantity' => ['required', 'numeric', 'min:0'],
            'condition' => ['required', 'string', 'in:Fresh,Organic,Premium,Daily Harvest,Farm Fresh'],
            'category' => ['required', 'string', 'in:Vegetables,Fruits,Leafy Greens,Herbs,Exotic,Others'],
        ]);

        // Auto-translate name to Nepali if no manual name_ne provided
        if (empty($data['name_ne'])) {
            try {
                $tr = new GoogleTranslate('ne');
                $data['name_ne'] = $tr->translate($data['name']);
            } catch (\Exception $e) {
                // Fallback: leave name_ne null
            }
        }

        // Handle image removal
        $currentImages = $vegetable->image ?? [];
        if (!empty($data['remove_images'])) {
            $removeIndices = explode(',', $data['remove_images']);
            foreach ($removeIndices as $index) {
                $idx = (int) $index;
                if (isset($currentImages[$idx])) {
                    // Delete from storage
                    $path = str_replace('/storage/', '', parse_url($currentImages[$idx], PHP_URL_PATH));
                    Storage::disk('public')->delete($path);
                    unset($currentImages[$idx]);
                }
            }
            $currentImages = array_values($currentImages); // Re-index
        }
        unset($data['remove_images']);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vegetables', 'public');
                $currentImages[] = Storage::url($path);
            }
        }
        unset($data['images']);

        $data['image'] = $currentImages;

        $vegetable->update($data);

        return redirect()->route('vendor.products')->with('success', 'Vegetable updated successfully.');
    }

    public function destroyVendorProduct(Vegetable $vegetable)
    {
        $user = Auth::user();
        abort_unless($user->role === 'vendor' && $vegetable->vendor_id === $user->id, 403);

        // Delete images from storage
        foreach (($vegetable->image ?? []) as $imgUrl) {
            $path = str_replace('/storage/', '', parse_url($imgUrl, PHP_URL_PATH));
            Storage::disk('public')->delete($path);
        }

        $vegetable->delete();

        return redirect()->route('vendor.products')->with('success', 'Vegetable deleted successfully.');
    }

    public function consumerMarket(Request $request)
    {
        $query = Vegetable::with('vendor')->where('available_quantity', '>', 0);

        // Search by name
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by condition
        if ($condition = $request->input('condition')) {
            $query->where('condition', $condition);
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Filter by vendor
        if ($vendor = $request->input('vendor')) {
            $query->whereHas('vendor', fn ($q) => $q->where('name', 'like', "%{$vendor}%"));
        }

        // Filter by location (city)
        if ($city = $request->input('city')) {
            $query->whereHas('vendor', fn ($q) => $q->where('city', $city));
        }

        // Proximity search — filter by radius (km) from user's coordinates
        $nearLat = $request->input('near_lat');
        $nearLng = $request->input('near_lng');
        $radius = $request->input('radius'); // in km

        if ($nearLat && $nearLng && $radius) {
            $haversine = "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";
            $query->whereHas('vendor', function ($q) use ($haversine, $nearLat, $nearLng, $radius) {
                $q->whereNotNull('latitude')
                  ->whereNotNull('longitude')
                  ->whereRaw("{$haversine} <= ?", [$nearLat, $nearLng, $nearLat, $radius]);
            });
        }

        // Sort
        $sort = $request->input('sort', 'newest');
        $query->orderByDesc('created_at');

        $vegetables = $query->get();

        // Attach calculated distance if coordinates are available
        if ($nearLat && $nearLng) {
            $vegetables = $vegetables->map(function ($v) use ($nearLat, $nearLng) {
                $v->distance = $v->vendor->latitude && $v->vendor->longitude
                    ? round($this->haversineDistance($nearLat, $nearLng, $v->vendor->latitude, $v->vendor->longitude), 1)
                    : null;
                return $v;
            })->sortBy('distance');
        }

        // Group by category for sectioned display
        $categories = ['Vegetables', 'Fruits', 'Leafy Greens', 'Herbs', 'Exotic', 'Others'];
        $grouped = collect();
        foreach ($categories as $cat) {
            $items = $vegetables->where('category', $cat);
            if ($items->isNotEmpty()) {
                $grouped->put($cat, $items);
            }
        }

        $conditions = ['Fresh', 'Organic', 'Premium', 'Daily Harvest', 'Farm Fresh'];

        // Get all vendors with active products and their locations for the map
        $vendorLocations = \App\Models\User::where('role', 'vendor')
            ->whereHas('vegetables', fn ($q) => $q->where('available_quantity', '>', 0))
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->withCount(['vegetables' => fn ($q) => $q->where('available_quantity', '>', 0)])
            ->get(['id', 'name', 'city', 'latitude', 'longitude'])
            ->map(fn ($v) => [
                'name' => $v->name,
                'city' => $v->city,
                'lat' => (float) $v->latitude,
                'lng' => (float) $v->longitude,
                'products' => $v->vegetables_count,
            ]);

        return view('consumer.market', compact('vegetables', 'grouped', 'categories', 'conditions', 'vendorLocations'));
    }

    /**
     * Calculate the great-circle distance between two points using the Haversine formula.
     */
    private function haversineDistance($lat1, $lng1, $lat2, $lng2): float
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function adminSettings()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $data = $request->validate([
            'market_name' => ['required', 'string', 'max:255'],
            'market_description' => ['required', 'string', 'max:500'],
        ]);

        Setting::updateOrCreate(['key' => 'market_name'], ['value' => $data['market_name']]);
        Setting::updateOrCreate(['key' => 'market_description'], ['value' => $data['market_description']]);

        return back()->with('success', 'Marketplace settings saved.');
    }
}
