<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\Redirect;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function checkout() {
        // import user_id
        $user_id    = Auth::id();
        // import Cart sesuai user id
        $carts      = Cart::where('user_id', $user_id)->get();

        // kondisi jika cart tidak ada
        if ( $carts == null) {
            return Redirect::back();
        }

        // jika cart ada, maka membuat order baru
        $order  = Order::create([
            'user_id'   => $user_id
        ]);

        // membuat transaction-transaction yang dilakukan
        foreach ($carts as $cart) {
            // mengurangi stock product ketika sudah di checkout. import product terlebih dahulu sesuai id dan lakukan update.
            $product = Product::find($cart->product_id);
            $product->update([
                'stock' => $product->stock - $cart->amount
            ]);

            // Membuat transaction
            Transaction::create([
                'amount'    => $cart->amount,
                'order_id'  => $order->id,
                'product_id'    => $cart->product_id
            ]);
    
            // Delete Cart setelah melakukan checkout
            $cart->delete();
        }

        // setelah transaksi-transaksi terbuat kita return.
        return Redirect::route('show_order', $order);
    }

    public function index_order() {
        $user       = Auth::user();
        $is_admin   = $user->is_admin;
        if ($is_admin) {
            $orders = Order::all();            
        } else {
            $orders = Order::where("user_id", $user->id)->get();
        }
        
        return view('index_order', compact('orders'));
    }

    public function show_order(Order $order) {
        $user       = Auth::user();
        $is_admin   = $user->is_admin;
        if ($is_admin || $order->user_id == $user->id) {
            return view('show_order', compact('order'));
        }

        return Redirect::route('index_order');
    }

    public function submit_payment_receipt(Order $order, Request $request) {
        // request payment_receipt dalam bentuk file
        $file   = $request->file('payment_receipt');

        // mengolah file payment_receipt kedalam sebua path
        $path   = time() . '_' . $order->id . '.' . $file->getClientOriginalExtension();

        // Meletakan file yang sudah di path ke dalam disk local
        Storage::disk('local')->put('public/' . $path, file_get_contents($file));

        // import dan update payment_receipt dari tabel order
        $order->update([
            'payment_receipt'   => $path
        ]);

        return Redirect::back();
    }

    public function confirm_payment(Order $order) {
        $order->update([
            'is_paid'   => true
        ]);

        return Redirect::back();
    }
}
