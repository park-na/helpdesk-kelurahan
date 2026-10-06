<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard berdasarkan role
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route(
                'admin.dashboard'
            );
        }

        return redirect()->route(
            'staff.tickets.index'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin / Teknisi
    |--------------------------------------------------------------------------
    */

    public function admin()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik tiket
        |--------------------------------------------------------------------------
        */

        $counts = [

            'all' => Ticket::count(),

            'waiting' => Ticket::where(
                'status',
                'waiting'
            )->count(),

            'processing' => Ticket::where(
                'status',
                'processing'
            )->count(),

            'completed' => Ticket::where(
                'status',
                'completed'
            )->count(),

        ];


        /*
        |--------------------------------------------------------------------------
        | Tiket terbaru
        |--------------------------------------------------------------------------
        |
        | Sekarang kita hanya membutuhkan relasi user.
        | device dan room sudah bukan relationship lagi.
        |
        */

        $latestTickets = Ticket::with([
            'user'
        ])
        ->latest()
        ->take(10)
        ->get();


        return view(
            'admin.dashboard',
            compact(
                'counts',
                'latestTickets'
            )
        );
    }
}