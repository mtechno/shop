<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create(CategoryRequest $request)
    {

    }

    public function index()
    {
        $categories = Category::paginate(10);
//        return response()->json($categories);
        return CategoryResource::collection($categories);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $params = $request->all();
        unset($params['image']);
        if (request()->hasFile('image')) {
            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }
        Category::create($params);
        return response()->json($params);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $category = Category::where('code', $code)->first();
        if (!$category)
        {
            return response()->json('Category not found', 404);
        }
        return new CategoryResource($category);
//        return response()->json($category);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $code)
    {
        $category = Category::where('code', $code)->first();
        $params = $request->all();
        unset($params['image']);
        if (request()->hasFile('image')) {
            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }
        $category->update($params);
        return response()->json($params);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        $category = Category::where('code', $code)->first();
        $category->delete();
        return response()->json('Category deleted successfully', 204);
        //
    }
}
