<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Vegetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request, Vegetable $vegetable)
    {
        abort_unless(Auth::user()->role === 'consumer', 403);

        $data = $request->validate([
            'quantity' => ['required', 'numeric', 'min:0.1'],
        ]);
        $quantity = $data['quantity'];

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('vegetable_id', $vegetable->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'vegetable_id' => $vegetable->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', "{$vegetable->name} added to cart!");
    }

    public function viewCart()
    {
        $cartItems = Cart::with('vegetable.vendor')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(fn ($item) => $item->vegetable->price * $item->quantity);

        return view('consumer.cart', compact('cartItems', 'total'));
    }

    public function updateCart(Request $request, Cart $cart)
    {
        abort_unless($cart->user_id === Auth::id(), 403);

        $data = $request->validate(['quantity' => ['required', 'numeric', 'min:0.1']]);
        $cart->update($data);

        return back()->with('success', 'Cart updated.');
    }

    public function removeFromCart(Cart $cart)
    {
        abort_unless($cart->user_id === Auth::id(), 403);
        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    public function showCheckout()
    {
        $cartItems = Cart::with('vegetable')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('consumer.market')->with('success', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn ($item) => $item->vegetable->price * $item->quantity);

        return view('consumer.checkout', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $cartItems = Cart::with('vegetable')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        $data = $request->validate([
            'payment_method' => ['required', 'string', 'in:esewa,khalti'],
        ]);

        $total = $cartItems->sum(fn ($item) => $item->vegetable->price * $item->quantity);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_method' => $data['payment_method'],
                'status' => 'completed',
            ]);

            foreach ($cartItems as $cartItem) {
                $order->items()->create([
                    'vegetable_id' => $cartItem->vegetable_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->vegetable->price,
                ]);

                $cartItem->vegetable->decrement('available_quantity', $cartItem->quantity);
            }

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('order.confirmation', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    public function viewProduct(Vegetable $vegetable)
    {
        $vegetable->load('vendor');

        return view('consumer.product', compact('vegetable'));
    }

    public function orderConfirmation(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('items.vegetable');

        return view('consumer.confirmation', compact('order'));
    }

    public function myOrders()
    {
        $orders = Order::with('items.vegetable')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('consumer.orders', compact('orders'));
    }
}
