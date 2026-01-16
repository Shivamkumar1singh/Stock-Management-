@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add New Category </h4>
        <a href="{{ route('category.index') }}" class="btn btn-secondary btn-sm">Back</a>        
    </div>    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf 
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter Product Name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Category</button>
                    <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
