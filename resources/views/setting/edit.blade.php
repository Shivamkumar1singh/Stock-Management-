@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button>
    </div>
@endif

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="ph ph-clipboard-text me-2">Settings</i> 
        </h3>
    </div>

</div>
<div class="card">
    <div class="card-body">
        <div class="container">
    <h4>CGST & SGST TAX & Depreciation Rate Settings</h4>    
        <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data" novalidate>
            @csrf
    
            <div class="mb-3">
                <label>SGST (%)</label>
                <input type="number" min="0" step="0.01" name="sgst_rate" class="form-control @error('sgst_rate') is-invalid @enderror" value="{{ $sgst }}" required>
                @error('sgst_rate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-3">
                <label>CGST (%)</label>
                <input type="number" min="0" step="0.01" name="cgst_rate" class="form-control @error('cgst_rate') is-invalid @enderror" value="{{ $cgst }}" required>
                @error('cgst_rate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-3">
                <label>Depreciation Rate (%)</label>
                <input type="number" min="0" step="0.01" name="depreciation_rate" class="form-control @error('depreciation_rate') is-invalid @enderror" value="{{ $depreciation }}" required>
                @error('depreciation_rate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <button class="btn btn-primary">Save Settings</button>
        </form>
    </div>
    </div>
</div>
@endsection