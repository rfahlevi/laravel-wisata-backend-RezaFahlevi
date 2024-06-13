<?php

namespace App\Http\Resources;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ticket = Ticket::withTrashed()->find($this->ticket_id);

        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'ticket' => new TicketResource($ticket),
            'qty' => $this->qty,
            'subtotal' => $this->subtotal,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
