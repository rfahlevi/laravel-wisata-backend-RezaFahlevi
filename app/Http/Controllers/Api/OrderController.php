<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with('orderItems', 'cashier')
                        ->orderBy('created_at', 'desc')
                        ->get();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Daftar transaksi',
                    'data' => OrderResource::collection($orders),
                ],
                200,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    public function store(OrderRequest $request)
    {
        try {
            $data = $request->validated();

            $newOrder = Order::create($data);

            foreach ($data['order_items'] as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $newOrder->id;
                $orderItem->ticket_id = $item['ticket_id'];
                $orderItem->qty = $item['qty'];
                $orderItem->subtotal = $item['subtotal'];
                $orderItem->save();
            }

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Berhasil membuat transaksi',
                    'data' => new OrderResource($newOrder),
                ],
                201,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }
}
