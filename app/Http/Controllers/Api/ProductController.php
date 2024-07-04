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
        $products = Product::query()
            ->where('id', '>', 1)
            ->paginate(
                request('per_page') ?? 10
            );
        $responseData =
            [
                'data' => [
                    'orders' => ProductResource::collection($products),
                    'pagination' => [
                        'total' => $products->total(),
                    ]
                ]
            ];
        return response()->json($responseData);
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
        }
        1;

        Product::create($params);
        $responseData = [
            'data' => [
                'params' => $params
            ]
        ];

        return response()->json($responseData);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $product = Product::query()
            ->where('code', $code)
            ->firstOrFail();
        $responseData = [
            'data' => [
                'product' => $product
            ]
        ];
        if (!$product) {
            return response()->json('Product not found', 404);
        }
        return response()->json($responseData);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $code)
    {
        $product = Product::query()
            ->where('code', $code)
            ->firstOrFail();
        $params = $request->all();
        unset($params['image']);
        if (request()->hasFile('image')) {
            $path = $request->file('image')->store('products');
            $params['image'] = $path;
        }
        $product->update($params);
        $responseData = [
            'data' => [
                'params' => $params
            ]
        ];
        return response()->json($responseData);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        $product = Product::query()
            ->where('code', $code)
            ->firstOrFail();
        $product->delete();
        return response()->json('Product deleted successfully', 204);
        //
    }
}
