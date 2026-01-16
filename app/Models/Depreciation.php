<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depreciation extends Model
{
    protected $table = 'product_depreciations';
    
    protected $fillable = [
        'product_id',
        'year',
        'start_value',
        'depreciation_rate',
        'depreciation_amount',
        'end_value',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
