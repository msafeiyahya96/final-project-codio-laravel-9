<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // setting middleware / untuk menjalankan controller perlu login, bisa juga menggunakan route dengan middleware group
    public function __construct() {
        $this->middleware('auth');
    }

    public function add_to_cart(Product $product, Request $request) {

        // import user id dan product id
        $user_id    = Auth::id();
        $product_id = $product->id;

        // Validasi jika cart yang di tambahkan sudah ada, get chart first terlebih dahulu
        $existing_cart  = Cart::where('user_id', $user_id)
                            ->where('product_id', $product_id)
                            ->first();

        if ($existing_cart == null) {
            $request->validate([
                'amount' => 'required|gte:1|lte:' . $product->stock
            ]);
    
            // Create Cart
            Cart::create([
                'user_id'       => $user_id,
                'product_id'    => $product_id,
                'amount'        => $request->amount
            ]);
        } else {
            $request->validate([
                'amount' => 'required|gte:1|lte:' . ($product->stock - $existing_cart->amount)
            ]);

            $existing_cart->update([
                'amount'    => $existing_cart->amount + $request->amount
            ]);
        }
        

        // return ke index product
        return Redirect::route('show_cart');
    }

    public function show_cart() {
        // import user_id
        $user_id    = Auth::id();
        // get carts sesuai user id
        $carts      = Cart::where('user_id', $user_id)->get();

        return view('show_cart', compact('carts'));
    }

    public function update_cart(Cart $cart, Request $request) {
        $request->validate([
            'amount' => 'required|gte:1|lte:' . $cart->product->stock
        ]);

        $cart->update([
            'amount' => $request->amount
        ]);

        return Redirect::route('show_cart');
    }

    public function delete_cart(Cart $cart) {
        $cart->delete();

        return Redirect::back();
    }
}
