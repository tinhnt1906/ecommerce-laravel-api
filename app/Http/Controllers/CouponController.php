<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        return response()->json([
            'success' => true,
            'coupons' => $coupons
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = new Coupon();
        $coupon = Coupon::create([
            'code' => $request->code,
            'type' => $request->type,
            'status' => $request->status,
            'value' => $request->value,
            'description' => $request->description
        ]);

        if ($coupon) {
            return response()->json([
                'success' => true,
                'message' => 'coupon add Successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Some Problem"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return response()->json([
            'success' => true,
            'coupon' => $coupon
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        if ($coupon) {
            $coupon->status = $request->status;
            $coupon->value = $request->value;
            $coupon->description = $request->description;
            $coupon->save();
            return response()->json(['success' => true, 'coupon' => $coupon]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
