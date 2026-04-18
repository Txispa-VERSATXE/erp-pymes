<?php

namespace App\Exports;

use App\Models\Venta;
use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VentasExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Venta::orderBy('created_at', 'desc')->get()->map(function ($v) {
            $cliente = Cliente::find($v->cliente_id);
            return [
                'ID'       => '#' . strtoupper(substr($v->id, -6)),
                'Cliente'  => $cliente->nombre ?? '—',
                'Fecha'    => $v->fecha_venta,
                'Total'    => number_format($v->total, 2, ',', '.') . ' €',
                'Estado'   => ucfirst($v->estado),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Cliente', 'Fecha', 'Total', 'Estado'];
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