<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'slug'];

    protected $dates = ['deleted_at'];

    // Method untuk mengembalikan slug sebagai kunci route
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get all of the tickets for the TicketCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
