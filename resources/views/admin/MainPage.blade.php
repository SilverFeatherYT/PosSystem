@extends('layouts.Template')
@section('content')

@include('toastr.toastr')

<link href="{{ asset('css/MainPage.css') }}" rel="stylesheet">

<div class="body">

    <div class="date">
        <form id="dateForm" action="{{ route('viewMain') }}" method="GET">
            <input type="date" name="date" value="{{ request('date') }}">
        </form>
    </div>
    <div class="date">
        <form id="monthForm" action="{{ route('Main.filterMonth') }}" method="GET">
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
    <div class="date">
        <form id="yearForm" action="{{ route('Main.filterYear') }}" method="GET">
            @csrf
            <select id="year" name="year">
                <option value="0">Select Year</option>
                @php
                $currentYear = date('Y');
                @endphp
                @for ($i = $currentYear; $i >= 2000; $i--)
                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </form>
    </div>

    <div class="insights">
        <a href="#" class="sales">

            <div class="middle">
                <div class="left">
                    <h3>Total Products</h3>
                    <h1>{{ $product }}</h1>
                </div>
                <div class="">
                    <span class="material-symbols-outlined">
                        analytics
                    </span>
                </div>
            </div>
            <small>Last 24 Hours</small>
        </a>
        <a href="#" class="income">

            <div class="middle">
                <div class="left">
                    <h3>Total Income</h3>
                    <h1>RM{{ $total }}</h1>
                </div>
                <div class="">
                    <span class="material-symbols-outlined">
                        stacked_line_chart
                    </span>
                </div>
            </div>
            <small>Last 24 Hours</small>
        </a>
        <a href="#" class="expenses">

            <div class="middle">
                <div class="left">
                    <h3>Total Transaction</h3>
                    <h1>{{ $count }}</h1>
                </div>
                <div class="">
                    <span class="material-symbols-outlined">
                        bar_chart
                    </span>
                </div>
            </div>
            <small>Last 24 Hours</small>
        </a>
        <a href="#" class="customer">

            <div class="middle">
                <div class="left">
                    <h3>Total Customer</h3>
                    <h1>{{ $cusTotal }}</h1>
                </div>
                <div class="">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                </div>
            </div>
            <small>Last 24 Hours</small>
        </a>
    </div>

    <br><br>

    <div class="row">
        <div class="col-xl-6">
            <div class="recent-orders mb-4">
                <h2>Recent Orders</h2>
                <a href="{{route('viewTransaction')}}">
                    <table>
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Order ID</th>
                                <th>Payment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                            <tr class="{{ $loop->iteration > 3 ? 'hidden' : '' }}">
                                <td>{{ $transaction->D_TranCusName }}</td>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->D_TranPaymentType }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </a>
                <a href="#" id="show">Show All</a>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="recent-updates mb-4">
                <h2>Recent Updates</h2>
                <a href="{{route('viewRedeemMessage')}}">
                    <table>
                        <thead>
                            <th colspan="2">Message</th>
                        </thead>
                        <tbody>
                            @foreach ($redeemCus as $redeemMessage)
                            <tr class="{{ $loop->iteration > 3 ? 'hidden' : '' }}">
                                <td>{{ $redeemMessage->D_RedeemCusMessage }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </a>
                <a href="#" id="showUpdate">Show All</a>
            </div>
        </div>
    </div>

    <div class="row">
        <h2>Analytics</h2>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Top Sales Report
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="50"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Income Report
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var tradingData = JSON.parse('{!! json_encode($tradingData) !!}');
    var topproduct = JSON.parse('{!! json_encode($topproduct) !!}');
</script>
<script src="{{ asset('js/MainPage.js') }}"></script>


@endsection