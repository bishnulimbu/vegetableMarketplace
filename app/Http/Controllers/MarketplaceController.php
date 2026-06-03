<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Vegetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'image' => ['nullable', 'string', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_quantity' => ['required', 'integer', 'min:0'],
        ]);

        $user->vegetables()->create($data);

        return back()->with('success', 'Vegetable added successfully.');
    }

    public function consumerMarket()
    {
        $vegetables = Vegetable::with('vendor')->where('available_quantity', '>', 0)->orderByDesc('created_at')->get();

        return view('consumer.market', compact('vegetables'));
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
