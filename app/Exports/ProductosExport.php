<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductosExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Producto::orderBy('created_at', 'desc')->get()->map(function ($p) {
            return [
                'Nombre'     => $p->nombre,
                'Categoría'  => $p->categoria,
                'Precio (€)' => number_format($p->precio, 2, ',', '.'),
                'Stock'      => $p->stock,
                'Stock mín.' => $p->umbral_min,
                'Estado'     => $p->stock == 0 ? 'Sin stock' : ($p->stock <= $p->umbral_min ? 'Stock bajo' : 'Disponible'),
                'Alta'       => $p->created_at?->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Nombre', 'Categoría', 'Precio (€)', 'Stock', 'Stock mín.', 'Estado', 'Alta'];
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