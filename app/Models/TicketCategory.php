<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'slug'];

    // Method untuk mengembalikan slug sebagai kunci route
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
