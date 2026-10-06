<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTicketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar semua tiket
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Ticket::with([
            'user',
            'handler'
        ])->latest();


        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status') &&
            in_array(
                $request->status,
                [
                    'waiting',
                    'processing',
                    'completed'
                ]
            )
        ) {
            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pencarian
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'ticket_number',
                    'like',
                    '%' . $search . '%'
                )

                    ->orWhere(
                        'device_name',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'room_name',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhereHas(
                        'user',
                        function ($userQuery) use ($search) {

                            $userQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter bulan
        |--------------------------------------------------------------------------
        */

        $topDevices = null;

        if ($request->filled('month')) {

            // request('month') formatnya "2026-09" (dari <input type="month">)
            [$year, $month] = explode('-', $request->month);

            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);


            /*
            |--------------------------------------------------------------------------
            | Rekap perangkat paling sering dilaporkan pada bulan tersebut
            |--------------------------------------------------------------------------
            */

            $topDevices = Ticket::selectRaw(
                'device_name, device_type, COUNT(*) as total'
            )
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->groupBy('device_name', 'device_type')
                ->orderByDesc('total')
                ->limit(10)
                ->get();
        }


        $tickets = $query
            ->paginate(10)
            ->withQueryString();


        return view(
            'admin.tickets.index',
            compact('tickets', 'topDevices')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Detail tiket
    |--------------------------------------------------------------------------
    */

    public function show(Ticket $ticket)
    {
        $ticket->load([
            'user',
            'handler',
            'updates.user'
        ]);


        return view(
            'admin.tickets.show',
            compact('ticket')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update tiket
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Ticket $ticket
    ) {

        /*
        |--------------------------------------------------------------------------
        | Validasi input
        |--------------------------------------------------------------------------
        */

        $data = $request->validate(

            [
                'status' => [
                    'required',
                    'in:waiting,processing,completed'
                ],

                'repair_note' => [
                    'nullable',
                    'string',
                    'min:3'
                ],
            ],

            [
                'repair_note.min' =>
                'Catatan minimal 3 karakter.'
            ]

        );


        /*
        |--------------------------------------------------------------------------
        | Status lama dan baru
        |--------------------------------------------------------------------------
        */

        $oldStatus = $ticket->status;

        $newStatus = $data['status'];


        /*
        |--------------------------------------------------------------------------
        | Tiket selesai tidak boleh diproses lagi
        |--------------------------------------------------------------------------
        */

        if ($oldStatus === 'completed') {

            return back()
                ->withErrors([
                    'status' =>
                    'Tiket yang sudah selesai tidak dapat diproses kembali.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Cegah langsung Waiting → Completed
        |--------------------------------------------------------------------------
        */

        if (
            $newStatus === 'completed' &&
            $oldStatus !== 'processing'
        ) {

            return back()
                ->withErrors([
                    'status' =>
                    'Tiket harus berstatus Sedang Diproses sebelum dapat diselesaikan.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Catatan wajib jika selesai
        |--------------------------------------------------------------------------
        */

        if (
            $newStatus === 'completed' &&
            empty(trim($data['repair_note'] ?? ''))
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'repair_note' =>
                    'Catatan perbaikan wajib diisi saat status Selesai.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Update data tiket
        |--------------------------------------------------------------------------
        */

        $ticket->status = $newStatus;

        $ticket->handled_by = Auth::id();


        /*
        |--------------------------------------------------------------------------
        | Catatan perbaikan
        |--------------------------------------------------------------------------
        */

        if (
            !empty(trim($data['repair_note'] ?? ''))
        ) {

            $ticket->repair_note =
                $data['repair_note'];
        }


        /*
        |--------------------------------------------------------------------------
        | Waktu selesai
        |--------------------------------------------------------------------------
        */

        if ($newStatus === 'completed') {

            $ticket->completed_at = now();
        }


        $ticket->save();


        /*
        |--------------------------------------------------------------------------
        | Simpan riwayat
        |--------------------------------------------------------------------------
        */

        $shouldCreateHistory =
            $oldStatus !== $newStatus ||
            !empty(trim($data['repair_note'] ?? ''));


        if ($shouldCreateHistory) {

            $ticket->updates()->create([

                'user_id' => Auth::id(),

                'status' => $newStatus,

                'note' =>
                $data['repair_note']
                    ?? 'Status tiket diperbarui oleh admin/teknisi.',

            ]);
        }


        return back()->with(

            'success',

            'Tiket berhasil diperbarui.'

        );
    }

    public function export(Request $request)
    {
        return Excel::download(
            new TicketsExport(
                $request->input('search'),
                $request->input('status'),
                $request->input('month'),
            ),
            'rekapan-tiket-helpdesk.xlsx'
        );
    }
}
