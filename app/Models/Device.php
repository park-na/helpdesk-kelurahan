<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'room_id',
        'name',
        'inventory_code',
        'category',
        'description',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
