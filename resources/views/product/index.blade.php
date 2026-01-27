@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="ph ph-clipboard-text me-2">Product</i> 
        </h3>
        <div class="d-flex gap-2">
            <a href="{{ route('product.depreciation.export') }}" class="btn btn-success">
                Export
            </a>
            <a href="{{ route('depreciation.pdf.view') }}" class="btn btn-primary">
                View PDF
            </a>
            
            <a href="{{ route('depreciation.pdf.download') }}" class="btn btn-info">
                Download PDF
            </a>
            <a href="{{ route('product.create') }}" class="btn btn-primary">
                Add New Product
            </a>
        </div>
        
    </div>

</div>

<div class="card">
    <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table-hover" id="productTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Quantity</th>
                        <th>CGST+SGST Amount</th>
                        <th>Total Cost</th>
                        <th>Date Of Purchased</th>
                        <th>Date Of Manufacture</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>

<script>
let productTable;

$(function () {

    productTable = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: "{{ route('product.datatable')}}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'product_image' },
            { data: 'product_name' },
            { data: 'product_price' },
            { data: 'quantity' },
            { data: 'gst_amount'},
            { data: 'total_price' },
            { data: 'purchase_date' },
            { data: 'manufacture_date'},
            { data: 'status', orderable: false },
            { data: 'actions', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at', visible: false, searchable: false }
        ]
    });
});
</script>

@endpush