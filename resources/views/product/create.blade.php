@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add New Product</h4>
        <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm">Back</a>        
    </div>    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf 
                
                <div class="mb-3">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" placeholder="Enter Product Name" value="{{ old('product_name') }}"  required>
                    @error('product_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"  required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Image <span class="text-danger">*</span></label>
                    <input type="file" name="product_image" class="form-control @error('product_image') is-invalid @enderror"  accept=".png, .jpg, .jpeg" >
                    @error('product_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Price <span class="text-danger">*</span></label>
                    <input type="number" min="1" step="0.01" name="product_price" id="product_price" class="form-control @error('product_price') is-invalid @enderror" value="{{ old('product_price') }}" placeholder="Enter Price" required>
                    @error('product_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">GST/SGST Amount</label>
                    <input type="number" min="0" step="0.01" name="gst_amount" id="gst_amount" class="form-control @error('gst_amount') is-invalid @enderror" value="{{ old('gst_amount') }}" placeholder="Enter the GST/SGST Amount">
                    @error('gst_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
              
                <div class="mb-3">
                    <label class="form-label">Total Price (including GST)</label>
                    <input type="number" name="total_price" id="total_price" class="form-control @error('total_price') is-invalid @enderror" value="{{ old('total_price') }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Purchased Date <span class="text-danger">*</span></label>
                    <input type="date" name="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date') }}" max="" required>
                    @error('purchase_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Manufacture Date <span class="text-danger">*</span></label>
                    <input type="date" name="manufacture_date" class="form-control @error('manufacture_date') is-invalid @enderror" value="{{ old('manufacture_date') }}" max="" required>
                    @error('manufacture_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" id="status" value="{{ old('status') }}" required>
                        <option value="furnished">Furnished</option>
                        <option value="non_furnished" selected>Non-Furnished</option>
                    </select>
                    
                </div>

                <div id="furnishedFields" style="display:none">
                    <div class="mb-3">
                        <label class="form-label">Date of Furnished <span class="text-danger">*</span></label>
                        <input type="date" name="furnished_date" class="form-control" value="{{ old('furnished_date') }}">
                        @error('furnished_date')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Furnished Work <span class="text-danger">*</span></label>
                        <textarea name="furnished_work" class="form-control" value="{{ old('furnished_work') }}" rows="3"></textarea>
                        @error('furnished_work')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function calculateTotal(){
        let price = parseFloat(document.getElementById('product_price').value) || 0;
        let gst = parseFloat(document.getElementById('gst_amount').value) || 0;
        document.getElementById('total_price').value = (price + gst).toFixed(2);
    }

    document.getElementById('product_price').addEventListener('input', calculateTotal);
    document.getElementById('gst_amount').addEventListener('input', calculateTotal);
</script>
<script>
    document.getElementById('status').addEventListener('change', function() {
        let furnishedDiv = document.getElementById('furnishedFields');
        if (this.value === 'furnished') {
            furnishedDiv.style.display = 'block';
        }
        else{
            furnishedDiv.style.display = 'none';
        }
    });
</script>
@endpush