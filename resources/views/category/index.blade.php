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
            <i class="ph ph-clipboard-text me-2">Category</i> 
        </h3>
    
        <a href="{{ route('category.create') }}" class="btn btn-primary">
            Add New Category
        </a>
    </div>

</div>


<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover" id="categoryTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Category Name</th>
                        <th>Date Of Category Creation</th>
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
let categoryTable;

$(function () {

    categoryTable = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: "{{ route('category.datatable')}}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name' },
            { data: 'created_at'},
            { data: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>

@endpush