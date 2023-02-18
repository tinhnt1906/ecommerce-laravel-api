<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $id = Auth::id();
        $orders = Order::with('products')
            ->where('user_id', $id)
            ->where('status', 'completed')
            ->get();

        $review = new Review();
        foreach ($orders as $order) {
            foreach ($order->products as $item) {
                if ($request->product_id == $item->id) {

                    $review = Review::create([
                        'product_id' => $request->product_id,
                        'user_id' => $id,
                        'star' => $request->star,
                        'comment' => $request->comment
                    ]);

                    if ($review) {
                        return response()->json([
                            'success' => true,
                            'message' => 'review successfully'
                        ]);
                    }
                }
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'you cannot review a product'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
    }
}
