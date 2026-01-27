<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Depreciation;
use Barryvdh\DomPDF\Facade\Pdf;

class DepreciationPdfController extends Controller{
    private function getLastThreeYears()
    {
        $maxYear = Depreciation::max('year') ?? now()->year;

        return [
            $maxYear - 2,
            $maxYear - 1,
            $maxYear,
        ];
    }

    public function view()
    {
        $years = $this->getLastThreeYears();

        $products = Product::with([
            'depreciations' => function ($query) use ($years) {
                $query->whereIn('year', $years);
            }
        ])->get();

        $pdf = Pdf::loadView('pdf.productsdetails', compact('products', 'years'))
            ->setPaper('A4', 'Portrait');

        return $pdf->stream('depreciation_report.pdf');
    }

    public function download()
    {
        $years = $this->getLastThreeYears();

        $products = Product::with([
            'depreciations' => function ($query) use ($years) {
                $query->whereIn('year', $years);
            }
        ])->get();
        $pdf = Pdf::loadView('pdf.productsdetails', compact('products', 'years'))
            ->setPaper('A4', 'Portrait');
        return $pdf->download('depreciation_report.pdf');
    }
}