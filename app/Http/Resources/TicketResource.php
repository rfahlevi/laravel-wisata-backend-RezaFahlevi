<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\TicketCategory;
use Illuminate\Support\Carbon;
use App\Http\Resources\TicketCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ticketCategory = TicketCategory::findOrFail($this->ticket_category_id);

        return [
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'quota' => $this->quota,
            'ticket_category' => new TicketCategoryResource($ticketCategory),
            'is_featured' => $this->is_featured,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
