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
        $categories = Category::query()
            ->paginate(
                request('perPage') ?? 10
            );
        $responseData =
            [
                'data' => [
                    'orders' => CategoryResource::collection($categories),
                    'pagination' => [
                        'total' => $categories->total(),
                    ]
                ]
            ];
        return response()->json($responseData);
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
        $category = Category::query()
            ->where('code', $code)
            ->firstOrFail();
        $responseData = [
            'data' => [
                'category' => $category
            ]
        ];
        if (!$category) {
            return response()->json('Category not found', 404);
        }
        return response()->json($responseData);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $code)
    {
        $category = Category::query()
            ->where('code', $code)
            ->firstOrFail();
        $params = $request->all();
        unset($params['image']);
        if (request()->hasFile('image')) {
            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }
        $category->update($params);
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
        $category = Category::query()
            ->where('code', $code)
            ->firstOrFail();
        $category->delete();
        return response()->json('Category deleted successfully', 204);
        //
    }
}
