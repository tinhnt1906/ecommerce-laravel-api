<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    //

    public function getMyOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    public function getMyOrdersCompleted()
    {
        $orders = Order::where('user_id', Auth::id())->where('status', 'completed')->get();;
        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    public function getMyReviews()
    {
        $reviews = Review::where('user_id', Auth::id())->get();
        return response()->json([
            'success' => true,
            'reviews' => $reviews
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        $user = User::where('id', Auth::id())->first();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'password old incorrect',
            ]);
        }

        User::whereId(Auth::id())->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'changed password successfully',
        ]);
    }

    public function userProfile()
    {
        return response()->json([
            'success' => true,
            'user' => auth()->user()
        ]);
    }
}
