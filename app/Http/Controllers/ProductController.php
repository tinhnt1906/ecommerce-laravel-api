<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::orderBy('id','desc')->with('category')->get();
        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $product = new Product();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = rand() . '' . time() . '.' . $extension;
                $file->move('uploads/products/', $filename);
                $image_path = 'uploads/products/' . $filename;
            }

            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::of($request->name)->slug('-'),
                'image' => $image_path,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
            ]);

            if ($product) {
                return response()->json([
                    'success' => true,
                    'message' => 'product add Successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Some Problem"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($product) {
            if ($request->name) {
                $product->name = $request->name;
                $product->slug = Str::of($request->name)->slug('-');
            }

            if ($request->status) {
                $product->status = $request->status;
            }

            if ($request->hasFile('image')) {
                $path = $product->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = rand() . '' . time() . '.' . $extension;
                $file->move('uploads/products/', $filename);
                $product->image = 'uploads/products/' . $filename;
            }
            $result = $product->save();
            if ($result) {
                return response()->json([
                    'success' => true,
                    'product' => $product,
                    'message' => 'product update Successfully'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "product Not Found"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $path_image = $category->image;
        if (File::exists($path_image)) {
            File::delete($path_image);
        }
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'product deleted successfully',
        ]);
    }


}
