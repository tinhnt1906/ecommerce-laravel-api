<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $user = Auth::id();
        if ($user) {
            $carts = Cart::where('user_id', $user)->with('product')->get();
            if ($carts->count() <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is Empty',
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'carts' => $carts,
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'please login',
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::id();
        if ($user) {
            $cart = Cart::updateOrCreate(
                [
                    'user_id' => $user,
                    'product_id' => $request->product_id
                ],
                [
                    'quantity'    => $request->quantity
                ]
            );

            return response()->json([
                'success' => true,
                'cart' => $cart,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'please login',
            ]);
        }
    }

    public function totalCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalCart = 0;
        foreach ($cartItems as $item) {
            $totalCart += $item->product->price * $item->quantity;
        }
        return response()->json($totalCart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        Cart::with('product')
            ->where('id', $cart->id)
            ->delete();
        return response()->json([
            'success' => true,
            'message' => 'deleted cart successfully'
        ]);
    }
}
