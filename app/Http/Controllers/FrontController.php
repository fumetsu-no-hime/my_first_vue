<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;


class FrontController extends Controller
{
    public function home() {
        $products = Product::orderBy('id', 'desc')->where('public', 1)->get();

        return Inertia::render('Frontend/Index', [
            'response' => rtFormat($products),
        ]);
    }

    public function addCart(Request $request) {
        // dd($request->all());
        $request->validate([
            'id' => 'required|exists:products,id|numeric',
            'qty' => 'required|min:1|numeric',
        ]);

        $cart = Cart::where('product_id', $request->id)->where('user_id', $request->user()->id)->first();

        if ($cart) {
            $cart->update([
                'qty' => $cart->qty + $request->qty,
            ]);
        } else {
            $cart = Cart::create([
            'product_id' => $request->id,
            'qty' => $request->qty,
            'user_id' => $request->user()->id,
            ]);
        }

        return back()->with(['message' => rtFormat($cart)]);
    }
}
