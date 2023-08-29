@extends((Auth::user()->D_role == 2) ? 'layouts.Template' : 'layouts.UserTemplate')

@section('content')

<link href="{{ asset('css/Pos.css') }}" rel="stylesheet">

@include('toastr.toastr')

<div class="body">
    <div class="row">
        <div class="col-md-6 col-lg-5">
            <div class="card Barcode">
                <div class="card-header">
                    Scan By Barcode
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <!-- <div style="width:300px;" id="reader"></div> -->
                            <div id="camera"></div>

                        </div>
                        <div class="col" style="padding:30px;">
                            <!-- <h4>SCAN RESULT</h4>
                            <div id="result">Result Here</div> -->
                        </div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{route('addPos')}}" id="addPos" method="post" enctype="multipart/form-data" onsubmit="return validateForm(event)">
                        @csrf
                        <input type="hidden" name="order_products" id="orderProducts" value="[]">
                        <div class="table-data">
                            <div class="order">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Amount</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="addProduct">

                                    </tbody>
                                </table>
                            </div>


                            <table>
                                <thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="text-align: center; font-size: 1.3rem;">Total</td>
                                        <td class="rowShowTotal">RM<input type="text" id="showtotal" name="showtotal" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: center; font-size: 1.3rem;">Cash</td>
                                        <td class="rowShowTotal">RM<input type="text" id="receiveCash" name="receiveCash" placeholder="0.00"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: center; font-size: 1.3rem;">Change</td>
                                        <td class="rowShowTotal">RM<input type="text" id="Cashback" name="Cashback" readonly></td>
                                    </tr>
                                </tbody>
                            </table>


                            <div class="line">
                                <h5>Payment Method</h5>

                                <div class="selectPayment">
                                    <input type="radio" id="cash" name="payment_method" value="Cash">
                                    <label for="cash">Cash</label><br>
                                    <input type="radio" id="creditcard" name="payment_method" value="Credit Card">
                                    <label for="creditcard">Credit Card</label><br>
                                    <input type="radio" id="ewallet" name="payment_method" value="E-wallet">
                                    <label for="ewallet">E-wallet</label>
                                </div>

                                <br>

                                <div class="inputBox">
                                    <h5>Customer Info</h5>
                                    <input type="text" id="cusPhone" name="cusPhone" class="input">
                                    <span>Customer Phone</span>

                                </div><span class="text-danger error-text" id="cusPhoneError"></span>
                            </div>

                            <div class="function">
                                <button type="submit" class="btn btn-danger" id="pospay">Pay</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-7">
            <div class="card card-1">
                <div class="function-2">
                    <button class="btn btn-primary" onclick="PrintReceiptContent('print')">Print</button>
                    <div class="searchBar">
                        <span class="material-symbols-outlined">
                            search
                        </span>
                        <input type="text" class="search" placeholder="Search something...">
                    </div>
                </div>
            </div>

            <div class="card card-2" id="card-2">
                @include('Paginate.option')
            </div>
        </div>
    </div>
</div>

<div class="modal">
    <div id="print">
        @include('admin.Receipt')
    </div>
</div>


<!-- Credit card form -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Pay by Credit Card</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" enctype="multipart/form-data" id="creditForm">
                <div class="modal-body">
                    <div class="container">
                        <div class="card">
                            <div class="card-header">
                                <div class="row" style="align-items: center;">
                                    <div class="col-md-6">
                                        <span>CREDIT/DEBIT CARD PAYMENT</span>
                                    </div>
                                    <div class="col-md-6 text-end" style="margin-top: -5px;">
                                        <img src="https://img.icons8.com/color/36/000000/visa.png">
                                        <img src="https://img.icons8.com/color/36/000000/mastercard.png">
                                        <img src="https://img.icons8.com/color/36/000000/amex.png">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="height: 350px">
                                <div class="form-group">
                                    <label for="cc-number" class="control-label">CARD NUMBER</label>
                                    <input id="cc-number" type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;">
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">CARD EXPIRY</label>
                                            <input id="cc-exp" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp" placeholder="&bull;&bull; / &bull;&bull;">
                                        </div>


                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cc-cvc" class="control-label">CARD CVC</label>
                                            <input id="cc-cvc" type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="&bull;&bull;&bull;&bull;">
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label class="control-label">CARD HOLDER NAME</label>
                                    <input type="text" class="input-lg form-control">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" id="creditpay">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const existingCustomerPhones = JSON.parse('{!! json_encode($existingCustomerPhones)!!}');
    var audioFileUrl = "{{ asset('audio/barcode.wav') }}";
</script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="{{ asset('js/Pos.js') }}"></script>
<script src="{{ asset('js/All.js') }}"></script>



@endsection