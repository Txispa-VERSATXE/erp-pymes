<?php

namespace App\Exports;

use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProveedoresExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Proveedor::orderBy('created_at', 'desc')->get()->map(function ($p) {
            return [
                'Nombre'    => $p->nombre,
                'Email'     => $p->email,
                'Teléfono'  => $p->telefono ?? '—',
                'Dirección' => $p->direccion ?? '—',
                'Alta'      => $p->created_at?->format('d/m/Y'),
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