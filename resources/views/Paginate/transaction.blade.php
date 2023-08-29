@csrf
<div class="head">
    <h3>Transaction</h3>
    <div class="search">
        <span class="material-symbols-outlined">
            search
        </span>
        <input type="text" id="searchInput" class="searchInput" placeholder="Search something...">
    </div>
    <div class="excel">
        <form action="{{ route('Transaction.export') }}" method="GET">
            <input type="hidden" name="start_date" value="{{ $start_date }}">
            <input type="hidden" name="end_date" value="{{ $end_date }}">
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="payment" value="{{ $payment }}">
            <button type="submit" class="file-label">
                <i class='bx bxs-cloud-download'></i>
                <span class="hover-text">Export File</span>
            </button>
        </form>
    </div>
</div>
<table>
    <thead>
        @csrf
        <tr>
            <th>#</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
            <th>Payment Type</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody id="table">
        @foreach ($transactions as $transaction)
        <tr>
            <td>{{ $transaction->D_TranID }}</td>
            <td>{{ $transaction->D_TranCusName }}</td>
            <td>{{ $transaction->D_TranProductName }}</td>
            <td>{{ $transaction->D_TranProductPrice }}</td>
            <td>{{ $transaction->D_TranProductQty }}</td>
            <td>{{ $transaction->D_TranPaymentType }}</td>
            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="paginate">
    {{ $transactions->appends(['start_date' => $start_date, 'end_date' => $end_date, 'month' => $month, 'payment' => $payment])->links() }}
</div>