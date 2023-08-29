<br>
@csrf
<div class="option" id="option">
    @foreach ($products as $product)
    <div class="select" value="{{$product}}" data-price="{{$product->D_ProductPrice}}">
        <img class="productImg" src="{{asset('images/'.$product->D_ProductImage)}}">
        <div class="selectTitle">{{ $product->D_ProductName }}({{ $product->D_ProductQty }})</div>
    </div>
    @endforeach
</div>
<div class="paginate">
    {{$products->links()}}
</div>
</div>