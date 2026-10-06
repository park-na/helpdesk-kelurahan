<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class StaffTicketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Menampilkan pengaduan milik staf
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $tickets = Ticket::where(
            'user_id',
            Auth::id()
        )
            ->latest()
            ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $counts = [

            'all' => Ticket::where(
                'user_id',
                Auth::id()
            )->count(),


            'waiting' => Ticket::where(
                'user_id',
                Auth::id()
            )
                ->where(
                    'status',
                    'waiting'
                )
                ->count(),


            'processing' => Ticket::where(
                'user_id',
                Auth::id()
            )
                ->where(
                    'status',
                    'processing'
                )
                ->count(),


            'completed' => Ticket::where(
                'user_id',
                Auth::id()
            )
                ->where(
                    'status',
                    'completed'
                )
                ->count(),

        ];


        return view(
            'staff.tickets.index',
            compact(
                'tickets',
                'counts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Form buat pengaduan
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'staff.tickets.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan pengaduan
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ) {

        $data = $request->validate([

            'device_type' => [
                'required',
                'string',
                'max:100',
            ],


            'device_name' => [
                'required',
                'string',
                'max:150',
            ],


            'inventory_code' => [
                'nullable',
                'string',
                'max:100',
            ],


            'room_name' => [
                'required',
                'string',
                'max:150',
            ],


            'description' => [
                'required',
                'string',
                'min:10',
            ],


            'photo' => [
                'nullable',
                'image',
                'max:2048',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload foto
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            $uploadPath = public_path('uploads/tickets');

            File::ensureDirectoryExists($uploadPath);

            $file = $request->file('photo');

            $filename =
                Str::uuid() . '.' . $file->getClientOriginalExtension();

            $file->move(
                $uploadPath,
                $filename
            );

            $data['photo'] =
                'uploads/tickets/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | Data otomatis
        |--------------------------------------------------------------------------
        */

        $data['user_id'] = Auth::id();

        $data['status'] = 'waiting';


        /*
        |--------------------------------------------------------------------------
        | Simpan tiket
        |--------------------------------------------------------------------------
        */

        $ticket = Ticket::create(
            $data
        );


        /*
        |--------------------------------------------------------------------------
        | Generate nomor tiket
        |--------------------------------------------------------------------------
        */

        $ticket->update([

            'ticket_number' =>
            'HD-' .
                now()->format('Ymd') .
                '-' .

                str_pad(
                    $ticket->id,
                    4,
                    '0',
                    STR_PAD_LEFT
                ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan riwayat pertama
        |--------------------------------------------------------------------------
        */

        $ticket->updates()->create([
            'user_id' => Auth::id(),
            'status' => 'waiting',
            'note' =>
            'Pengaduan dibuat oleh staf.',

        ]);


        return redirect()
            ->route(
                'staff.tickets.show',
                $ticket
            )

            ->with(
                'success',
                'Pengaduan berhasil dikirim. Nomor tiket: ' .
                    $ticket->ticket_number
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Detail tiket
    |--------------------------------------------------------------------------
    */

    public function show(
        Ticket $ticket
    ) {

        /*
        |--------------------------------------------------------------------------
        | Keamanan
        |--------------------------------------------------------------------------
        | Staf hanya boleh melihat tiket miliknya.
        */

        abort_unless(
            $ticket->user_id === Auth::id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Ambil riwayat
        |--------------------------------------------------------------------------
        */

        $ticket->load([
            'user',
            'handler',
            'updates.user',
        ]);


        return view(
            'staff.tickets.show',
            compact(
                'ticket'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Hapus tiket
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Ticket $ticket
    ) {

        abort_unless(
            $ticket->user_id === Auth::id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Hanya tiket waiting yang boleh dihapus
        |--------------------------------------------------------------------------
        */

        if (
            $ticket->status !== 'waiting'
        ) {
            return back()
                ->withErrors([
                    'ticket' =>
                    'Tiket yang sudah diproses tidak dapat dihapus.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Hapus foto
        |--------------------------------------------------------------------------
        */

        if ($ticket->photo) {

            $photoPath =
                public_path($ticket->photo);

            if (File::exists($photoPath)) {

                File::delete($photoPath);
            }
        }


        $ticket->delete();


        return redirect()
            ->route(
                'staff.tickets.index'
            )

            ->with(
                'success',
                'Pengaduan berhasil dihapus.'
            );
    }
}
