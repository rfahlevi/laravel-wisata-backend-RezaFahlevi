<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $cashier = User::where('id', $this->cashier_id)->firstOrFail();
        
        return [
            'id' => $this->id,
            'cashier' => new UserResource($cashier),
            'total_item' => $this->total_item,
            'items' => OrderItemResource::collection($this->orderItems),
            'total_price' => $this->total_price,
            'payment_method' => $this->payment_method,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
