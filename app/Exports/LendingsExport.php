<?php

namespace App\Exports;

use App\Models\BorrowedItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LendingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate = null, $toDate = null)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function collection(): Collection
    {
        $query = BorrowedItem::query()->with(['item', 'user', 'returned']);

        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('date', [$this->fromDate, $this->toDate]);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    public function headings(): array
    {
        return ['Item', 'Total', 'Name', 'Notes', 'Date', 'Return Date', 'Staff'];
    }

    public function map($item): array
    {
        $date = $item->date ? date('M d, Y', strtotime($item->date)) : '-';
        $returnDate = $item->returned?->return_date ? date('M d, Y', strtotime($item->returned->return_date)) : '-';

        return [
            $item->item?->item_name ?? '-',
            $item->total_item,
            $item->name_of_borrower ?? '-',
            $item->notes ?? '-',
            $date,
            $returnDate,
            $item->user?->name ?? '-',
        ];
    }
}
