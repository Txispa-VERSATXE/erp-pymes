<?php

namespace App\Exports;

use App\Models\Compra;
use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ComprasExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Compra::orderBy('created_at', 'desc')->get()->map(function ($c) {
            $proveedor = Proveedor::find($c->proveedor_id);
            return [
                'ID'         => '#' . strtoupper(substr($c->id, -6)),
                'Proveedor'  => $proveedor->nombre ?? '—',
                'Fecha'      => $c->fecha_compra,
                'Total'      => number_format($c->total, 2, ',', '.') . ' €',
                'Estado'     => ucfirst($c->estado),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Proveedor', 'Fecha', 'Total', 'Estado'];
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