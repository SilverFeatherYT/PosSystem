<link href="{{ asset('css/Receipt.css') }}" rel="stylesheet">

<div class="wrapper">
    <div class="table-data">
        <div class="order">
            <div class="head">
                <div id="printed_content">
                    <center id="logo">
                        <div class="logo"></div>
                        <div class="info"></div>
                        <img src="{{asset('images/logo.png')}}" alt="" width="120">
                        <h2>Contact Us</h2>
                        <p>
                            PTD 64888, Jalan Selatan Utama, KM 15, Off, Skudai Lbh, 81300 Skudai, Johor
                            <br>
                            Email: possystem1124@gmail.com
                            <br>
                            Tel: 01123548562
                            <br>
                        <h2><b>Invoice</b></h2>
                        </p>
                    </center>
                </div>
            </div>

            <div class="bot">
                <div id="table">
                    <div class="form-group datepicker-block label-sticky">
                        <label>Date: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</label>
                    </div>
                    <div class="form-group datepicker-block label-sticky">
                        <label>Customer Name: </label>
                    </div>
                    <div class="form-group datepicker-block label-sticky">
                        <label>Pay By: </label>
                    </div>
                    <table>
                        @csrf
                        <thead>
                            <hr>
                            <tr class="tabletitle">
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>

                        </thead>

                        <tbody>
                            @foreach ($receipts as $receipt)
                            <tr>
                                <td>{{ $receipt->prodname }}</td>
                                <td>{{ $receipt->prodqty }}</td>
                                <td>{{ $receipt->prodprice }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <hr>

                    <b>Total: RM{{ isset($receipt) ? $receipt->D_RecTotal : '0.00'}}</b>
                    <br>
                    <b>SST(6%):</b>
                    <br>
                    <b>Service Charge:</b>
                    <br>
                    <b>Rounding Adj:</b>
                    <br>
                    <hr>
                    <b>Net Total(RM):</b>
                    <hr>
                    <b>Cash: RM{{ isset($receipt) ? $receipt->D_RecCash : '0.00' }}</b>
                    <br>
                    <b>Change: RM{{ isset($receipt) ? $receipt->D_RecChange : '0.00'}}</b>

                    <hr>
                </div>
            </div>
            <center>
                <div class="legalcopy">
                    <p class="legal"><strong>**Thank you for shopping at our store**</strong><br>
                    </p>
                </div>
            </center>
        </div>
    </div>
</div>