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
use App\Models\Setting;




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
        return view('product.create', [
            'categories' => $categories,
            'sgst' => Setting::getValue('sgst_rate', 0),
            'cgst' => Setting::getValue('cgst_rate', 0),
        ]);      
    }

    public function store(StoreProductRequest $request, DepreciationService $depreciationService)
    {
        $data = $request->validated();

        if(session()->has('temp_image_path')){
            $finalPath = str_replace(
                'temp/products',
                'product',
                session('temp_image_path')
            );

            Storage::disk('public')->move(
                session('temp_image_path'),
                $finalPath
            );

            $data['product_image'] = $finalPath;

            session()->forget(['temp_image_path', 'temp_image_url']);
        }

        $sgst = Setting::getValue('sgst_rate', 0);
        $cgst = Setting::getValue('cgst_rate', 0);
        
        $baseAmount = $data['product_price'] * $data['quantity'];

        $gstAmount = ($baseAmount * ($sgst + $cgst)) / 100;
        
        $data['gst_amount'] = $gstAmount;
        $data['total_price'] = $baseAmount + $gstAmount;



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

        // return view('product.edit', compact('product', 'categories'));
        return view('product.edit', [
            'product' => $product,
            'categories' => $categories,
            'sgst' => Setting::getValue('sgst_rate', 0),
            'cgst' => Setting::getValue('cgst_rate', 0),
        ]);
    }

    public function update(UpdateProductRequest $request,Product $product, DepreciationService $depreciationService)
    {
        $data =$request->validated();

        if (session()->has('temp_image_path')) {

        if ($product->product_image) {
            Storage::disk('public')->delete($product->product_image);
        }

        $finalPath = str_replace(
            'temp/products',
            'product',
            session('temp_image_path')
        );

        Storage::disk('public')->move(
            session('temp_image_path'),
            $finalPath
        );

        $data['product_image'] = $finalPath;

        session()->forget(['temp_image_path', 'temp_image_url']);
    }

    elseif ($request->hasFile('product_image')) {

        if ($product->product_image) {
            Storage::disk('public')->delete($product->product_image);
        }

        $data['product_image'] = $request->file('product_image')
            ->store('product', 'public');
    }

            $sgst = Setting::getValue('sgst_rate', 0);
            $cgst = Setting::getValue('cgst_rate', 0);
            
            $baseAmount = $data['product_price'] * $data['quantity'];

            $gstAmount = ($baseAmount * ($sgst + $cgst)) / 100;
            
            $data['gst_amount'] = $gstAmount;
            $data['total_price'] = $baseAmount + $gstAmount;
            
            if ($data['status'] !== 'furnished') {
                $data['furnished_date'] = null;
                $data['furnished_work'] = null;
            }

            $updated = $this->productService->update($product,$data,true);
            $rate = Setting::getValue('depreciation_rate', 0);
            $depreciationService->depreciation($updated, $rate, true);


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
