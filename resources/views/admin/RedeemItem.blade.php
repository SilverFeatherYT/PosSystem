@extends('layouts.Template')
@section('content')

<link href="{{ asset('css/AddProduct.css') }}" rel="stylesheet">

<div class="body">

    @include('toastr.toastr')

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Redeem Item</h3>
                <div class="search">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                    <input type="text" id="searchInput" class="searchInput" placeholder="Search something...">
                </div>
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa fa-plus"></i>&nbsp;Add</a>
                <form action="{{ route('deleteAllItem') }}" method="POST" id="deleteAllForm">
                    @csrf
                    @method('DELETE')
                    <!-- Add a hidden input field to hold the selected product IDs -->
                    <input type="hidden" id="selectedItems" name="selectedItems">
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
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Redeem Point</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="table">

                    @foreach ($items as $item)
                    <tr>
                        <td><input type="checkbox" id="checkboxtd" class="checkboxtd" data-item-id="{{ $item->id }}"></td>
                        <td href="#editModal{{$item->id}}" data-bs-toggle="modal">{{ $item->id }}</td>
                        <td href="#editModal{{$item->id}}" data-bs-toggle="modal"><img src="{{asset('images/'.$item->D_RedeemItemImage)}}" style="height: auto; width: 100px; object-fit:cover;"></td>
                        <td href="#editModal{{$item->id}}" data-bs-toggle="modal">{{ $item->D_RedeemItemName }}</td>
                        <td href="#editModal{{$item->id}}" data-bs-toggle="modal">{{ $item->D_RedeemItemQty }}</td>
                        <td href="#editModal{{$item->id}}" data-bs-toggle="modal">{{ $item->D_RedeemItemPoint }}</td>
                        <td href="#editModal{{$item->id}}" data-bs-toggle="modal">
                            <span class="bg-{{$item->D_RedeemItemStatus === 'Available' ? 'green' : 'red'}}-500 text-white py-1 px-3 rounded-full">{{ $item->D_RedeemItemStatus }}</span>
                        </td>
                        <td>
                            <div class="optionBtn" style="float: right; text-align:center;">
                                <a href="#editModal{{$item->id}}" data-bs-toggle="modal" class="btn btn-warning btn-xs"><i class='fa fa-edit'></i></a>
                                <a href="#deleteModal{{$item->id}}" data-bs-toggle="modal" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i>&nbsp;</a>
                            </div>
                        </td>
                    </tr>

                    <!-- EditProduct Modal -->
                    <div class="modal fade" id="editModal{{$item->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Item</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('updateRedeemItem')}}" method="post" enctype="multipart/form-data" id="updateForm">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">Item ID</label>
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <input id="itemID" type="text" class="form-control" name="itemID" value="{{$item->D_RedeemItemID}}" autocomplete="itemID" autofocus>
                                            <span class="text-danger error-text itemID_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Item Name</label>
                                            <input id="itemName" type="text" class="form-control" name="itemName" value="{{$item->D_RedeemItemName}}" autocomplete="itemName" autofocus>
                                            <span class="text-danger error-text itemName_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Quantity</label>
                                            <input type="number" id="itemQty" name="itemQty" value="{{$item->D_RedeemItemQty}}" class="form-control">
                                            <span class="text-danger error-text itemQty_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Redeem Points</label>
                                            <input type="number" id="itemPoints" name="itemPoints" value="{{$item->D_RedeemItemPoint}}" class="form-control">
                                            <span class="text-danger error-text itemPoints_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Image</label>
                                            <input type="file" class="form-control" id="itemImage" name="itemImage">
                                            <span class="text-danger error-text itemImage_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="itemStatus" id="itemStatus" class="form-control">
                                                <option value="Available" {{ $item->D_RedeemItemStatus === 'Available' ? 'selected' : '' }}>Available</option>
                                                <option value="Unavailable" {{ $item->D_RedeemItemStatus === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                                            </select>
                                            <span class="text-danger error-text itemStatus_error"></span>
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
                    <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Item</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('deleteRedeemItem',[$item->id])}}" method="get" enctype="multipart/form-data" id="deleteForm">
                                    <div class="modal-body">
                                        <h2>Confirm delete item?</h2>
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
                {{$items->links()}}
            </div>
        </div>
    </div>
</div>


<!-- AddProduct Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('addRedeemItem')}}" method="post" enctype="multipart/form-data" id="addForm">
                <div class="modal-body">
                    @csrf

                    <!-- <ul id="save_msgList"></ul> -->
                    <div class="form-group">
                        <label for="">Item ID</label>
                        <input id="itemID" type="text" class="form-control" name="itemID" autocomplete="itemID" autofocus>
                        <span class="text-danger error-text itemID_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Item Name</label>
                        <input id="itemName" type="text" class="form-control " name="itemName" value="{{ old('itemName') }}" autocomplete="itemName" autofocus selectedUser>
                        <span class="text-danger error-text itemName_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" id="itemQty" name="itemQty" class="form-control" autofocus selectedUser>
                        <span class="text-danger error-text itemQty_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Redeem Points</label>
                        <input type="number" id="itemPoints" name="itemPoints" class="form-control" autofocus selectedUser>
                        <span class="text-danger error-text itemPoints_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Image</label>
                        <input type="file" class="form-control" id="itemImage" name="itemImage">
                        <span class="text-danger error-text itemImage_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="itemStatus" id="itemStatus" class="form-control">
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                        <span class="text-danger error-text itemStatus_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Items</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/Redeem.js') }}"></script>

@endsection