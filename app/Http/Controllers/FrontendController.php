<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function search($search)
    {
        try {
            $products = Product::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->with('category')->get();
            if ($products) {
                return response()->json([
                    'success' => true,
                    'products' => $products,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getCategories()
    {
        $categories = Category::where('status', 1)->get();
        return response()->json([
            'success' => true,
            'categories' => $categories,
        ]);
    }

    public function getProductsByCategory($slug)
    {
        try {
            if (Category::where('slug', $slug)->exists()) {
                $category = Category::where('slug', $slug)->first();
                $products   = Product::where('category_id', $category->id)->with('category')->get();
                return response()->json([
                    'success' => true,
                    'product' => $products,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "No category",
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
