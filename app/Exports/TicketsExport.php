<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    public function __construct(
        protected ?string $search = null,
        protected ?string $status = null,
        protected ?string $month = null,
    ) {
    }

    public function query(): Builder
    {
        return Ticket::query()
            ->with(['user', 'handler'])

            ->when($this->search, function ($query) {

                $search = $this->search;

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'ticket_number',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'device_name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'room_name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas(
                        'user',
                        function ($userQuery) use ($search) {

                            $userQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );

                });

            })

            ->when($this->status, function ($query) {

                $query->where(
                    'status',
                    $this->status
                );

            })

            ->when($this->month, function ($query) {

                $query->whereRaw(
                    "DATE_FORMAT(created_at, '%Y-%m') = ?",
                    [$this->month]
                );

            })

            ->latest();
    }

    public function headings(): array
    {
        return [
            'No Tiket',
            'Pelapor',
            'Jenis Perangkat',
            'Nama / Identitas Perangkat',
            'Kode Inventaris',
            'Lokasi / Ruangan',
            'Status',
            'Tanggal Pengaduan',
            'Catatan Perbaikan',
            'Teknisi',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->user?->name ?? '-',
            $ticket->device_type,
            $ticket->device_name,
            $ticket->inventory_code ?: '-',
            $ticket->room_name,

            match ($ticket->status) {
                'waiting' => 'Menunggu Respons',
                'processing' => 'Sedang Diproses',
                'completed' => 'Selesai',
                default => $ticket->status,
            },

            $ticket->created_at?->format('d/m/Y H:i') ?? '-',

            $ticket->repair_note ?: '-',

            $ticket->handler?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => '2563EB',
                    ],
                ],
            ],
        ];
    }
}