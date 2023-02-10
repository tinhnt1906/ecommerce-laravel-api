<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
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
        try {
            $category = new Category();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = rand() . '' . time() . '.' . $extension;
                $file->move('uploads/categories/', $filename);
                $image_path = 'uploads/categories/' . $filename;
            }

            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::of($request->name)->slug('-'),
                'image' => $image_path
            ]);

            if ($category) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category add Successfully'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if ($category) {
            if ($request->name) {
                $category->name = $request->name;
                $category->slug = Str::of($request->name)->slug('-');
            }

            if ($request->status) {
                $category->status = $request->status;
            }

            if ($request->hasFile('image')) {
                $path = $category->image;
                echo $path;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = rand() . '' . time() . '.' . $extension;
                $file->move('uploads/categories/', $filename);
                $category->image = 'uploads/categories/' . $filename;
            }
            $result = $category->save();
            if ($result) {
                return response()->json([
                    'success' => true,
                    'category' => $category,
                    'message' => 'Category update Successfully'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "Category Not Found"
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $path_image = $category->image;
        if (File::exists($path_image)) {
            File::delete($path_image);
        }
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'category deleted successfully',
        ]);
    }
}
