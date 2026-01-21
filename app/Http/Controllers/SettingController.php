<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Setting\UpdateSettingRequests;
use App\Services\Depreciation\DepreciationService;
use App\Models\Setting;

class SettingController extends Controller
{
    public function edit()
    {
        return view('setting.edit', [
            'sgst' => Setting::getValue('sgst_rate'),
            'cgst' => Setting::getValue('cgst_rate'),
            'depreciation' => Setting::getValue('depreciation_rate'),
        ]);
    }

    public function update(UpdateSettingRequests $request, DepreciationService $depreciationService)
    {
        foreach ($request->only([
            'sgst_rate',
            'cgst_rate',
            'depreciation_rate'
        ]) as $key => $value) {
        
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        
            cache()->forget("setting_$key");
        }

        $sgst = Setting::getValue('sgst_rate', 0);
        $cgst = Setting::getValue('cgst_rate', 0);
        $depreciationRate = Setting::getValue('depreciation_rate', 0);

        Product::chunk(100,function ($products) use (
            $sgst,
            $cgst,
            $depreciationRate,
            $depreciationService
        ) {
            foreach ($products as $product) {
                $quantity = $product->quantity ?? 1;

                $baseAmount = $product->product_price * $quantity;
                
                $gstAmount = ($baseAmount * ($sgst + $cgst)) / 100;
                
                $totalPrice = $baseAmount + $gstAmount;

                $product->update([
                    'gst_amount' => $gstAmount,
                    'total_price' => $totalPrice,
                ]);

                $depreciationService->depreciation(
                    $product,$depreciationRate,true
                );
            }
        });

        return back()->with('success', 'Settings updated successfully');
    }
}
