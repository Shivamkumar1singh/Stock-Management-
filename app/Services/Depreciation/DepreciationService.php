<?php

namespace App\Services\Depreciation;

use App\Models\Product;
use App\Repository\Depreciation\DepreciationRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class DepreciationService
{
    protected DepreciationRepository $depreciation_repo;

    public function __construct(DepreciationRepository $depreciation_repo)
    {
        $this->depreciation_repo = $depreciation_repo;
    }

    public function depreciation(Product $product, ?float $rate = null, bool $forceRegenerate = false)
    {
        $rate = $rate ?? Setting::getValue('depreciation_rate', 0);
        DB::transaction(function () use ($product, $rate, $forceRegenerate) {

            if ($forceRegenerate) {
                $this->depreciation_repo->deleteByProduct($product);
            }
    
            $purchaseYear = $product->purchase_date->year;
            $currentYear = now()->year;
    
            $depreciationStartYear = ($product->purchase_date)->isStartOfYear() ? $purchaseYear : $purchaseYear+1;
    
            if ($purchaseYear === $currentYear) 
            {
                if (! $this->depreciation_repo->exists($product, $currentYear)) 
                {
                    $this->depreciation_repo->create([
                        'product_id'          => $product->id,
                        'year'                => $currentYear,
                        'start_value'         => $product->total_price,
                        'depreciation_rate'   => 0,
                        'depreciation_amount' => 0,
                        'end_value'           => $product->total_price,
                    ]);
                }
        
                $product->update([
                    'current_value' => $product->total_price,
                ]);
        
                return; 
            }
    
            $start_value = $product->total_price;
            $end_value=$start_value;
            for($year = $depreciationStartYear; $year <= $currentYear; $year++)
            {
                if($year === $depreciationStartYear)
                {
                    if(! $this->depreciation_repo->exists($product, $year))
                    {
                        $this->depreciation_repo->create([
                            'product_id' => $product->id,
                            'year' => $year,
                            'start_value' => $start_value,
                            'depreciation_rate' => 0,
                            'depreciation_amount' =>0,
                            'end_value' => $start_value,
                        ]);
                    }
                    continue;
                }
    
                if($this->depreciation_repo->exists($product, $year))
                {
                    $start_value = $this->depreciation_repo->getEndValue($product, $year);
                    $end_value   = $start_value;
                    continue;
                }
    
                $depreciationAmount = round(($start_value * $rate) / 100, 2);
                $end_value = max(round($start_value - $depreciationAmount,2),0);
    
                $this->depreciation_repo->create([
                    'product_id' => $product->id,
                    'year' => $year,
                    'start_value' => $start_value,
                    'depreciation_rate' => $rate,
                    'depreciation_amount' => $depreciationAmount,
                    'end_value' => $end_value,
                ]);
    
                $start_value = $end_value;
            }
            
            $product->update([
                'current_value' => $end_value ?? 0,
            ]);
        });
    }
}