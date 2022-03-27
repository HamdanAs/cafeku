<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\PlaceOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function placeOrder(PlaceOrderRequest $request)
    {
        $order = Order::create([
            'table_no'  => $request->table,
            'status'    => Order::EATING
        ]);

        $result = $order->details()->createMany($request->details);

        $order->update([
            'total' => $order->details->sum('total')
        ]);

        return $this->sendResponse($result);
    }

    public function pay(PlaceOrderRequest $request, Order $order)
    {
        $order->update([
            'status' => Order::DONE,
            'payment' => $request->payment
        ]);

        return $this->sendResponse($order);
    }
}
