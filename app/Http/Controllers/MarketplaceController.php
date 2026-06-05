<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Vegetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_quantity' => ['required', 'numeric', 'min:0'],
            'condition' => ['required', 'string', 'in:Fresh,Organic,Premium,Daily Harvest,Farm Fresh'],
        ]);

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

        // Filter by vendor
        if ($vendor = $request->input('vendor')) {
            $query->whereHas('vendor', fn ($q) => $q->where('name', 'like', "%{$vendor}%"));
        }

        // Sort
        $sort = $request->input('sort', 'newest');
        $query->orderByDesc('created_at');

        $vegetables = $query->get();

        $conditions = ['Fresh', 'Organic', 'Premium', 'Daily Harvest', 'Farm Fresh'];

        return view('consumer.market', compact('vegetables', 'conditions'));
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
