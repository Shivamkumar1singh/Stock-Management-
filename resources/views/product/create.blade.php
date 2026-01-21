@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add New Product</h4>
        <a href="{{ route('product.temp.cancel') }}" class="btn btn-secondary btn-sm">Back</a>        
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
                            <option value="{{ $category->id }}" 
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Image <span class="text-danger">*</span></label>
                    <input type="file" name="product_image" id="product_image_input" class="form-control @error('product_image') is-invalid @enderror"  accept=".png, .jpg, .jpeg" >
                    @if(Session::has('temp_image_path'))
                        <input type="hidden" name="existing_temp_image" value="{{ Session::get('temp_image_path') }}">
                    @endif
                    @error('product_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="image_preview_container" class="mt-2" style="{{ Session::has('temp_image_url') ? 'display: block;' : 'display: none;' }}">
                    <p class="small text-muted">Selected image:</p>
                    <img id="image_preview" src="{{ Session::get('temp_image_url') ?? '' }}" alt="Preview" style="width: 80px;" class="img-thumbnail">
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Price <span class="text-danger">*</span></label>
                    <input type="number" min="1" step="0.01" name="product_price" id="product_price" class="form-control @error('product_price') is-invalid @enderror" value="{{ old('product_price') }}" placeholder="Enter Price" required>
                    @error('product_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="quantity" min="1" max="100" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity',1) }}" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label">GST Amount (Auto Calculated)</label>
                    <input type="number" id="gst_amount" class="form-control" readonly>
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
                    <a href="{{ route('product.temp.cancel') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const sgst = {{ $sgst }};
    const cgst = {{ $cgst }};

    function calculateGST() {
        let price = parseFloat(document.getElementById('product_price').value) || 0;
        let quantity = parseFloat(document.getElementById('quantity').value) || 1;
        if (quantity>=1 && quantity<=100)
        {
            let baseAmount = price * quantity;
    
            let gstAmount = baseAmount * (sgst + cgst) / 100;
            let total = baseAmount + gstAmount;
    
            document.getElementById('gst_amount').value = gstAmount.toFixed(2);
            document.getElementById('total_price').value = total.toFixed(2);
        }
    }

    document.getElementById('product_price').addEventListener('input', calculateGST);
    document.getElementById('quantity').addEventListener('input', calculateGST);
    calculateGST();
</script>

<script>
    document.getElementById('product_image_input').addEventListener('change', function(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('image_preview');
        const container = document.getElementById('image_preview_container');
        output.src = reader.result;
        container.style.display = 'block';
    };
    if(event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
});
</script>


<script>
    let isSubmitting = false;

    document.querySelector('form').addEventListener('submit', function () {
        isSubmitting = true;
    });

    window.addEventListener('beforeunload', function () {
        if (isSubmitting) return;

        navigator.sendBeacon(
            "{{ route('product.temp.clear') }}"
        );
    });
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