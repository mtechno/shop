<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::query()
            ->paginate(
                request('perPage') ?? 10
            );
        $responseData =
            [
                'data' => [
                    'orders' => OrderResource::collection($orders),
                    'pagination' => [
                        'total' => $orders->total(),
                    ]
                ]
            ];
        return response()->json($responseData);
//        return response()->json($orders);
//        return OrderResource::collection($orders);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $params = $request->all();
        Order::create($params);
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
    public function show(string $id)
    {
        $order = Order::query()
            ->where('id', $id)
            ->first();
        $responseData = [
            'data' => [
                'order' => $order
            ]
        ];
        if (!$order)
        {
            return response()->json('Order not found', 404);
        }
        return response()->json($responseData);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        $order = Order::where('id', $id)->first();
        $params = $request->all();
        $order->update($params);
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
    public function destroy(string $id)
    {
        $order = Order::where('id', $id)->first();
        $order->delete();
        return response()->json('Order deleted successfully', 204);
        //
    }
}
