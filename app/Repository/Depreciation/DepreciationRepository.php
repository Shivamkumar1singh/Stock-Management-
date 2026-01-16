<?php

namespace App\Repository\Depreciation;

use App\Models\Product;
use App\Models\Depreciation;

class DepreciationRepository
{
    public function exists(Product $product, int $year)
    {
        return $product->depreciations()->where('year', $year)->exists();
    }

    public function getEndValue(Product $product, int $year)
    {
        return $product->depreciations()->where('year', $year)->value('end_value');
    }

    public function create($data)
    {
        return Depreciation::create($data);
    }

    public function deleteByProduct(Product $product): void
    {
        $product->depreciations()->delete();
    }
}