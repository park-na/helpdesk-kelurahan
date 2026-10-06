<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'device_type',
        'device_name',
        'inventory_code',
        'room_name',
        'description',
        'photo',
        'status',
        'repair_note',
        'handled_by',
        'completed_at',
    ];


    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Relasi pelapor
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Relasi teknisi
    |--------------------------------------------------------------------------
    */

    public function handler()
    {
        return $this->belongsTo(
            User::class,
            'handled_by'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Riwayat perubahan tiket
    |--------------------------------------------------------------------------
    */

    public function updates()
    {
        return $this->hasMany(
            TicketUpdate::class
        )->latest();
    }


    /*
    |--------------------------------------------------------------------------
    | Nama status
    |--------------------------------------------------------------------------
    */

    public function statusLabel()
    {
        return match ($this->status) {
            'waiting'
                => 'Menunggu Respons',

            'processing'
                => 'Sedang Diproses',

            'completed'
                => 'Selesai',

            default
                => $this->status,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Warna badge
    |--------------------------------------------------------------------------
    */

    public function statusBadge()
    {
        return match ($this->status) {
            'waiting'
                => 'warning',

            'processing'
                => 'primary',

            'completed'
                => 'success',

            default
                => 'secondary',
        };
    }
}