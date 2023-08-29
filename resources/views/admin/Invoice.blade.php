@extends('layouts.Template')
@section('content')

<link href="{{ asset('css/AddProduct.css') }}" rel="stylesheet">

<div class="body">

    <div class="date">
        <form id="dateForm" action="{{ route('filterInvoiceDate') }}" method="GET">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $start_date }}">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="{{ $end_date }}">
        </form>
    </div>

    <div class="date">
        <form id="monthForm" action="{{ route('filterInvoiceMonth') }}" method="GET">
            @csrf
            <select id="month" name="month">
                <option value="0">Select Month</option>
                <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>January</option>
                <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>February</option>
                <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>March</option>
                <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>April</option>
                <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>May</option>
                <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>June</option>
                <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>July</option>
                <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>August</option>
                <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>September</option>
                <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>October</option>
                <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>December</option>
            </select>
        </form>
    </div>

    <br>

    <div class="table-data">
        <div class="order" id="order">
            @include('Paginate.invoice')
        </div>
    </div>
</div>


<script src="{{ asset('js/Add.js') }}"></script>
<script src="{{ asset('js/Invoice.js') }}"></script>

@endsection