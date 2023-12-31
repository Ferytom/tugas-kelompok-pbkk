<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Auth;
use Cache;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $userId;

    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $carts = Cache::remember('admin-carts', 120, function () {
                return Cart::all()->sortBy('user_id')->sortBy('product_id');
            });

            foreach ($carts as $cart) {
                $cart->user_id = User::where('id', $cart->user_id)->first()->name;
                $cart->product_id = Product::where('id', $cart->product_id)->first()->name;
            }
            
            return view('admin.cart', compact('carts'));
        }
        else
        {
            $this->userId = Auth::user()->id;
            $totalPrice = 0;

            $carts = Cache::remember('user-carts', 120, function () {
                return Cart::where('user_id', $this->userId)->get()->sortBy('product_id');
            });

            foreach ($carts as $cart) {
                $cart->user_name = User::where('id', $cart->user_id)->first()->name;
                $cart->unitPrice = Product::where('id', $cart->product_id)->first()->price;
                $cart->product_name = Product::where('id', $cart->product_id)->first()->name;
                $cart->productTotalPrice = $cart->unitPrice * $cart->quantity;
                $totalPrice = $totalPrice + $cart->productTotalPrice;
            }

            return view('cart', compact('carts', 'totalPrice'));
        }
    }

    public function filter(Request $request)
    {
        $userId = $request->get('user_id');
        $productId = $request->get('product_id');    

        if (empty($userId))
        {
            if (empty($productId))
            {
                $carts = Cart::all()->sortBy('user_id');
            }
            else
            {
                $carts = Cart::where('product_id', $productId)->get()->sortBy('user_id');
            }
        }
        else
        {
            if (empty($productId))
            {
                $carts = Cart::where('user_id', $userId)->get();
            }
            else
            {
                $carts = Cart::where('user_id', $userId)->where('product_id', $productId)->get();
            }
        }

        foreach ($carts as $cart) {
            $cart->user_id = User::where('id', $cart->user_id)->first()->name;
            $cart->product_id = Product::where('id', $cart->product_id)->first()->name;
        }

        return view('admin.cart', compact('carts'));
    }
}
