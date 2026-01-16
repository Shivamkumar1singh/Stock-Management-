<?php

namespace App\Repository\Product;

use App\Models\Product;

class ProductRepository
{
    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    

    public function delete(Product $product)
    {
        return $product->delete();
    }
}
