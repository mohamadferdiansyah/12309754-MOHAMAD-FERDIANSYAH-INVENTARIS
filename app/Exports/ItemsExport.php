<?php

namespace App\Exports;

use App\Models\ItemStock;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return ItemStock::query()
            ->with('category')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Category',
            'Name Item',
            'Total Stock',
            'Total Repaired',
            'Total Borrowed',
            'Last Updated',
        ];
    }

    public function map($item): array
    {
        return [
            $item->category?->name ?? '-',
            $item->item_name,
            $item->total_stock,
            $item->total_repaired == 0 ? '-' : $item->total_repaired,
            $item->total_borrowed == 0 ? '-' : $item->total_borrowed,
            $item->updated_at?->format('M d, Y'),
        ];
    }
}