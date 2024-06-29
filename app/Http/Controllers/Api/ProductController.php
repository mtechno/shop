<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
//        return response()->json($products);
        return ProductResource::collection($products);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $params = $request->all();
        unset($params['image']);
        if (request()->hasFile('image')) {
            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }1;

        Product::create($params);
        return response()->json($params);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $product = Product::where('code', $code)->first();
        if (!$product)
        {
            return response()->json('Product not found', 404);
        }
        return new ProductResource($product);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $code)
    {
        $product = Product::where('code', $code)->first();
        $params = $request->all();
        unset($params['image']);
        if (request()->hasFile('image')) {
            $path = $request->file('image')->store('products');
            $params['image'] = $path;
        }
        $product->update($params);
        return response()->json($params);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        $product = Product::where('code', $code)->first();
        $product->delete();
        return response()->json('Product deleted successfully', 204);
        //
    }
}
