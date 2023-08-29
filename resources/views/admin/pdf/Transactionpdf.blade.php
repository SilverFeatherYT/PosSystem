<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <h1>{{ $title }}</h1>

    @if ($start_date && $end_date)
    <p>Range Date: {{ $start_date }} to {{ $end_date }}</p>
    <p>Download Date: {{ $date }}</p>
    @else
    <p>Download Date: {{ $date }}</p>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
            <th>Payment Type</th>
            <th>Date</th>
        </tr>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->D_TranCusName }}</td>
            <td>{{ $transaction->D_TranProductName }}</td>
            <td>{{ $transaction->D_TranProductPrice }}</td>
            <td>{{ $transaction->D_TranProductQty }}</td>
            <td>{{ $transaction->D_TranPaymentType }}</td>
            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>