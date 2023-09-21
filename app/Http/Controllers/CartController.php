<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function shopping_cart(Request $request) {
        $user = $request->user();

        $cart = Cart::select(['id', 'product_id', 'qty', 'user_id'])->where('user_id', $user->id)->with(['product:id,image,name,price'])->get();

        return Inertia::render('Frontend/shopping_cart', ['response' => rtFormat($cart ?? [])]);
    }
}
