<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'product_image',
        'product_price',
        'gst_amount',
        'total_price',
        'purchase_date',
        'manufacture_date',
        'status',
        'furnished_date',
        'furnished_work',
        'current_value'
    ];

    protected $casts = [
        'purchase_date'     => 'date',
        'manufacture_date'  => 'date',
        'furnished_date'    => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function depreciations()
    {
        return $this->hasMany(Depreciation::class);
    }
}
