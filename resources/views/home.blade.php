@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="container mt-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">
                        <i class="ph ph-clipboard-text me-2">Dashboard</i> 
                    </h3>
                </div>
            
            
                <h4>Welcome Back, {{ Auth::user()->name }} </h4>

            </div>
        </div>
    </div>
</div>
@endsection
