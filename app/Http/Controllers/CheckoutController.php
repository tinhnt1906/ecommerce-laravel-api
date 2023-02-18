<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::id();
        $order->name =    $request->name ?? Auth::user()->name;
        $order->phone =   $request->phone ?? Auth::user()->phone;
        $order->email =  Auth::user()->email ?? $request->email;
        $order->address = Auth::user()->address ?? $request->address;
        $total_price = 0;

        // lấy giỏ hàng người dùng để thanh toán
        $cartItems = Cart::where('user_id', Auth::id())->get();

        foreach ($cartItems as $cartItem) {
            $total_price += $cartItem->product->price * $cartItem->quantity;
        }

        //check coupon va luu vao order
        if ($request->coupon_code) {
            $order->coupon_code = $request->coupon_code;
            $coupon = Coupon::where('code', $request->coupon_code)
                ->where('status', 'enable')
                ->first();
            if ($coupon) {
                // dd($coupon->discount($total_price));
                $order->total_price = $coupon->discount($total_price);
                $order->save();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon code is invalid or expired'
                ]);
            }
        } else {
            // dd($total_price);
            $order->total_price = $total_price;
            $order->save();
        }


        // luu vao bang phu order_product
        foreach ($cartItems as $cartItem) {
            $order->products()->attach(
                $cartItem->product_id,
                [
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price
                ]
            );

            // tru san phẩm sau khi đã mua
            $product = Product::where('id', $cartItem->product_id)->first();
            $product->quantity = $product->quantity -  $cartItem->quantity;
            $product->update();
        }

        // xoá giỏ hàng người dùng sau khi đã mua
        Cart::destroy($cartItems);

        return response()->json([
            'success' => true,
            'message' => 'Order Success'
        ]);
    }
}
