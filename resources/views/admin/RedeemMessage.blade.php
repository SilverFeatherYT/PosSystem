@extends('layouts.Template')
@section('content')

<link href="{{ asset('css/AddProduct.css') }}" rel="stylesheet">

<div class="body">

    @include('toastr.toastr')

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Redeem Message</h3>
                <div class="search">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                    <input type="text" id="searchInput" class="searchInput" placeholder="Search something...">
                </div>
            </div>
            <table>
                <thead>
                    @csrf
                    <tr>
                        <th><input type="checkbox" id="checkboxth"></th>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Message</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Redeem Date</th>
                    </tr>
                </thead>
                <tbody id="table">

                    @foreach ($messages as $message)
                    <tr>
                        <td><input type="checkbox" id="checkboxtd" class="checkboxtd"></td>
                        <td href="#editModal{{$message->id}}" data-bs-toggle="modal">{{ $message->id }}</td>
                        <td href="#editModal{{$message->id}}" data-bs-toggle="modal">{{ $message->D_RedeemCusName }}</td>
                        <td href="#editModal{{$message->id}}" data-bs-toggle="modal">{{ $message->D_RedeemCusMessage }}</td>
                        <td href="#editModal{{$message->id}}" data-bs-toggle="modal">{{ $message->D_RedeemQuantity }}</td>
                        <td href="#editModal{{$message->id}}" data-bs-toggle="modal">
                            <span class="bg-{{ $message->D_RedeemStatus === 'Pending' ? 'red' : 'green' }}-500 text-white py-1 px-3 rounded-full">{{ $message->D_RedeemStatus }}</span>
                        </td>
                        <td href="#editModal{{$message->id}}" data-bs-toggle="modal">{{ $message->updated_at }}</td>
                        <td>
                            <div class="optionBtn" style="float: right; text-align:center;">
                                <a href="#editModal{{$message->id}}" data-bs-toggle="modal" class="btn btn-warning btn-xs"><i class='fa fa-edit'></i></a>
                                <a href="#deleteModal{{$message->id}}" data-bs-toggle="modal" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i>&nbsp;</a>
                            </div>
                        </td>
                    </tr>

                    <!-- EditProduct Modal -->
                    <div class="modal fade" id="editModal{{$message->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Update Status</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('updateMessage')}}" method="post" enctype="multipart/form-data" id="updateForm">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="message_id" value="{{ $message->id }}">
                                        <label for="status">Status:</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="Pending" {{ $message->D_RedeemStatus === 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Collected" {{ $message->D_RedeemStatus === 'Collected' ? 'selected' : '' }}>Collected</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate">
                {{$messages->links()}}
            </div>
        </div>
    </div>
</div>



<script src="{{ asset('js/Redeem.js') }}"></script>

@endsection