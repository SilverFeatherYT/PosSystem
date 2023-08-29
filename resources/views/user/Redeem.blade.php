@extends((Auth::user()->D_role == 2) ? 'layouts.Template' : 'layouts.UserTemplate')
@section('content')


<title>Redeem</title>
<link href="{{ asset('css/CusRedeem.css') }}" rel="stylesheet">

<br>

@include('toastr.toastr')

<div class="body">

    <div class="welcome-msg">
        <h4 id="username"> Welcome, {{ Auth::user()->name }}</h4>
        @if ($customer)
        <h4 id="userpoints"><b>This is your {{ $customer->D_CusMemberPoint ?? 0 }} point{{ $customer->D_CusMemberPoint != 1 ? 's' : '' }}!</b></h4>
        @else
        <h4 id="userpoints"><b>This is your 0 points! You are not Customer</b></h4>
        @endif
    </div>

    <div class="gallery">
        @foreach ($items as $item)
        <form action="{{ route('cusRedeemItem') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($customer)
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            @endif
            <a href="#redeemModal{{$item->id}}" class=" items" data-bs-toggle="modal">
                <img src="{{asset('images/'.$item->D_RedeemItemImage)}}">
                <h3>{{ $item->D_RedeemItemName }}</h3>
                <p>Item left: {{ $item->D_RedeemItemQty }}</p>
                <h6>{{ $item->D_RedeemItemPoint }} point</h6>
                <button type="submit" class="buy-1">Redeem Now</button>
            </a>


            <div class="modal fade" id="redeemModal{{$item->id}}" tabindex="-1" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h1 class="modal-title fs-5">Redeem Option</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="get" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="selectItem">
                                    <label for="">Select Item: {{ $item->D_RedeemItemName }}</label>
                                </div>
                                <div class="quantity-controls">
                                    <label for="quantity">Quantity:</label>
                                    <button type="button" class="minus btn btn-danger" data-item-id="{{ $item->id }}"><i class="fas fa-minus"></i></button>
                                    <input type="text" name="quantity" id="quantity_{{ $item->id }}" value="1" min="1">
                                    <button type="button" class="plus btn btn-danger" data-item-id="{{ $item->id }}"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Comfirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </form>
        @endforeach
    </div>
    <div class="paginate">
        {{$items->links()}}
    </div>

</div>

<script src="{{ asset('js/CusRedeem.js') }}"></script>

@endsection