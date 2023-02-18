<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('products')->get();
        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Order $order)
    {
        $order->status = $request->status;
        if ($request->status == 'processing') {
            return response()->json([
                'success' => true,
                'message' => 'change status processing success'
            ]);
        }
        if ($request->status == 'completed') {
            return response()->json([
                'success' => true,
                'message' => 'change status completed success'
            ]);
        }
        if ($request->status == 'decline') {
            // code logic xử lý hoàn trả hàng khi đổi trả
            return response()->json([
                'success' => true,
                'message' => 'change status decline success'
            ]);
        }
    }
}
