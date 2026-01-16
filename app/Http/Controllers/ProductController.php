<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\DataTables\ProductDataTable;
use App\Services\Product\ProductService;
use App\Services\Depreciation\DepreciationService;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Exports\DepreciationExport;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    protected ProductService $productService;
    
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    public function index()
    {
        return view('product.index');
    }

    public function datatable(Request $request, ProductDataTable $dataTable)
    {
        return $dataTable->make($request);
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('product.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));       
    }

    public function store(StoreProductRequest $request, DepreciationService $depreciationService)
    {
        $data = $request->validated();

        if ($request->hasFile('product_image')) {
            $data['product_image'] = $request->file('product_image')
               ->store('product', 'public');
        }

        $data['total_price'] = ($data['product_price'] ?? 0) + ($data['gst_amount'] ?? 0);

        if (($data['status'] ?? null) !== 'furnished') {
            $data['furnished_date'] = null;
            $data['furnished_work'] = null;
        }

        $product = $this->productService->store($data);
        

        $depreciationService->depreciation($product);

        return redirect()->route('product.index')->with('success', 'Product create successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('product.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request,Product $product, DepreciationService $depreciationService)
    {
        $data =$request->validated();

        if ($request->hasFile('product_image'))
        {
            if($product->product_image)
            {
                Storage::disk('public')->delete($product->product_image);
            }
            $data['product_image'] = $request->file('product_image')->store('product','public');
        }
            $data['total_price'] = ($data['product_price'] ?? 0) + ($data['gst_amount'] ?? 0);
            
            if ($data['status'] !== 'furnished') {
                $data['furnished_date'] = null;
                $data['furnished_work'] = null;
            }

            $updated = $this->productService->update($product,$data,true);
            $depreciationService->depreciation($updated,5,true);

            return redirect()->route('product.index')->with('success', 'Product updated successfully.');
        
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return redirect()->route('product.index')->with('success', 'product deleted successfully');
    }

    public function exportDepreciation()
    {
        return Excel::download(new DepreciationExport(), 'product-depreciation.xlsx');
    }

}
