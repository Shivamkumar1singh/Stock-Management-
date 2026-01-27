<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Depreciation Details</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            border:1px solid black;
            padding: 8px;
            text-align: left;
        }
        
    </style>

</head> 
<body>
    <h2>Product Depreciation Details</h2>
    <table>
        <thead>
            <tr>
                <th><b>S.No</b></th>
                <th><b>Product Name</b></th>
                <th><b>Purchased Date</b></th>
                <th><b>Original Cost</b></th>
                @foreach($years as $year)
                    <th><b>Depreciation {{ $year }}</b></th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->purchase_date->format('d-m-Y') }}</td>
                    <td>{{ $product->total_price}}</td>
                    @foreach($years as $year)
                        @php
                            $dep = $product->depreciations->firstWhere('year', $year);
                        @endphp
                        <td>{{ $dep?->end_value ?? 0 }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>   
</html>