@extends('layouts.Template')
@section('content')

<link href="{{ asset('css/AddProduct.css') }}" rel="stylesheet">

<div class="body">

    @include('toastr.toastr')

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Customer List</h3>
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
                    <form action="{{ route('Customer.export') }}" method="GET">
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
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Member Point</th>
                    </tr>
                </thead>
                <tbody id="table">
                    @foreach ($customers as $customer)
                    <tr>
                        <td href="#editModal{{$customer->id}}" data-bs-toggle="modal">{{ $customer->D_CusID }}</td>
                        <td href="#editModal{{$customer->id}}" data-bs-toggle="modal">{{ $customer->name }}</td>
                        <td href="#editModal{{$customer->id}}" data-bs-toggle="modal">{{ $customer->email }}</td>
                        <td href="#editModal{{$customer->id}}" data-bs-toggle="modal">{{ $customer->phone }}</td>
                        <td href="#editModal{{$customer->id}}" data-bs-toggle="modal">{{ $customer->D_CusMemberPoint }}</td>
                        <td>
                            <div class="optionBtn" style="float: right;">
                                <a href="#editModal{{$customer->id}}" data-bs-toggle="modal" class="btn btn-warning btn-xs"><i class='fa fa-edit'></i></a>
                            </div>
                        </td>
                    </tr>

                    <!-- EditProduct Modal -->
                    <div class="modal fade" id="editModal{{$customer->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Customer</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('updateCustomer')}}" method="post" enctype="multipart/form-data" id="updateForm">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="{{$customer->id}}">
                                        <input type="hidden" name="user_id" value="{{$customer->user_id}}">
                                        <div class="form-group">
                                            <label>Member Point</label>
                                            <input type="number" id="cusMemberPoint" name="cusMemberPoint" value="{{$customer->D_CusMemberPoint}}" class="form-control">
                                            <span class="text-danger error-text cusMemberPoint_error"></span>
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

                    @endforeach
                </tbody>
            </table>
            <div class="paginate">
                {{$customers->links()}}
            </div>
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
            <form action="{{ route('Customer.import') }}" method="post" enctype="multipart/form-data" id="uploadForm">
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

<script src="{{ asset('js/Customer.js') }}"></script>

@endsection