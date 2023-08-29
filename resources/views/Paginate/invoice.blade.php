@csrf
<div class="head">
    <h3>Invoice</h3>
    <div class="search">
        <span class="material-symbols-outlined">
            search
        </span>
        <input type="text" id="searchInput" class="searchInput" placeholder="Search something...">
    </div>
    <div class="excel">
        <form action="{{ route('Invoice.export') }}" method="GET">
            <input type="hidden" name="start_date" value="{{ $start_date }}">
            <input type="hidden" name="end_date" value="{{ $end_date }}">
            <input type="hidden" name="month" value="{{ $month }}">
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
            <th>Transaction ID</th>
            <th>Total Bill</th>
            <th>Cash</th>
            <th>Change</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody id="table">
        @foreach ($invoices as $invoice)
        <tr>
            <td href="#exampleModalLong{{$invoice->D_RecID}}" data-bs-toggle="modal">{{ $invoice->D_RecID }}</td>
            <td href="#exampleModalLong{{$invoice->D_RecID}}" data-bs-toggle="modal">RM{{ $invoice->D_RecTotal }}</td>
            <td href="#exampleModalLong{{$invoice->D_RecID}}" data-bs-toggle="modal">RM{{ $invoice->D_RecCash }}</td>
            <td href="#exampleModalLong{{$invoice->D_RecID}}" data-bs-toggle="modal">RM{{ $invoice->D_RecChange }}</td>
            <td href="#exampleModalLong{{$invoice->D_RecID}}" data-bs-toggle="modal">{{ $invoice->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="paginate">
    {{ $invoices->appends(['start_date' => $start_date, 'end_date' => $end_date, 'month' => $month])->links() }}
</div>


@foreach ($invoices as $invoice)
<!-- Receipt Modal -->
<div class="modal fade" id="exampleModalLong{{$invoice->D_RecID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @include('admin.ReceiptInvoice')
            </div>
        </div>
    </div>
</div>
@endforeach