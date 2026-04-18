<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Cliente::orderBy('created_at', 'desc')->get()->map(function ($c) {
            return [
                'Nombre'    => $c->nombre,
                'Email'     => $c->email,
                'Teléfono'  => $c->telefono ?? '—',
                'Dirección' => $c->direccion ?? '—',
                'Alta'      => $c->created_at?->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Nombre', 'Email', 'Teléfono', 'Dirección', 'Alta'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1a3a5c']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}