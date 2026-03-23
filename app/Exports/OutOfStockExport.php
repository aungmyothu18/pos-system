<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OutOfStockExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $products;

    public function __construct(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        return $this->products->map(function ($product) {
            return [
                $product->name,
                optional($product->category)->name ?? '-',
                $product->purchase_price ?? 0,
                $product->price ?? 0,
                $product->stock ?? 0,
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Product Name',
            'Category',
            'Purchase Price',
            'Selling Price',
            'Stock',
        ];
    }

    /**
     * Apply styles to the worksheet.
     *
     * - Header row (row 1) bold with light gray background
     * - Wrap text for Product Name column
     * - Center align Category and Stock columns
     */
    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();

        // Header row styling
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFE5E5E5', // light gray
                ],
            ],
        ]);

        // Wrap text for Product Name column (A)
        $sheet->getStyle("A1:A{$highestRow}")
            ->getAlignment()
            ->setWrapText(true);

        // Center align Category (B) and Stock (E) columns
        $sheet->getStyle("B1:B{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("E1:E{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}

