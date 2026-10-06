<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketUpdate extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'status',
        'note',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusLabel()
    {
        return match ($this->status) {
            'waiting' => 'Menunggu Respons',
            'processing' => 'Sedang Diproses',
            'completed' => 'Selesai',
            default => $this->status,
        };
    }
}
