<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class BasketController extends Controller
{

    public function basket()
    {
        $order = (new Basket())->getOrder();
        return view('basket', compact('order'));
    }

    public
    function basketPlace() //подтверждение заказа
    {
        $orderId = session('orderId');
        $order = Order::findOrFail($orderId);
        return view('order', compact('order'));
    }

    public
    function basketAdd(Product $product)
    {
        $result = (new Basket(true))->addProduct($product);
        if ($result) {
            session()->flash('success', 'Добавлен товар ' . $product->name);
        } else {
            session()->flash('warning', 'Товар ' . $product->name . ' в большем кол-ве не доступен для заказа');
        }

        return redirect()->route('basket');
    }

    public
    function basketRemove(Product $product)
    {
        (new Basket())->removeProduct($product);
        session()->flash('warning', 'Товар ' . $product->name . ' удален из корзины');
        return redirect()->route('basket');
    }

    public
    function basketConfirm(Request $request)
    {
        if ((new Basket())->saveOrder($request->name, $request->phone)) {
            session()->flash('success', 'Ваш заказа принят в обработку');
        } else {
            session()->flash('warning', 'Товар не доступен для заказа в полном объеме');
        }
        Order::eraseOrderSum();
        return redirect()->route('index');

    }

//
//
}
