<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * Return an empty dataset – this is a template only.
     */
    public function array(): array
    {
        return [];
    }

    /**
     * Header row (row 1).
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
     * Register styling, data validation, and freeze pane.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                /** @var Worksheet $sheet */
                $sheet = $event->sheet->getDelegate();

                // 1) Build comma-separated list of all category names (for dropdown)
                $categories = Category::orderBy('name')
                    ->pluck('name')
                    ->toArray();
                $categoryList = implode(',', $categories);

                // 2) Apply validations to relevant columns for rows 2-500
                for ($row = 2; $row <= 500; $row++) {
                    // Product Name - Required (cannot be blank)
                    $cellA = $sheet->getCell("A{$row}");
                    $validA = $cellA->getDataValidation();
                    $validA->setType(DataValidation::TYPE_CUSTOM);
                    $validA->setAllowBlank(false);
                    $validA->setShowInputMessage(true);
                    $validA->setPromptTitle('Required');
                    $validA->setPrompt('Product Name is required.');
                    $validA->setShowErrorMessage(true);
                    $validA->setErrorTitle('Missing Product Name');
                    $validA->setError('This field is required.');
                    $validA->setFormula1('LEN(TRIM(A'.$row.'))>0');

                    // Category - dropdown, allow blank if desired
                    $cellB = $sheet->getCell("B{$row}");
                    $validB = $cellB->getDataValidation();
                    $validB->setType(DataValidation::TYPE_LIST);
                    $validB->setErrorStyle(DataValidation::STYLE_STOP);
                    $validB->setAllowBlank(false);
                    $validB->setShowInputMessage(true);
                    $validB->setShowDropDown(true);
                    $validB->setErrorTitle('Invalid Category Selection');
                    $validB->setError('Please select a category from the provided dropdown list only.');
                    $validB->setPromptTitle('Category Selection');
                    $validB->setPrompt('Select a category from the list.');
                    $validB->setShowErrorMessage(true);
                    $validB->setFormula1('"' . $categoryList . '"');

                    // Purchase Price - numeric, minimum 0, required
                    $cellC = $sheet->getCell("C{$row}");
                    $validC = $cellC->getDataValidation();
                    $validC->setType(DataValidation::TYPE_DECIMAL);
                    $validC->setErrorStyle(DataValidation::STYLE_STOP);
                    $validC->setAllowBlank(false);
                    $validC->setShowInputMessage(true);
                    $validC->setShowErrorMessage(true);
                    $validC->setErrorTitle('Invalid Purchase Price');
                    $validC->setError('Please enter a non-negative number for purchase price.');
                    $validC->setPromptTitle('Purchase Price');
                    $validC->setPrompt('Enter a number. Must be zero or greater.');
                    $validC->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);
                    $validC->setFormula1(0);

                    // Selling Price - numeric, minimum 0, required
                    $cellD = $sheet->getCell("D{$row}");
                    $validD = $cellD->getDataValidation();
                    $validD->setType(DataValidation::TYPE_DECIMAL);
                    $validD->setErrorStyle(DataValidation::STYLE_STOP);
                    $validD->setAllowBlank(false);
                    $validD->setShowInputMessage(true);
                    $validD->setShowErrorMessage(true);
                    $validD->setErrorTitle('Invalid Selling Price');
                    $validD->setError('Please enter a non-negative number for selling price.');
                    $validD->setPromptTitle('Selling Price');
                    $validD->setPrompt('Enter a number. Must be zero or greater.');
                    $validD->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);
                    $validD->setFormula1(0);

                    // Stock - integer, minimum 0, not required (can be left blank)
                    $cellE = $sheet->getCell("E{$row}");
                    $validE = $cellE->getDataValidation();
                    $validE->setType(DataValidation::TYPE_WHOLE);
                    $validE->setErrorStyle(DataValidation::STYLE_STOP);
                    $validE->setAllowBlank(true);
                    $validE->setShowInputMessage(true);
                    $validE->setShowErrorMessage(true);
                    $validE->setErrorTitle('Invalid Stock');
                    $validE->setError('Please enter a non-negative whole number (or leave blank).');
                    $validE->setPromptTitle('Stock');
                    $validE->setPrompt('Enter a non-negative whole number. Leave blank for zero.');
                    $validE->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);
                    $validE->setFormula1(0);
                }

                // Header style
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

                // Freeze first row
                $sheet->freezePane('A2');
            },
        ];
    }
}
