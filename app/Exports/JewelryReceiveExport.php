<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JewelryReceiveExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $receives;

    public function __construct(Collection $receives)
    {
        $this->receives = $receives;
    }

    public function collection(): Collection
    {
        $rows = [];
        $rowNumber = 1;

        foreach ($this->receives as $receive) {
            $receiveDate = optional($receive->receive_date)->format('Y-m-d');
            $itemsCount = (int) ($receive->items_count ?? $receive->total_items ?? 0);
            $totalValue = (float) ($receive->total_value ?? 0);
            $status = $receive->status ?? 'received';

            $items = $receive->items ?? collect();

            // If no items loaded, still export the receive row with blank item columns
            if ($items instanceof Collection && $items->isEmpty()) {
                $rows[] = [
                    $rowNumber++,
                    $receive->id,
                    $receiveDate,
                    $receive->customer_name ?? '',
                    $receive->customer_phone ?? '',
                    $receive->overall_note ?? '',
                    $itemsCount,
                    $totalValue,
                    $status,
                    '', // item type
                    '', // kyat
                    '', // pae
                    '', // yway
                    '', // point
                    '', // color
                    '', // price
                    '', // remark
                ];
                continue;
            }

            foreach ($items as $item) {
                $rows[] = [
                    $rowNumber++,
                    $receive->id,
                    $receiveDate,
                    $receive->customer_name ?? '',
                    $receive->customer_phone ?? '',
                    $receive->overall_note ?? '',
                    $itemsCount,
                    $totalValue,
                    $status,
                    $item->type ?? '',
                    $item->kyat ?? '',
                    $item->pae ?? '',
                    $item->yway ?? '',
                    $item->point ?? '',
                    $item->color ?? '',
                    $item->price ?? '',
                    $item->remark ?? '',
                ];
            }
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'No',
            'Receive ID',
            'Receive Date',
            'Customer Name',
            'Customer Phone',
            'Overall Note',
            'Total Items',
            'Total Value',
            'Status',
            'Item Type',
            'Kyat',
            'Pae',
            'Yway',
            'Point',
            'Color',
            'Item Price',
            'Remark',
        ];
    }
}
