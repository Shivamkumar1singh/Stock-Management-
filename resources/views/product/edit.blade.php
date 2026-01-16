@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Product Details</h4>
        <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                 

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name', $product->product_name) }}" required>
                    @error('product_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ $product->category_id == $category->id ? 'selected' : ''}}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="product_image" class="form-control @error('product_image') is-invalid @enderror">
                    @if ($product->product_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$product->product_image) }}" width="80" class="img-thumbnail" alt="Product Image">
                        </div>
                    @endif
                    @error('product_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> 

                <div class="mb-3">
                    <label class="form-label">Product Price</label>
                    <input type="number" min="1" step="0.01" name="product_price" id="product_price" class="form-control @error('product_price') is-invalid @enderror" value="{{ $product->product_price }}" required>
                    @error('product_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">GST/SGST Amount</label>
                    <input type="number" min="1" step="0.01" name="gst_amount" id="gst_amount" class="form-control @error('gst_amount') is-invalid @enderror" value="{{ $product->gst_amount }}">
                    @error('gst_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Price</label>
                    <input type="number" step="0.01" name="total_price" id="total_price" class="form-control @error('total_price') is-invalid @enderror" value="{{ $product->total_price }}" readonly>
                    @error('total_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Purchased Date</label>
                    <input type="date" name="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ optional($product->purchase_date)->format('Y-m-d') }}" required>
                    @error('purchase_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Manufacture Date</label>
                    <input type="date" name="manufacture_date" class="form-control @error('manufacture_date') is-invalid @enderror" value="{{ optional($product->manufacture_date)->format('Y-m-d') }}" required>
                    @error('manufacture_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" id="status" required>
                        <option value="">Select Status</option>
                        <option value="furnished" {{ $product->status === 'furnished' ? 'selected' : ''}}>Furnished</option>
                        <option value="non_furnished" {{ $product->status === 'non_furnished' ? 'selected' : '' }}>Non-Furnished</option>
                    </select>
                </div>

                <div id="furnishedFields" style="{{ $product->status === 'furnished' ? 'display:block' : 'display:none' }}">
                    <div class="mb-3">
                        <label class="form-label">Date of Furnished</label>
                        <input type="date" name="furnished_date" class="form-control" value="{{ optional($product->furnished_date)->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Furnished Work</label>
                        <textarea name="furnished_work" class="form-control" rows="3">{{ $product->furnished_work }}</textarea>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
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
    document.getElementById('status').addEventListener('change', function () {
        let furnishedDiv = document.getElementById('furnishedFields');
        furnishedDiv.style.display = this.value === 'furnished' ? 'block' : 'none';
    });
</script>
@endpush