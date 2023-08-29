@extends('layouts.Template')
@section('content')

<link href="{{ asset('css/AddProduct.css') }}" rel="stylesheet">


<div class="body">

    @include('toastr.toastr')

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Product</h3>
                <div class="search">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                    <input type="text" id="searchInput" class="searchInput" placeholder="Search something...">
                </div>
                <div class="excel">
                    <a href="" data-bs-toggle="modal" data-bs-target="#uploadFile">
                        <label for="file" class="file-label">
                            <i class="bx bxs-cloud-upload"></i>
                            <span class="hover-text">Upload Excel File</span>
                        </label>
                    </a>
                    <form action="{{ route('Product.export') }}" method="GET">
                        <button type="submit" class="file-label">
                            <i class='bx bxs-cloud-download'></i>
                            <span class="hover-text">Export File</span>
                        </button>

                    </form>
                </div>
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa fa-plus"></i>&nbsp;Add</a>
                <form action="{{ route('deleteAllProduct') }}" method="POST" id="deleteAllForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="selectedProducts" name="selectedProducts">
                    <button type="submit" class="btn btn-danger" id="deleteAllButton" style="display: none;">
                        <i class="fa fa-trash"></i>&nbsp;Delete All
                    </button>
                </form>
            </div>
            <table>
                <thead>
                    @csrf
                    <tr>
                        <th><input type="checkbox" id="checkboxth"></th>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Brand</th>
                    </tr>
                </thead>
                <tbody id="table">

                    @foreach ($products as $product)
                    <tr>
                        <td><input type="checkbox" id="checkboxtd" class="checkboxtd" data-product-id="{{ $product->id }}"></td>
                        <td href="#editModal{{$product->id}}" data-bs-toggle="modal">{{ $product->D_ProductID }}</td>
                        <td href="#editModal{{$product->id}}" data-bs-toggle="modal"><img src="{{asset('images/'.$product->D_ProductImage)}}" style="height: auto; width: 70px; object-fit:cover;"></td>
                        <td href="#editModal{{$product->id}}" data-bs-toggle="modal">{{ $product->D_ProductName }}</td>
                        <td href="#editModal{{$product->id}}" data-bs-toggle="modal">{{ $product->D_ProductQty }}</td>
                        <td href="#editModal{{$product->id}}" data-bs-toggle="modal">RM {{ $product->D_ProductPrice }}</td>
                        <td href="#editModal{{$product->id}}" data-bs-toggle="modal">{{ $product->D_ProductBrand }}</td>
                        <td>
                            <div class="optionBtn" style="float: right; text-align:center;">
                                <a href="#editModal{{$product->id}}" data-bs-toggle="modal" class="btn btn-warning btn-xs"><i class='fa fa-edit'></i></a>
                                <a href="#deleteModal{{$product->id}}" data-bs-toggle="modal" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i>&nbsp;</a>
                            </div>
                        </td>
                    </tr>

                    <!-- EditProduct Modal -->
                    <div class="modal fade" id="editModal{{$product->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Product</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('updateProduct')}}" method="post" enctype="multipart/form-data" id="updateForm">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Product ID</label>
                                            <input type="hidden" name="id" value="{{$product->id}}">
                                            <input id="productID" type="text" class="form-control" name="productID" value="{{$product->D_ProductID}}" autocomplete="valid" autofocus>
                                            <span class="text-danger error-text productID_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <input id="productName" type="text" class="form-control" name="productName" value="{{$product->D_ProductName}}" autocomplete="valid" autofocus>
                                            <span class="text-danger error-text productName_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" id="productQty" name="productQty" value="{{$product->D_ProductQty}}" class="form-control">
                                            <span class="text-danger error-text productQty_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Min Quantity</label>
                                            <input type="number" id="minProductQty" name="minProductQty" value="{{ $product->D_MinProductQty }}" class="form-control" autofocus>
                                            <span class="text-danger error-text minProductQty_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" step="0.01" id="productPrice" name="productPrice" value="{{$product->D_ProductPrice}}" class="form-control">
                                            <span class="text-danger error-text productPrice_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <input type="text" id="productBrand" name="productBrand" value="{{$product->D_ProductBrand}}" class="form-control">
                                            <span class="text-danger error-text productBrand_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" id="productImage" name="productImage">
                                            <span class="text-danger error-text productImage_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Barcode</label>
                                            <input type="text" name="barcode" value="{{$product->D_Barcode}}" class="form-control">
                                            <svg class="form-control" id="barcode{{$product->id}}" style="margin-top: 5px;"></svg>
                                            <span class="text-danger error-text barcode_error"></span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- DeleteProduct Modal -->
                    <div class="modal fade" id="deleteModal{{$product->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Product</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('deleteProduct',[$product->id])}}" method="get" enctype="multipart/form-data" id="deleteForm">
                                    <div class="modal-body">
                                        <h2>Confirm delete product?</h2>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate">
                {{$products->links()}}
            </div>
        </div>
    </div>
</div>


<!-- AddProduct Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('addProduct')}}" method="post" enctype="multipart/form-data" id="addForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Product ID</label>
                        <input id="productID" type="text" class="form-control" name="productID" autocomplete="valid" autofocus>
                        <span class="text-danger error-text productID_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input id="productName" type="text" class="form-control " name="productName" value="{{ old('productName') }}" autocomplete="valid" autofocus required>
                        <span class="text-danger error-text productName_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" id="productQty" name="productQty" class="form-control" autofocus required>
                        <span class="text-danger error-text productQty_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Min Quantity</label>
                        <input type="number" id="minProductQty" name="minProductQty" class="form-control" autofocus>
                        <span class="text-danger error-text minProductQty_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" id="productPrice" name="productPrice" class="form-control" autofocus required>
                        <span class="text-danger error-text productPrice_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" id="productBrand" name="productBrand" class="form-control" autofocus>
                        <span class="text-danger error-text productBrand_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" id="productImage" name="productImage">
                        <span class="text-danger error-text productImage_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="text" name="barcode" class="form-control">
                        <span class="text-danger error-text barcode_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- UploadFile Modal -->
<div class="modal fade" id="uploadFile" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h1 class="modal-title fs-5" id="uploadModalLabel">Upload File</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Product.import') }}" method="post" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="modal-body">
                    <input type="file" id="file" name="file" class="form-control ">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload File</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{ asset('js/Add.js') }}"></script>
<script src="{{ asset('js/GenerateBarcode.js') }}"></script>

@foreach ($products as $product)
<script>
    JsBarcode("#barcode{{$product->id}}", "{{$product->D_Barcode}}", {
        format: "UPC",
        height: 40,
        displayValue: true
    });
</script>
@endforeach

@endsection