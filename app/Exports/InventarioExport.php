<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventarioExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Producto::orderBy('nombre')->get()->map(function ($p) {
            $bajo = $p->stock <= $p->umbral_min;
            return [
                'Producto'   => $p->nombre,
                'Categoría'  => $p->categoria,
                'Stock'      => $p->stock,
                'Mínimo'     => $p->umbral_min,
                'Estado'     => $p->stock == 0 ? 'Sin stock' : ($bajo ? 'Stock bajo' : 'OK'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Producto', 'Categoría', 'Stock', 'Mínimo', 'Estado'];
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