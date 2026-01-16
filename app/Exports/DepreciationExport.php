<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepreciationExport implements FromCollection, WithHeadings
{
    protected array $years;

    public function __construct()
    {
        $minDate = Product::min('purchase_date');

        $startYear = $minDate
            ? Carbon::parse($minDate)->year
            : now()->year;

        $this->years = range($startYear, now()->year);
    }

    public function collection()
    {
        $rows = [];
        
        foreach (Product::with('depreciations')->get() as $index => $product)
        {
            $row = [
                'S.No' => $index + 1,
                'Product Name' => $product->product_name,
                'Purchased Date' => $product->purchase_date->format('d-m-Y'),
                'Original Cost' => $product->total_price,
            ];

            foreach ($this->years as $year)
            {
                $dep = $product->depreciations->firstWhere('year', $year);
                $row["Depreciation {$year}"] = $dep?->end_value ?? 0;
            }

            $rows[] = $row;
        }

        return collect($rows);
    }

    public function headings():array
    {
        $headings = [
            'S.No',
            'Product Name',
            'Purchased Date',
            'Origional Cost',
        ];
        foreach($this->years as $year)
        {
            $headings[] = "Depreciation {$year}";
        }
        return $headings;
    }
}