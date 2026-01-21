<?php

namespace App\DataTables;
use Carbon\Carbon;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

class ProductDataTable
{
    public function make($request)
    {
        $query = Product::select([
            'id',
            'product_image',
            'product_name',
            'product_price',
            'quantity',
            'gst_amount',
            'total_price',
            'purchase_date',
            'manufacture_date',
            'status',
            'created_at',
        ])->latest();


        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('product_image', function ($product) {
                return $product->product_image?'<img src="'.asset('storage/'.$product->product_image).'" width="50" height="50">':'-';
            })
            ->editColumn('status', function ($product) {
                return $product->status === 'furnished'? '<span class="badge bg-success">Furnished</span>': '<span class="badge bg-secondary">Non-Furnished</span>';
            })
            ->editColumn('purchase_date', function ($product) {
                return $product->purchase_date
                    ? Carbon::parse($product->purchase_date)->format('d-m-Y')
                    : '-';
            })
    
            ->editColumn('manufacture_date', function ($product) {
                return $product->manufacture_date
                    ? Carbon::parse($product->manufacture_date)->format('d-m-Y')
                    : '-';
            })

            ->editColumn('furnished_date', function ($product){
                return $product->furnished_date
                ? Carbon::parse($product->furnished_date)->format('d-m-Y')
                : '-';
            })
            ->addColumn('actions', function ($product) {
                return '
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="'.route('product.show', $product->id).'" class="btn btn-sm btn-info px-3">Show</a>
                        <a href="'.route('product.edit', $product->id).'" class="btn btn-sm btn-warning px-3">Edit</a>
                        <form method="POST" action="'.route('product.destroy', $product->id).'"> 
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger px-3" onclick="return confirm(\'Delete this product?\')">Delete</button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['product_image', 'status', 'actions'])
            ->make(true);
    }
}