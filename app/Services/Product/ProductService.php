<?php
namespace App\Services\Product;

use App\Models\Product;
use App\Repository\Product\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data)
    {
        return $this->productRepository->update($product, $data);
    }

    public function delete(Product $product)
    {
        if ($product->product_image)
        {
            Storage::disk('public')->delete($product->product_image);
        }

        return $this->productRepository->delete($product);
    }
}