@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Product Details</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-4 text-center">
                    @if(!empty($product->product_image))
                        <img src="{{ asset('storage/'.$product->product_image) }}"
                             class="img-fluid rounded border"
                             style="max-height:260px">
                    @else
                        <div class="border rounded p-5 text-muted">
                            No Image
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered align-middle">
                        <tbody>

                            <tr>
                                <th width="35%">Product Name</th>
                                <td>{{ $product->product_name }}</td>
                            </tr>

                            <tr>
                                <th>Category</th>
                                <td>{{ $product->category->name ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Product Price</th>
                                <td>₹ {{ number_format($product->product_price, 2) }}</td>
                            </tr>

                            <tr>
                                <th>GST / SGST Amount</th>
                                <td>₹ {{ number_format($product->gst_amount ?? 0, 2) }}</td>
                            </tr>

                            <tr>
                                <th>Total Price</th>
                                <td>
                                    <strong>₹ {{ number_format($product->total_price, 2) }}</strong>
                                </td>
                            </tr>

                            <tr>
                                <th>Current Price</th>
                                <td>
                                    <strong>₹ {{ number_format($product->current_value, 2) }}</strong>
                                </td>
                            </tr>

                            <tr>
                                <th>Purchased Date</th>
                                <td>{{ $product->purchase_date ? \Carbon\Carbon::parse($product->purchase_date)->format('d-m-Y') : '-'}}</td>
                            </tr>

                            <tr>
                                <th>Manufacture Date</th>
                                <td>{{ $product->manufacture_date ? \Carbon\Carbon::parse($product->manufacture_date)->format('d-m-Y') : '-' }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($product->status === 'furnished')
                                        <span class="badge bg-success">Furnished</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Furnished</span>
                                    @endif
                                </td>
                            </tr>

                            @if($product->status === 'furnished')
                                <tr>
                                    <th>Date of Furnished</th>
                                    <td>{{ $product->furnished_date ? \Carbon\Carbon::parse($product->furnished_date)->format('d-m-Y') : '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Furnished Work</th>
                                    <td>{{ $product->furnished_work ?? '-' }}</td>
                                </tr>
                            @endif

                            <tr>
                                <th>Created At</th>
                                <td>{{ $product->created_at->format('Y-m-d') }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
